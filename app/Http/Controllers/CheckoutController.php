<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentTransaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->isAdmin()) {
            return redirect()->to(url('/?view=admin#admin-section'))
                ->with('warning', 'Tài khoản Quản trị viên chỉ dùng để quản trị và thêm sản phẩm, không có tính năng đặt mua hàng!');
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            // Tự động nạp sản phẩm vào giỏ để trải nghiệm tính phí GHN mượt mà, không bị gián đoạn
            $sampleProduct = Product::first();
            if ($sampleProduct) {
                $cart = [
                    $sampleProduct->id => [
                        'id' => $sampleProduct->id,
                        'name' => $sampleProduct->name,
                        'slug' => $sampleProduct->slug,
                        'brand' => $sampleProduct->brand,
                        'price' => $sampleProduct->price,
                        'quantity' => 1,
                        'image' => $sampleProduct->image,
                        'sku' => $sampleProduct->sku,
                        'weight' => 300,
                    ]
                ];
                session(['cart' => $cart]);
            }
        }

        $voucher = session()->get('voucher', null);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        if ($voucher) {
            if ($voucher['type'] === 'percent') {
                $discount = ($subtotal * $voucher['value']) / 100;
            } else {
                $discount = min($subtotal, $voucher['value']);
            }
        }

        $shippingFee = 53900; // Mặc định 53.900 VNĐ theo mẫu GHN
        $total = max(0, $subtotal - $discount + $shippingFee);

        $bankId = 'TCB';
        $accountNo = '19036789999999';
        $accountName = 'CHRONOLUX VIETNAM';
        $vietQrPreviewUrl = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-compact2.png?amount={$total}&addInfo=THANH+TOAN+DON+HANG&accountName=" . urlencode($accountName);

        $provinces = app(\App\Services\GHNService::class)->getProvinces()['data'] ?? [];

        return view('pages.checkout.index', compact('cart', 'subtotal', 'discount', 'voucher', 'shippingFee', 'total', 'vietQrPreviewUrl', 'accountNo', 'accountName', 'bankId', 'provinces'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Giỏ hàng của bạn đang trống.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:100',
            'shipping_address' => 'required|string|max:255',
            'city' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'ward' => 'nullable|string|max:100',
            'to_district_id' => 'nullable|integer',
            'to_ward_code' => 'nullable|string|max:50',
            'shipping_fee' => 'nullable|numeric|min:0',
            'shipping_distance' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:cod,banking,momo',
            'notes' => 'nullable|string|max:500',
        ]);

        $voucher = session()->get('voucher', null);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = 0;
        if ($voucher) {
            if ($voucher['type'] === 'percent') {
                $discount = ($subtotal * $voucher['value']) / 100;
            } else {
                $discount = min($subtotal, $voucher['value']);
            }
        }

        $shippingFee = (float) $request->input('shipping_fee', 53900);
        if ($shippingFee <= 0) {
            $shippingFee = 53900;
        }
        $total = max(0, $subtotal - $discount + $shippingFee);

        $orderCode = 'CL-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $order = Order::create([
            'order_code' => $orderCode,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'] ?? (auth()->check() ? auth()->user()->email : null),
            'shipping_address' => $validated['shipping_address'],
            'city' => $validated['city'] ?? $request->input('city', 'Hà Nội'),
            'district' => $validated['district'] ?? $request->input('district', 'Huyện Thạch Thất'),
            'ward' => $validated['ward'] ?? $request->input('ward', 'Xã Hữu Bằng'),
            'to_district_id' => $request->input('to_district_id'),
            'to_ward_code' => $request->input('to_ward_code'),
            'payment_method' => $validated['payment_method'],
            'payment_status' => ($validated['payment_method'] === 'momo') ? 'paid' : 'pending',
            'order_status' => ($validated['payment_method'] === 'momo') ? 'completed' : 'pending',
            'shipping_status' => 'ready_to_pick',
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'voucher_code' => $voucher ? $voucher['code'] : null,
            'shipping_fee' => $shippingFee,
            'ghn_total_fee' => (int) $shippingFee,
            'shipping_distance' => $request->input('shipping_distance', 15),
            'total_amount' => $total,
            'notes' => $validated['notes'] ?? $request->input('notes', ''),
        ]);

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'product_sku' => $item['sku'] ?? '',
                'product_image' => $item['image'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ]);

            // Update product stock and sold count
            $prod = Product::find($item['id']);
            if ($prod) {
                $prod->decrement('stock', $item['quantity']);
                $prod->increment('sold_count', $item['quantity']);
            }
        }

        // Tạo vận đơn Giao Hàng Nhanh (GHN) nếu có mã quận/phường
        if ($order->to_district_id && $order->to_ward_code) {
            try {
                $ghnOrderService = app(\App\Services\GHNOrderService::class);
                $ghnRes = $ghnOrderService->create($order, $order->payment_status === 'paid');
                if (isset($ghnRes['code']) && $ghnRes['code'] === 200 && isset($ghnRes['data']['order_code'])) {
                    $order->update([
                        'ghn_order_code' => $ghnRes['data']['order_code'],
                        'shipping_status' => 'ready_to_pick',
                    ]);
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Lỗi tạo vận đơn GHN: ' . $e->getMessage());
            }
        }

        // Ghi nhật ký giao dịch tài chính (PaymentTransaction) theo chuẩn Lab Orders
        if ($validated['payment_method'] === 'momo') {
            PaymentTransaction::create([
                'order_id' => $order->id,
                'gateway' => 'momo',
                'amount' => $order->total_amount,
                'status' => 'pending',
            ]);

            // Clear cart
            session()->forget('cart');
            session()->forget('voucher');

            return redirect()->route('user.orders.momo.start', $order);
        }

        PaymentTransaction::create([
            'order_id' => $order->id,
            'gateway' => $validated['payment_method'],
            'amount' => $order->total_amount,
            'status' => 'pending',
            'message' => ($validated['payment_method'] === 'cod') ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản VietQR',
        ]);

        // Clear cart
        session()->forget('cart');
        session()->forget('voucher');

        return redirect()->route('checkout.success', ['order_code' => $orderCode])
            ->with('success', 'Xác nhận đặt hàng thành công!');
    }

    public function success($orderCode)
    {
        $order = Order::where('order_code', $orderCode)
            ->with('items')
            ->firstOrFail();

        // Generate VietQR URL for Bank Transfer
        // Bank: Techcombank (TCB), Account: 19036789999999, Name: CHRONOLUX VIETNAM
        $bankId = 'TCB';
        $accountNo = '19036789999999';
        $accountName = 'CHRONOLUX VIETNAM';
        $amount = (int) $order->total_amount;
        $desc = 'THANH TOAN ' . $order->order_code;

        $vietQrUrl = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-compact2.png?amount={$amount}&addInfo=" . urlencode($desc) . "&accountName=" . urlencode($accountName);

        return view('pages.checkout.success', compact('order', 'vietQrUrl', 'accountNo', 'accountName', 'bankId', 'desc'));
    }
}
