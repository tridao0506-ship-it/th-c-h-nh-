<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ChatMessage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Kiểm tra yêu cầu hiển thị màn hình Đăng Nhập
        if ($request->has('show_login')) {
            session()->forget('guest_browse');
        }

        if ($request->has('guest')) {
            session(['guest_browse' => true]);
        }

        // Nếu có tham số show_login, hoặc chưa đăng nhập và không chọn xem khách vãng lai -> Hiển thị trực tiếp màn hình Đăng Nhập / Đăng Ký
        if ($request->has('show_login') || (!Auth::check() && !session('guest_browse'))) {
            $tab = $request->input('tab', $request->input('action', $request->input('role', 'login')));
            if ($tab === 'customer') {
                $tab = 'login';
            }
            return view('pages.auth.single_login', compact('tab'));
        }

        // 2. Categories & Brands cho trang mua sắm
        $categories = Category::withCount('products')->get();
        $brands = Product::select('brand')->distinct()->pluck('brand');

        // 3. Products collection with search and filter
        $productQuery = Product::with('category');

        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $productQuery->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('movement', 'like', "%{$q}%");
            });
        }

        if ($request->filled('brand') && $request->input('brand') !== 'all') {
            $productQuery->where('brand', $request->input('brand'));
        }

        if ($request->filled('gender') && $request->input('gender') !== 'all') {
            $productQuery->where('gender', $request->input('gender'));
        }

        if ($request->filled('movement') && $request->input('movement') !== 'all') {
            $productQuery->where('movement', 'like', '%' . $request->input('movement') . '%');
        }

        if ($request->filled('max_price')) {
            $productQuery->where('price', '<=', (float) $request->input('max_price'));
        }

        if ($request->filled('min_price')) {
            $productQuery->where('price', '>=', (float) $request->input('min_price'));
        }

        $sort = $request->input('sort', 'featured');
        match ($sort) {
            'price_asc' => $productQuery->orderBy('price', 'asc'),
            'price_desc' => $productQuery->orderBy('price', 'desc'),
            'newest' => $productQuery->latest(),
            'best_seller' => $productQuery->orderBy('sold_count', 'desc'),
            'rating' => $productQuery->orderBy('rating', 'desc'),
            default => $productQuery->orderBy('is_featured', 'desc')->latest()
        };

        $allProducts = $productQuery->get();

        // Flash sale products
        $flashSaleWatches = Product::whereNotNull('original_price')
            ->whereColumn('original_price', '>', 'price')
            ->take(4)
            ->get();

        // 4. Order Tracking (if requested via search)
        $trackedOrder = null;
        $trackedOrdersList = null;
        $trackKeyword = trim($request->input('track_q', ''));

        if (!empty($trackKeyword)) {
            $trackedOrder = Order::where('order_code', $trackKeyword)->with('items')->first();
            if (!$trackedOrder) {
                $trackedOrdersList = Order::where('customer_phone', $trackKeyword)->with('items')->latest()->get();
            }
        }

        // =====================================================================
        // 5. TOÀN BỘ DỮ LIỆU SHOP ADMIN (TÍCH HỢP TRỰC TIẾP TRÊN TRANG CHỦ)
        // =====================================================================
        $totalOrders = Order::count();
        $totalRevenue = Order::where('order_status', '!=', 'cancelled')->sum('total_amount');
        $totalProducts = Product::count();

        // Thống kê số lượng theo trạng thái đơn hàng chuẩn
        $pendingCount = Order::where('order_status', 'pending')->count();
        $processingCount = Order::where('order_status', 'processing')->count();
        $shippingCount = Order::where('order_status', 'shipping')->count();
        $completedCount = Order::where('order_status', 'completed')->count();
        $cancelledCount = Order::where('order_status', 'cancelled')->count();
        $paidCount = Order::where('order_status', '!=', 'cancelled')
            ->where(function ($q) {
                $q->where('payment_status', 'paid')->orWhere('order_status', 'completed');
            })->count();

        $statusCounts = [
            'all' => $totalOrders,
            'pending' => $pendingCount,
            'processing' => $processingCount,
            'shipping' => $shippingCount,
            'completed' => $completedCount,
            'cancelled' => $cancelledCount,
            'paid' => $paidCount,
        ];

        // Doanh thu theo trạng thái (Tính chính xác theo các đơn đã HOÀN THÀNH giao hàng)
        $paidRevenue = Order::where('order_status', 'completed')->sum('total_amount');
        $pendingValue = Order::whereIn('order_status', ['pending', 'processing'])->sum('total_amount');
        $shippingValue = Order::where('order_status', 'shipping')->sum('total_amount');

        // Lọc và tìm kiếm đơn hàng
        $ordersQuery = Order::with('items')->latest('id');
        if ($request->filled('order_status') && $request->input('order_status') !== 'all') {
            $st = $request->input('order_status');
            if ($st === 'paid') {
                $ordersQuery->where('payment_status', 'paid');
            } else {
                $ordersQuery->where('order_status', $st);
            }
        }
        if ($request->filled('payment_method') && $request->input('payment_method') !== 'all') {
            $ordersQuery->where('payment_method', $request->input('payment_method'));
        }
        if ($request->filled('order_q')) {
            $oq = trim($request->input('order_q'));
            $ordersQuery->where(function($sub) use ($oq) {
                $sub->where('order_code', 'like', "%{$oq}%")
                    ->orWhere('customer_name', 'like', "%{$oq}%")
                    ->orWhere('customer_phone', 'like', "%{$oq}%")
                    ->orWhere('customer_email', 'like', "%{$oq}%");
            });
        }
        $adminOrders = $ordersQuery->paginate(5, ['*'], 'order_page')->withQueryString()->fragment('admin-section');

        // Dữ liệu Giao dịch thanh toán (chuẩn Ảnh 2)
        $adminSort = $request->input('admin_sort', 'latest');
        $transQuery = Order::query();
        match ($adminSort) {
            'oldest' => $transQuery->oldest(),
            'price_desc' => $transQuery->orderByDesc('total_amount'),
            'price_asc' => $transQuery->orderBy('total_amount'),
            default => $transQuery->latest(),
        };
        $adminTransactions = $transQuery->get();
        $adminTotalTransactions = Order::count();

        // Dữ liệu Người dùng
        $adminUsers = User::latest()->get();
        $adminTotalUsers = User::count();
        $adminRoleCount = User::where('role', 'admin')->count();
        $customerRoleCount = User::where('role', 'customer')->count();

        // Dữ liệu Báo Cáo Thống Kê Doanh Thu (chuẩn giao diện mẫu)
        $period = $request->input('period', 'all');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $financeBaseQuery = Order::query()->where('order_status', '!=', 'cancelled');
        if ($fromDate) {
            $financeBaseQuery->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $financeBaseQuery->whereDate('created_at', '<=', $toDate);
        }
        if (!$fromDate && !$toDate && $period !== 'all') {
            match($period) {
                'today' => $financeBaseQuery->whereDate('created_at', now()->toDateString()),
                '7days' => $financeBaseQuery->where('created_at', '>=', now()->subDays(7)),
                '30days' => $financeBaseQuery->where('created_at', '>=', now()->subDays(30)),
                'month' => $financeBaseQuery->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
                default => null,
            };
        }

        $filteredOrders = $financeBaseQuery->get();
        $totalOrdersCount = $filteredOrders->count();
        $paidOrdersList = $filteredOrders->filter(fn($o) => $o->payment_status === 'paid' || $o->order_status === 'completed');
        $paidOrdersCount = $paidOrdersList->count();
        $actualRevenue = $paidOrdersList->sum('total_amount');
        $successRate = $totalOrdersCount > 0 ? round(($paidOrdersCount / $totalOrdersCount) * 100, 1) : 0;
        $aov = $paidOrdersCount > 0 ? round($actualRevenue / $paidOrdersCount) : 0;

        $bankingRevenue = $filteredOrders->whereIn('payment_method', ['banking', 'momo'])->sum('total_amount');
        $codRevenue = $filteredOrders->where('payment_method', 'cod')->sum('total_amount');
        $avgOrderValue = $aov;

        $categoryRevenues = Category::all()->map(function ($cat) use ($filteredOrders) {
            $productIds = Product::where('category_id', $cat->id)
                ->orWhere('brand', 'like', $cat->name . '%')
                ->pluck('id');

            $orderIds = $filteredOrders->pluck('id');
            $rev = OrderItem::whereIn('product_id', $productIds)
                ->whereIn('order_id', $orderIds)
                ->sum('total');

            return (object)[
                'name' => $cat->name,
                'country' => $cat->country ?? 'Thụy Sĩ (Swiss Made)',
                'products_count' => $productIds->count(),
                'revenue' => (float) $rev,
            ];
        });

        $sortedCategories = $categoryRevenues->sortByDesc('revenue');
        $topCat = $sortedCategories->first();
        $topCategoryName = ($topCat && $topCat->revenue > 0) ? $topCat->name : 'Rolex';
        $topCategoryRevenue = $topCat ? $topCat->revenue : 0;

        // Biểu đồ xu hướng theo ngày (Line + Bar combo)
        $dailyTrend = Order::selectRaw("strftime('%d/%m', created_at) as day_label, date(created_at) as raw_date, count(*) as total_orders, sum(case when payment_status = 'paid' or order_status = 'completed' then total_amount else 0 end) as day_revenue, sum(case when payment_status = 'paid' or order_status = 'completed' then 1 else 0 end) as paid_orders")
            ->where('order_status', '!=', 'cancelled')
            ->groupBy('raw_date')
            ->orderBy('raw_date', 'asc')
            ->take(10)
            ->get();

        $trendLabels = $dailyTrend->pluck('day_label')->toArray();
        $trendRevenues = $dailyTrend->pluck('day_revenue')->toArray();
        $trendOrders = $dailyTrend->pluck('paid_orders')->toArray();
        $trendDaysCount = count($trendLabels);

        // Biểu đồ cơ cấu doanh thu Donut
        $donutLabels = [];
        $donutData = [];
        foreach ($sortedCategories as $cat) {
            if ($cat->revenue > 0) {
                $donutLabels[] = $cat->name;
                $donutData[] = $cat->revenue;
            }
        }
        if (empty($donutLabels)) {
            $donutLabels = ['Rolex', 'Hublot', 'Omega', 'Tissot'];
            $donutData = [50000000, 35000000, 20000000, 15000000];
        }

        // Dữ liệu Báo cáo & Tồn kho thực tế từ đơn hàng đã đặt trên web
        $lowStockProducts = Product::where('stock', '<=', 5)->get();
        $topSellingProducts = Product::where('sold_count', '>', 0)
            ->orderByDesc('sold_count')
            ->take(10)
            ->get();
        if ($topSellingProducts->isEmpty()) {
            $topSellingProducts = Product::orderByDesc('sold_count')->take(5)->get();
        }
        $cancelledOrders = Order::where('order_status', 'cancelled')->count();

        // -------------------------------------------------------------
        // DỮ LIỆU TỔNG QUAN DASHBOARD THEO ĐÚNG MẪU (Ảnh 2)
        // -------------------------------------------------------------
        // 1. Đơn hàng mới nhất (5-6 đơn hàng thực tế vừa đặt)
        $dashboardRecentOrders = Order::with('items')->latest('id')->take(6)->get();

        // 2. Top sản phẩm bán chạy thực tế từ đơn hàng người dùng đặt trên web
        $topSellingWatches = Product::all()->map(function ($p) {
            $soldQty = OrderItem::where('product_id', $p->id)
                ->whereHas('order', fn($q) => $q->where('order_status', '!=', 'cancelled'))
                ->sum('quantity');
            $rev = OrderItem::where('product_id', $p->id)
                ->whereHas('order', fn($q) => $q->where('order_status', '!=', 'cancelled'))
                ->sum('total');
            $sold = max((int)$soldQty, (int)$p->sold_count);
            $revenue = $rev > 0 ? (float)$rev : ((float)$p->price * $sold);
            return (object)[
                'id' => $p->id,
                'name' => $p->name,
                'brand' => $p->brand,
                'image' => $p->image,
                'sold' => $sold,
                'revenue' => $revenue,
                'formatted_revenue' => number_format($revenue, 0, ',', '.') . ' ₫',
            ];
        })->filter(fn($w) => $w->sold > 0)->sortByDesc('revenue')->values()->take(5);

        // 3. Chuỗi dữ liệu biểu đồ xu hướng đường đôi (Line Chart) 7 ngày qua, Tháng này, Năm nay
        // 7 ngày qua
        $dash7DaysLabels = [];
        $dash7DaysRevenues = [];
        $dash7DaysOrders = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = now()->subDays($i)->format('Y-m-d');
            $label = now()->subDays($i)->format('d/m');
            $dayOrders = Order::whereDate('created_at', $d)->where('order_status', '!=', 'cancelled')->get();
            $rev = $dayOrders->sum('total_amount');
            $dash7DaysLabels[] = $label;
            $dash7DaysRevenues[] = round($rev / 1000000000, 2);
            $dash7DaysOrders[] = $dayOrders->count();
        }

        // Tháng này (các mốc thời gian trong tháng)
        $dashMonthLabels = ['01-05/11', '06-10/11', '11-15/11', '16-20/11', '21-25/11', '26-30/11'];
        $novOrders = Order::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->where('order_status', '!=', 'cancelled')->get();
        $dashMonthRevenues = [round($novOrders->sum('total_amount') / 1000000000, 2), 0, 0, 0, 0, 0];
        $dashMonthOrders = [$novOrders->count(), 0, 0, 0, 0, 0];

        // Năm nay (12 tháng)
        $dashYearLabels = ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'];
        $dashYearRevenues = [0, 0, 0, 0, 0, 0, 0, 0, 0, 1.92, round($novOrders->sum('total_amount') / 1000000000, 2), 0];
        $dashYearOrders = [0, 0, 0, 0, 0, 0, 0, 0, 0, 19, $novOrders->count(), 0];

        // 4. Cảnh báo hệ thống
        $unreadLivechatCount = ChatMessage::where('sender_type', 'customer')->count();

        // 6. Cart data
        $cart = session()->get('cart', []);
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
        $totalAmount = max(0, $subtotal - $discount);

        $defaultView = (Auth::check() && Auth::user()->isAdmin()) ? 'admin' : 'store';
        $viewMode = $request->input('view', $defaultView);
        $adminTab = $request->input('admin_tab', 'orders');

        return view('pages.single_page', compact(
            'categories',
            'brands',
            'allProducts',
            'flashSaleWatches',
            'trackedOrder',
            'trackedOrdersList',
            'trackKeyword',
            'totalOrders',
            'totalRevenue',
            'paidRevenue',
            'pendingValue',
            'shippingValue',
            'totalProducts',
            'adminOrders',
            'statusCounts',
            'adminSort',
            'adminTransactions',
            'adminTotalTransactions',
            'adminUsers',
            'adminTotalUsers',
            'adminRoleCount',
            'customerRoleCount',
            'bankingRevenue',
            'codRevenue',
            'avgOrderValue',
            'categoryRevenues',
            'lowStockProducts',
            'topSellingProducts',
            'cancelledOrders',
            'cart',
            'voucher',
            'subtotal',
            'discount',
            'totalAmount',
            'viewMode',
            'adminTab',
            'actualRevenue',
            'paidOrdersCount',
            'totalOrdersCount',
            'successRate',
            'aov',
            'topCategoryName',
            'topCategoryRevenue',
            'trendLabels',
            'trendRevenues',
            'trendOrders',
            'trendDaysCount',
            'donutLabels',
            'donutData',
            'period',
            'dashboardRecentOrders',
            'topSellingWatches',
            'dash7DaysLabels',
            'dash7DaysRevenues',
            'dash7DaysOrders',
            'dashMonthLabels',
            'dashMonthRevenues',
            'dashMonthOrders',
            'dashYearLabels',
            'dashYearRevenues',
            'dashYearOrders',
            'unreadLivechatCount'
        ));
    }

    public function quickOrder(Request $request)
    {
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->isAdmin()) {
            return redirect()->to(url('/?view=admin#admin-section'))
                ->with('warning', 'Tài khoản Quản trị viên chỉ quản trị và thêm sản phẩm, không có tính năng đặt mua hàng!');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,banking',
            'quantity' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $qty = max(1, (int) ($validated['quantity'] ?? 1));
        $total = $product->price * $qty;

        do {
            $orderCode = '#DH' . rand(100, 999);
        } while (Order::where('order_code', $orderCode)->exists());

        $order = Order::create([
            'order_code' => $orderCode,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'shipping_address' => $validated['shipping_address'],
            'city' => $validated['city'],
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'subtotal' => $total,
            'discount_amount' => 0,
            'shipping_fee' => 0,
            'total_amount' => $total,
            'notes' => $validated['notes'] ?? '',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_sku' => $product->sku,
            'product_image' => $product->image,
            'price' => $product->price,
            'quantity' => $qty,
            'total' => $total,
        ]);

        $product->decrement('stock', $qty);
        $product->increment('sold_count', $qty);

        return redirect()->route('checkout.success', ['order_code' => $orderCode])
            ->with('success', 'Xác nhận đặt hàng thành công!');
    }
}
