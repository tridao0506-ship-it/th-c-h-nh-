<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\GHNWebhookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivechatController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\MomoController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Chuyển hướng /dang-nhap và /dang-ky về màn hình xác thực ngoài
Route::get('/dang-nhap', function (\Illuminate\Http\Request $request) {
    session()->forget('guest_browse');
    return redirect()->route('home', [
        'show_login' => 1,
        'tab' => $request->input('tab', $request->input('role', 'login')),
    ]);
})->name('login');

Route::get('/dang-ky', function () {
    session()->forget('guest_browse');
    return redirect()->route('home', [
        'show_login' => 1,
        'tab' => 'register',
    ]);
})->name('register');
Route::post('/dang-nhap', [AuthController::class, 'login'])->name('login.post');
Route::post('/dang-ky', [AuthController::class, 'register'])->name('register.post');
Route::match(['get', 'post'], '/dang-xuat', [AuthController::class, 'logout'])->name('logout');

// =========================================================================
// XÁC THỰC EMAIL (LAB 3 - GMAIL SMTP & VERIFICATION)
// =========================================================================
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->to(url('/?verified=1#home-section'))
        ->with('success', '🎉 Xác thực email thành công! Chào mừng bạn đến với ChronoLux.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    try {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Đã gửi lại link xác thực qua email của bạn!');
    } catch (\Throwable $e) {
        \Illuminate\Support\Facades\Log::error('Lỗi gửi email xác thực: ' . $e->getMessage());
        return back()->with('error', 'Lỗi gửi mail: Thông tin đăng nhập Gmail không đúng (mã lỗi 535 BadCredentials). Vui lòng kiểm tra lại tài khoản Gmail và Mật khẩu ứng dụng!');
    }
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Trang chủ (Tất cả 4 mục trong 1 trang duy nhất)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/quick-order', [HomeController::class, 'quickOrder'])->name('quick.order');

// Sản phẩm & Chi tiết
Route::get('/dong-ho', [ProductController::class, 'index'])->name('products.index');
Route::get('/dong-ho/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/dong-ho/{id}/reviews', [ProductController::class, 'storeReview'])->name('products.review');

// Giỏ hàng
Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/gio-hang/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/gio-hang/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/gio-hang/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/gio-hang/voucher', [CartController::class, 'applyVoucher'])->name('cart.voucher');
Route::get('/gio-hang/voucher/remove', [CartController::class, 'removeVoucher'])->name('cart.voucher.remove');

// Thanh toán (Hỗ trợ tất cả đường dẫn /thanh-toan, /checkout, /payment, /user/payment)
Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('checkout.index');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/payment', [CheckoutController::class, 'index'])->name('payment');
Route::get('/user/payment', [CheckoutController::class, 'index'])->name('user.payment');
Route::post('/thanh-toan', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/checkout', [CheckoutController::class, 'process']);
Route::get('/thanh-toan/thanh-cong/{order_code}', [CheckoutController::class, 'success'])->name('checkout.success');

// Mua ngay 1-Click -> Đi thẳng vào trang Thanh toán tính cước GHN
Route::get('/mua-ngay/{id}', function ($id) {
    $product = \App\Models\Product::findOrFail($id);
    $cart = [
        $product->id => [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'brand' => $product->brand,
            'price' => $product->price,
            'quantity' => 1,
            'image' => $product->image,
            'sku' => $product->sku,
            'weight' => 300,
        ]
    ];
    session(['cart' => $cart]);
    return redirect()->route('checkout.index');
})->name('buy.now');

// Giao Hàng Nhanh (GHN) API: Địa chỉ & Tính phí theo khoảng cách (Lab GHN)
Route::prefix('locations')->name('locations.')->group(function () {
    Route::get('/provinces', [UserOrderController::class, 'getProvinces'])->name('provinces');
    Route::get('/districts/{provinceId}', [UserOrderController::class, 'getDistricts'])->name('districts');
    Route::get('/wards/{districtId}', [UserOrderController::class, 'getWards'])->name('wards');
    Route::post('/calculate-fee', [UserOrderController::class, 'getShippingFee'])->name('fee');
});

// Tra cứu đơn hàng
Route::get('/tra-cuu-don-hang', [OrderTrackingController::class, 'index'])->name('orders.tracking');

// Các trang thông tin
Route::get('/gioi-thieu', [PageController::class, 'about'])->name('pages.about');
Route::get('/lien-he', [PageController::class, 'contact'])->name('pages.contact');
Route::post('/lien-he', [PageController::class, 'postContact'])->name('pages.contact.post');
Route::get('/chinh-sach-bao-hanh', [PageController::class, 'warranty'])->name('pages.warranty');

// Nút chuyển nhanh sang trang Quản trị viên (dành riêng cho Admin)
Route::get('/chuyen-admin', function (\Illuminate\Http\Request $request) {
    if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->isAdmin()) {
        return redirect()->to(url('/?view=admin&admin_tab=orders#admin-section'));
    }
    return redirect()->route('login', ['tab' => 'admin'])
        ->with('info', 'Vui lòng đăng nhập với tài khoản Quản trị viên (admin@gmail.com / 123)!');
})->name('admin.switch');

