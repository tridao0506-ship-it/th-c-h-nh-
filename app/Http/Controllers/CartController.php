<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->isAdmin()) {
            return redirect()->to(url('/?view=admin#admin-section'))
                ->with('warning', 'Tài khoản Quản trị viên chỉ dùng để quản trị và thêm sản phẩm, không có giỏ hàng mua hàng!');
        }

        $cart = session()->get('cart', []);
        $updated = false;
        foreach ($cart as $key => $item) {
            if (empty($item['slug']) && !empty($item['id'])) {
                $p = Product::find($item['id']);
                if ($p) {
                    $cart[$key]['slug'] = $p->slug;
                    $cart[$key]['brand'] = $p->brand;
                    $updated = true;
                }
            }
        }
        if ($updated) {
            session(['cart' => $cart]);
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

        $total = max(0, $subtotal - $discount);

        return view('pages.cart', compact('cart', 'subtotal', 'discount', 'voucher', 'total'));
    }

    public function add(Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->isAdmin()) {
            return redirect()->to(url('/?view=admin#admin-section'))
                ->with('warning', 'Tài khoản Quản trị viên chỉ dùng để quản trị và thêm sản phẩm, không có chức năng mua hàng!');
        }

        $productId = $request->input('product_id');
        $quantity = max(1, (int) $request->input('quantity', 1));

        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'sku' => $product->sku,
                'price' => $product->price,
                'image' => $product->image,
                'brand' => $product->brand,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm "' . $product->name . '" vào giỏ hàng!',
                'cart_count' => $cartCount,
            ]);
        }

        if ($request->input('redirect_to') === 'checkout' || $request->filled('buy_now')) {
            return redirect()->route('checkout.index');
        }

        return redirect()->back()->with('success', 'Đã thêm "' . $product->name . '" vào giỏ hàng!');
    }

    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = (int) $request->input('quantity');

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            if ($quantity > 0) {
                $cart[$productId]['quantity'] = $quantity;
            } else {
                unset($cart[$productId]);
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Giỏ hàng đã được cập nhật!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function clear()
    {
        session()->forget('cart');
        session()->forget('voucher');

        return redirect()->route('cart.index')->with('info', 'Giỏ hàng đã được làm trống!');
    }

    public function applyVoucher(Request $request)
    {
        $code = strtoupper(trim($request->input('voucher_code', '')));

        $validVouchers = [
            'CHRONO10' => [
                'type' => 'percent',
                'value' => 10,
                'desc' => 'Giảm 10% tổng đơn hàng (Ưu đãi ra mắt)',
            ],
            'LUXURY500' => [
                'type' => 'fixed',
                'value' => 500000,
                'desc' => 'Giảm ngay 500.000 ₫ cho mọi đơn hàng',
            ],
            'VIPWATCH' => [
                'type' => 'fixed',
                'value' => 2000000,
                'desc' => 'Giảm 2.000.000 ₫ dành cho thành viên VIP',
            ],
        ];

        if (isset($validVouchers[$code])) {
            session()->put('voucher', [
                'code' => $code,
                'type' => $validVouchers[$code]['type'],
                'value' => $validVouchers[$code]['value'],
                'desc' => $validVouchers[$code]['desc'],
            ]);
            return redirect()->route('cart.index')->with('success', 'Áp dụng mã giảm giá ' . $code . ' thành công! ' . $validVouchers[$code]['desc']);
        }

        return redirect()->route('cart.index')->with('error', 'Mã voucher không hợp lệ hoặc đã hết hạn! Thử dùng "CHRONO10" hoặc "LUXURY500".');
    }

    public function removeVoucher()
    {
        session()->forget('voucher');
        return redirect()->route('cart.index')->with('info', 'Đã hủy mã giảm giá!');
    }
}
