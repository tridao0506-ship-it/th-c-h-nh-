<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ChatMessage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            function (Request $request, Closure $next) {
                if (!Auth::check() || !Auth::user()->isAdmin()) {
                    return redirect()->route('login', ['tab' => 'admin'])
                        ->with('error', 'Khu vực quản trị chỉ dành riêng cho Quản trị viên hệ thống!');
                }
                return $next($request);
            },
        ];
    }

    /**
     * 1. Dashboard: Tổng quan hệ thống
     */
    public function dashboard()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('order_status', '!=', 'cancelled')->sum('total_amount');
        $totalProducts = Product::count();
        $recentOrders = Order::with('items')->latest('id')->take(6)->get();

        $statusCounts = [
            'pending' => Order::where('order_status', 'pending')->count(),
            'processing' => Order::where('order_status', 'processing')->count(),
            'shipping' => Order::where('order_status', 'shipping')->count(),
            'completed' => Order::where('order_status', 'completed')->count(),
        ];

        $adminTotalUsers = User::count();
        $adminRoleCount = User::where('role', 'admin')->count();
        $customerRoleCount = User::where('role', 'customer')->count();

        // 2. Top sản phẩm bán chạy thực tế
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

        // 3. Chuỗi dữ liệu biểu đồ
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

        $dashMonthLabels = ['01-05/11', '06-10/11', '11-15/11', '16-20/11', '21-25/11', '26-30/11'];
        $novOrders = Order::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->where('order_status', '!=', 'cancelled')->get();
        $dashMonthRevenues = [round($novOrders->sum('total_amount') / 1000000000, 2), 0, 0, 0, 0, 0];
        $dashMonthOrders = [$novOrders->count(), 0, 0, 0, 0, 0];

        $dashYearLabels = ['Th1', 'Th2', 'Th3', 'Th4', 'Th5', 'Th6', 'Th7', 'Th8', 'Th9', 'Th10', 'Th11', 'Th12'];
        $dashYearRevenues = [0, 0, 0, 0, 0, 0, 0, 0, 0, 1.92, round($novOrders->sum('total_amount') / 1000000000, 2), 0];
        $dashYearOrders = [0, 0, 0, 0, 0, 0, 0, 0, 0, 19, $novOrders->count(), 0];

        $unreadLivechatCount = ChatMessage::where('sender_type', 'customer')->count();
        $lowStockProducts = Product::where('stock', '<=', 5)->get();
        $categories = Category::all();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalProducts',
            'recentOrders',
            'statusCounts',
            'adminTotalUsers',
            'adminRoleCount',
            'customerRoleCount',
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
            'unreadLivechatCount',
            'lowStockProducts',
            'categories'
        ));
    }

    /**
     * 2. Sản phẩm: Danh sách đồng hồ
     */
    public function products()
    {
        $products = Product::with('category')->latest()->paginate(5);
        $categories = Category::all();

        return view('admin.products', compact('products', 'categories'));
    }

    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $stock = (int) $request->input('stock', 0);

        $product->update([
            'stock' => max(0, $stock),
            'is_featured' => $request->has('is_featured'),
        ]);

        return back()->with('success', 'Đã cập nhật tồn kho cho đồng hồ ' . $product->name);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'movement' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string|url', 
        ]);

        $product->update([
            'name' => $validated['name'],
            'brand' => $validated['brand'],
            'movement' => $validated['movement'],
            'price' => $validated['price'],
            'original_price' => $validated['original_price'],
            'stock' => $validated['stock'],
            'image' => $request->input('image'),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật thông tin đồng hồ ' . $product->name,
                'product' => $product
            ]);
        }

        return back()->with('success', 'Đã cập nhật thông tin đồng hồ ' . $product->name);
    }

    /**
     * 3. Danh mục: Thương hiệu & Nhóm sản phẩm
     */
    public function categories()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($validated['name']);
        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'country' => $validated['country'] ?? 'Thụy Sĩ',
            'description' => $validated['description'] ?? '',
            'is_featured' => true,
        ]);

        return back()->with('success', 'Đã thêm thương hiệu/danh mục mới: ' . $validated['name']);
    }

    /**
     * 4. Người dùng: Danh sách tài khoản khách hàng & admin
     */
    public function users()
    {
        $users = User::latest()->paginate(15);
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $customerCount = User::where('role', 'customer')->count();

        return view('admin.users', compact('users', 'totalUsers', 'adminCount', 'customerCount'));
    }

    public function toggleUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Không thể tự thay đổi vai trò của chính tài khoản đang đăng nhập!');
        }

        $newRole = $user->role === 'admin' ? 'customer' : 'admin';
        $user->update(['role' => $newRole]);

        return back()->with('success', 'Đã thay đổi quyền cho người dùng ' . $user->name . ' thành: ' . ($newRole === 'admin' ? 'Quản trị viên' : 'Khách hàng'));
    }

    /**
     * 5. Đơn hàng: Quản lý & Cập nhật trạng thái
     */
    public function orders(Request $request)
    {
        $totalOrders = Order::count();
        $paidRevenue = Order::where('order_status', 'completed')->sum('total_amount');
        $pendingValue = Order::whereIn('order_status', ['pending', 'processing'])->sum('total_amount');
        $shippingValue = Order::where('order_status', 'shipping')->sum('total_amount');

        $statusCounts = [
            'all' => $totalOrders,
            'pending' => Order::where('order_status', 'pending')->count(),
            'processing' => Order::where('order_status', 'processing')->count(),
            'shipping' => Order::where('order_status', 'shipping')->count(),
            'completed' => Order::where('order_status', 'completed')->count(),
            'cancelled' => Order::where('order_status', 'cancelled')->count(),
            'paid' => Order::where('payment_status', 'paid')->count(),
        ];

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
        $orders = $ordersQuery->paginate(5)->withQueryString();

        return view('admin.orders', compact('orders', 'totalOrders', 'paidRevenue', 'pendingValue', 'shippingValue', 'statusCounts'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $status = $request->input('order_status');
        $paymentStatus = $request->input('payment_status');

        $order->update([
            'order_status' => $status,
            'payment_status' => $paymentStatus ?? $order->payment_status,
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng ' . $order->order_code);
    }

    /**
     * 6. Thống kê tài chính: Doanh thu, Lợi nhuận, Dòng tiền
     */
    public function finance(\Illuminate\Http\Request $request)
    {
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
        $totalOrders = Order::count();
        $totalOrdersCount = $filteredOrders->count();
        $paidOrdersList = $filteredOrders->filter(fn($o) => $o->payment_status === 'paid' || $o->order_status === 'completed');
        $paidOrdersCount = $paidOrdersList->count();
        $actualRevenue = $paidOrdersList->sum('total_amount');
        $totalRevenue = $actualRevenue;
        $completedOrders = $filteredOrders->where('order_status', 'completed')->count();
        $successRate = $totalOrdersCount > 0 ? round(($paidOrdersCount / $totalOrdersCount) * 100, 1) : 0;
        $aov = $paidOrdersCount > 0 ? round($actualRevenue / $paidOrdersCount) : 0;
        $avgOrderValue = $aov;

        $bankingRevenue = $filteredOrders->whereIn('payment_method', ['banking', 'momo'])->sum('total_amount');
        $codRevenue = $filteredOrders->where('payment_method', 'cod')->sum('total_amount');

        $recentTransactions = Order::latest()->take(10)->get();

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

        // Biểu đồ xu hướng theo ngày
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

        return view('admin.finance', compact(
            'totalRevenue',
            'totalOrders',
            'completedOrders',
            'avgOrderValue',
            'bankingRevenue',
            'codRevenue',
            'recentTransactions',
            'categoryRevenues',
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
            'period'
        ));
    }

    /**
     * 7. Giao dịch thanh toán: Nhật ký dòng tiền, chuyển khoản, MoMo & COD
     */
    public function transactions(Request $request)
    {
        $sort = $request->input('sort', 'latest');
        $query = Order::query();

        match ($sort) {
            'oldest' => $query->oldest(),
            'price_desc' => $query->orderByDesc('total_amount'),
            'price_asc' => $query->orderBy('total_amount'),
            default => $query->latest(),
        };

        $transactions = $query->paginate(5);
        $totalCount = Order::count();

        return view('admin.transactions', compact('transactions', 'sort', 'totalCount'));
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $status = $request->input('payment_status', 'paid');

        $order->update([
            'payment_status' => $status,
            'order_status' => $status === 'paid' ? 'completed' : ($status === 'failed' ? 'cancelled' : $order->order_status),
        ]);

        $msg = match ($status) {
            'paid' => 'Đã xác nhận thu tiền thành công cho đơn ' . $order->order_code,
            'failed' => 'Đã cập nhật trạng thái đơn ' . $order->order_code . ' sang Thất bại',
            default => 'Đã cập nhật trạng thái thanh toán đơn ' . $order->order_code,
        };

        return back()->with('success', $msg);
    }

    /**
     * 8. Báo cáo: Báo cáo kinh doanh, sản phẩm bán chạy, tồn kho
     */
    public function reports()
    {
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<=', 5)->get();
        $topProducts = Product::with('category')->where('sold_count', '>', 0)->orderByDesc('sold_count')->take(10)->get();
        if ($topProducts->isEmpty()) {
            $topProducts = Product::with('category')->orderByDesc('sold_count')->take(5)->get();
        }
        $totalOrders = Order::count();
        $totalRevenue = Order::where('order_status', '!=', 'cancelled')->sum('total_amount');
        $cancelledOrders = Order::where('order_status', 'cancelled')->count();

        return view('admin.reports', compact(
            'totalProducts',
            'lowStockProducts',
            'topProducts',
            'totalOrders',
            'totalRevenue',
            'cancelledOrders'
        ));
    }
}