// Gộp toàn bộ Admin về trang chủ và bảo vệ nghiêm ngặt bằng quyền admin
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->to(url('/?view=admin&admin_tab=dashboard#admin-section'));
    })->name('dashboard');

    Route::get('/san-pham', function () {
        return redirect()->to(url('/?view=admin&admin_tab=products#admin-section'));
    })->name('products');

    Route::post('/san-pham', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'gender' => 'nullable|in:men,women,unisex',
            'movement' => 'nullable|string|max:100',
            'dial_size' => 'nullable|string|max:50',
            'glass_type' => 'nullable|string|max:100',
            'water_resistance' => 'nullable|string|max:50',
            'image' => 'nullable|string|max:500',
            'short_description' => 'nullable|string',
        ]);

        $category = null;
        if (!empty($validated['category_id'])) {
            $category = \App\Models\Category::find($validated['category_id']);
        } elseif (!empty($validated['brand'])) {
            $category = \App\Models\Category::firstOrCreate(
                ['name' => $validated['brand']],
                ['slug' => \Illuminate\Support\Str::slug($validated['brand']), 'country' => 'Thụy Sĩ', 'is_featured' => true]
            );
        }

        $slug = \Illuminate\Support\Str::slug($validated['name']);
        if (\App\Models\Product::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        $sku = strtoupper(substr($validated['brand'], 0, 3)) . '-' . rand(100, 999);

        \App\Models\Product::create([
            'category_id' => $category ? $category->id : 1,
            'name' => $validated['name'],
            'slug' => $slug,
            'sku' => $sku,
            'brand' => $validated['brand'],
            'gender' => $validated['gender'] ?? 'men',
            'price' => (float)$validated['price'],
            'original_price' => !empty($validated['original_price']) ? (float)$validated['original_price'] : (float)$validated['price'] * 1.15,
            'stock' => (int)$validated['stock'],
            'movement' => $validated['movement'] ?? 'Automatic Thụy Sĩ',
            'dial_size' => $validated['dial_size'] ?? '40mm',
            'glass_type' => $validated['glass_type'] ?? 'Sapphire nguyên khối',
            'water_resistance' => $validated['water_resistance'] ?? '100m / 10 ATM',
            'warranty_years' => 5,
            'origin' => 'Thụy Sĩ',
            'image' => !empty($validated['image']) ? $validated['image'] : 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=600&auto=format&fit=crop&q=80',
            'short_description' => $validated['short_description'] ?? 'Đồng hồ cao cấp ChronoLux chính hãng.',
            'description' => $validated['short_description'] ?? 'Đồng hồ cao cấp ChronoLux chính hãng, bảo hành 5 năm.',
            'is_featured' => true,
            'is_new' => true,
            'rating' => 5.0,
            'reviews_count' => 0,
            'sold_count' => 0,
        ]);

        return redirect()->to(url('/?view=admin&admin_tab=products#admin-section'))
            ->with('success', '🎉 Đã thêm sản phẩm đồng hồ "' . $validated['name'] . '" vào hệ thống thành công!');
    })->name('products.store');

    Route::post('/san-pham/{id}/update', function (\Illuminate\Http\Request $request, $id) {
        $p = \App\Models\Product::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'movement' => 'nullable|string|max:100',
            'image' => 'nullable|string|max:2048',
        ]);

        $newImage = isset($validated['image']) ? trim($validated['image']) : '';

        $p->update([
            'name' => $validated['name'],
            'brand' => $validated['brand'],
            'price' => (float)$validated['price'],
            'original_price' => !empty($validated['original_price']) ? (float)$validated['original_price'] : $p->original_price,
            'stock' => (int)$validated['stock'],
            'movement' => $validated['movement'] ?? $p->movement,
            'image' => !empty($newImage) ? $newImage : $p->image,
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->to(url('/?view=admin&admin_tab=products#admin-section'))
            ->with('success', 'Đã cập nhật thông tin và hình ảnh đồng hồ "' . $p->name . '" thành công!');
    })->name('products.update');

    Route::post('/san-pham/{id}/delete', function ($id) {
        $p = \App\Models\Product::findOrFail($id);
        $name = $p->name;
        $p->delete();
        return redirect()->to(url('/?view=admin&admin_tab=products#admin-section'))
            ->with('success', 'Đã xóa sản phẩm "' . $name . '" khỏi danh sách.');
    })->name('products.destroy');

    Route::post('/san-pham/{id}/stock', function (\Illuminate\Http\Request $request, $id) {
        $p = \App\Models\Product::findOrFail($id);
        $p->update([
            'stock' => max(0, (int) $request->input('stock', 0)),
            'is_featured' => $request->has('is_featured'),
        ]);
        return redirect()->to(url('/?view=admin&admin_tab=products#admin-section'))->with('success', 'Đã cập nhật tồn kho cho ' . $p->name);
    })->name('products.stock');

    Route::get('/danh-muc', function () {
        return redirect()->to(url('/?view=admin&admin_tab=categories#admin-section'));
    })->name('categories');

    Route::post('/danh-muc', function (\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);
        \App\Models\Category::create([
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
            'country' => $validated['country'] ?? 'Thụy Sĩ (Swiss Made)',
            'description' => $validated['description'] ?? '',
            'is_featured' => true,
        ]);
        return redirect()->to(url('/?view=admin&admin_tab=categories#admin-section'))->with('success', 'Đã thêm thương hiệu: ' . $validated['name']);
    })->name('categories.store');

    Route::post('/danh-muc/{id}/update', function (\Illuminate\Http\Request $request, $id) {
        $cat = \App\Models\Category::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $oldName = $cat->name;
        $cat->update([
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
            'country' => $validated['country'] ?? $cat->country,
            'description' => $validated['description'] ?? $cat->description,
        ]);

        if ($oldName !== $validated['name']) {
            \App\Models\Product::where('category_id', $cat->id)->update(['brand' => $validated['name']]);
        }

        return redirect()->to(url('/?view=admin&admin_tab=categories#admin-section'))
            ->with('success', 'Đã cập nhật thương hiệu: ' . $validated['name']);
    })->name('categories.update');

    Route::post('/danh-muc/{id}/delete', function ($id) {
        $cat = \App\Models\Category::findOrFail($id);
        $name = $cat->name;

        if ($cat->products()->count() > 0) {
            $fallback = \App\Models\Category::where('id', '!=', $cat->id)->first();
            if ($fallback) {
                $cat->products()->update([
                    'category_id' => $fallback->id,
                    'brand' => $fallback->name
                ]);
            }
        }

        $cat->delete();

        return redirect()->to(url('/?view=admin&admin_tab=categories#admin-section'))
            ->with('success', 'Đã xóa thành công thương hiệu: ' . $name);
    })->name('categories.destroy');

    Route::get('/nguoi-dung', function () {
        return redirect()->to(url('/?view=admin&admin_tab=users#admin-section'));
    })->name('users');

    Route::post('/nguoi-dung/{id}/role', function ($id) {
        $u = \App\Models\User::findOrFail($id);
        if ($u->id === \Illuminate\Support\Facades\Auth::id()) {
            return back()->with('error', 'Không thể tự đổi vai trò của chính mình!');
        }
        $newRole = $u->role === 'admin' ? 'customer' : 'admin';
        $u->update(['role' => $newRole]);
        return redirect()->to(url('/?view=admin&admin_tab=users#admin-section'))->with('success', 'Đã đổi quyền cho ' . $u->name);
    })->name('users.role');

    Route::get('/don-hang', function (\Illuminate\Http\Request $request) {
        $qs = $request->getQueryString();
        return redirect()->to(url('/?view=admin&admin_tab=orders' . ($qs ? '&' . $qs : '') . '#admin-section'));
    })->name('orders');

    Route::get('/orders', function (\Illuminate\Http\Request $request) {
        $qs = $request->getQueryString();
        return redirect()->to(url('/?view=admin&admin_tab=orders' . ($qs ? '&' . $qs : '') . '#admin-section'));
    })->name('orders.alias');

    Route::post('/don-hang/{id}/status', function (\Illuminate\Http\Request $request, $id) {
        $ord = \App\Models\Order::with('items')->findOrFail($id);
        $oldStatus = $ord->order_status;
        $newStatus = $request->input('order_status', $oldStatus);
        $paymentStatus = $request->input('payment_status', $ord->payment_status);

        if ($newStatus === 'paid') {
            $paymentStatus = 'paid';
            $newStatus = 'processing';
        } elseif ($newStatus === 'completed') {
            $paymentStatus = 'paid';
        } elseif ($newStatus === 'cancelled') {
            if ($paymentStatus !== 'paid') {
                $paymentStatus = 'failed';
            }
        }

        // Cân bằng tồn kho khi đơn bị hủy hoặc phục hồi từ trạng thái hủy
        if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
            foreach ($ord->items as $item) {
                if ($prod = \App\Models\Product::find($item->product_id)) {
                    $prod->increment('stock', $item->quantity);
                    $prod->decrement('sold_count', min($prod->sold_count, $item->quantity));
                }
            }
        } elseif ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
            foreach ($ord->items as $item) {
                if ($prod = \App\Models\Product::find($item->product_id)) {
                    $prod->decrement('stock', $item->quantity);
                    $prod->increment('sold_count', $item->quantity);
                }
            }
        }

        $ord->update([
            'order_status' => $newStatus,
            'payment_status' => $paymentStatus,
        ]);

        return redirect()->to(url('/?view=admin&admin_tab=orders#admin-section'))
            ->with('success', 'Đã cập nhật trạng thái đơn ' . $ord->order_code);
    })->name('orders.status');

    Route::post('/don-hang/{id}/cancel', function ($id) {
        $ord = \App\Models\Order::with('items')->findOrFail($id);
        if ($ord->order_status !== 'cancelled') {
            foreach ($ord->items as $item) {
                if ($prod = \App\Models\Product::find($item->product_id)) {
                    $prod->increment('stock', $item->quantity);
                    $prod->decrement('sold_count', min($prod->sold_count, $item->quantity));
                }
            }
            $ord->update([
                'order_status' => 'cancelled',
                'payment_status' => ($ord->payment_status === 'paid' ? 'refunded' : 'failed')
            ]);
        }
        return redirect()->to(url('/?view=admin&admin_tab=orders#admin-section'))
            ->with('info', 'Đã hủy đơn hàng ' . $ord->order_code . ' và hoàn lại tồn kho sản phẩm thành công.');
    })->name('orders.cancel');

    Route::get('/tai-chinh', function () {
        return redirect()->to(url('/?view=admin&admin_tab=finance#admin-section'));
    })->name('finance');

    Route::get('/finance', function () {
        return redirect()->to(url('/?view=admin&admin_tab=finance#admin-section'));
    })->name('finance.alias');

    Route::get('/finance/transactions', function () {
        return redirect()->to(url('/?view=admin&admin_tab=transactions#admin-section'));
    })->name('finance.transactions');

    Route::get('/giao-dich', function () {
        return redirect()->to(url('/?view=admin&admin_tab=transactions#admin-section'));
    })->name('transactions');

    Route::get('/thanh-toan', function () {
        return redirect()->to(url('/?view=admin&admin_tab=transactions#admin-section'));
    })->name('transactions.alias');

    Route::post('/giao-dich/{id}/payment-status', function (\Illuminate\Http\Request $request, $id) {
        $order = \App\Models\Order::with('items')->findOrFail($id);
        $status = $request->input('payment_status', 'paid');
        $oldStatus = $order->order_status;
        $newOrderStatus = $status === 'paid' ? 'completed' : ($status === 'failed' ? 'cancelled' : $order->order_status);

        if ($oldStatus !== 'cancelled' && $newOrderStatus === 'cancelled') {
            foreach ($order->items as $item) {
                if ($prod = \App\Models\Product::find($item->product_id)) {
                    $prod->increment('stock', $item->quantity);
                    $prod->decrement('sold_count', min($prod->sold_count, $item->quantity));
                }
            }
        }

        $order->update([
            'payment_status' => $status,
            'order_status' => $newOrderStatus,
        ]);
        $msg = $status === 'paid' ? 'Đã xác nhận thu tiền thành công đơn ' . $order->order_code : 'Đã đánh dấu thất bại đơn ' . $order->order_code;
        return redirect()->to(url('/?view=admin&admin_tab=transactions#admin-section'))->with('success', $msg);
    })->name('transactions.status');

    Route::get('/bao-cao', function () {
        return redirect()->to(url('/?view=admin&admin_tab=reports#admin-section'));
    })->name('reports');

    Route::get('/reports', function () {
        return redirect()->to(url('/?view=admin&admin_tab=reports#admin-section'));
    })->name('reports.alias');

    // Livechat Admin API & Tab Redirect
    Route::get('/livechat', function () {
        return redirect()->to(url('/?view=admin&admin_tab=livechat#admin-section'));
    })->name('livechat.tab');
    Route::get('/livechat/conversations', [LivechatController::class, 'getAdminConversations'])->name('livechat.conversations');
    Route::get('/livechat/admin-messages', [LivechatController::class, 'getAdminMessages'])->name('livechat.messages');
    Route::post('/livechat/reply', [LivechatController::class, 'sendAdminReply'])->name('livechat.reply');
});

// Livechat Client API (Dành cho khách hàng & người dùng đang đăng nhập)
Route::get('/livechat/my-messages', [LivechatController::class, 'getClientMessages'])->name('livechat.client.messages');
Route::post('/livechat/send-message', [LivechatController::class, 'sendClientMessage'])->name('livechat.client.send');

// =========================================================================
// 🚚 THIRD-PARTY WEBHOOKS & CALLBACKS (GHN, MOMO IPN - LAB ORDERS)
// =========================================================================
Route::post('/ghn/webhook', [GHNWebhookController::class, 'handle'])->name('ghn.webhook');
Route::post('/payment/momo/ipn', [MomoController::class, 'ipn'])->name('payment.momo.ipn');
Route::get('/payment/momo/callback', [MomoController::class, 'callback'])->name('user.payment.momo.callback');
Route::get('/payment/momo/sandbox/{transaction}', [MomoController::class, 'sandboxGateway'])->name('user.payment.momo.sandbox');
Route::post('/payment/momo/sandbox/{transaction}/process', [MomoController::class, 'processSandboxPayment'])->name('user.payment.momo.sandbox.process');

// MoMo payment actions
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/orders/{order}/pay/momo', [MomoController::class, 'payAgain'])->name('orders.momo.pay');
    Route::get('/orders/{order}/start-momo', [MomoController::class, 'start'])->name('orders.momo.start');
});
Route::get('/orders/{order}/pay/momo', [MomoController::class, 'payAgain'])->name('orders.momo.pay');
Route::get('/orders/{order}/start-momo', [MomoController::class, 'start'])->name('orders.momo.start');

