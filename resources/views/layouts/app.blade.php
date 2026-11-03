<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ChronoLux | Thế Giới Đồng Hồ Chính Hãng & Cao Cấp')</title>
    <meta name="description" content="ChronoLux - Hệ thống phân phối đồng hồ Thụy Sĩ, Nhật Bản chính hãng 100%. Rolex, Omega, Hublot, Seiko, Tissot, Casio. Bảo hành 5 năm vàng.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Instrument+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js for Business Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-playfair { font-family: 'Playfair Display', serif; }
        .gold-gradient-text {
            background: linear-gradient(135deg, #dfc370 0%, #c69225 50%, #fbf8eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gold-gradient-bg {
            background: linear-gradient(135deg, #c69225 0%, #aa741c 100%);
        }
        .gold-border {
            border-color: rgba(198, 146, 37, 0.3);
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col selection:bg-amber-500 selection:text-slate-950">

    <!-- Top Announcement Bar -->
    <div class="bg-slate-900 border-b border-slate-800 text-xs py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-wrap justify-between items-center gap-2">
            <div class="flex items-center space-x-6 text-slate-400">
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-certificate text-amber-400"></i> 100% Chính Hãng - Bảo Hành 5 Năm</span>
                <span class="hidden md:inline-flex items-center gap-1.5"><i class="fa-solid fa-truck-fast text-amber-400"></i> Miễn Phí Giao Hàng Toàn Quốc</span>
                <span class="hidden lg:inline-flex items-center gap-1.5"><i class="fa-solid fa-shield-halved text-amber-400"></i> Đổi Mới 30 Ngày Nếu Lỗi</span>
            </div>
            <div class="flex items-center space-x-4 text-slate-300 text-xs">
                <a href="{{ route('orders.tracking') }}" class="hover:text-amber-400 transition flex items-center gap-1">
                    <i class="fa-solid fa-magnifying-glass-location text-amber-400"></i> Tra cứu đơn
                </a>
                <span class="text-slate-700">|</span>
                <a href="tel:19008888" class="hover:text-amber-400 transition font-semibold text-amber-400 flex items-center gap-1">
                    <i class="fa-solid fa-phone"></i> 1900 8888
                </a>
                <span class="text-slate-700">|</span>
                
                @auth
                    <div class="flex items-center gap-2 text-slate-300">
                        <span class="w-2 h-2 rounded-full {{ Auth::user()->isAdmin() ? 'bg-amber-400' : 'bg-emerald-400' }}"></span>
                        <span>Xin chào, <strong class="text-white">{{ Auth::user()->name }}</strong></span>
                        <span class="text-[10px] text-amber-400 font-bold">({{ Auth::user()->isAdmin() ? 'Quản Trị Viên' : 'Khách Hàng' }})</span>
                    </div>
                @else
                    <div class="flex items-center gap-3">
                        <a href="{{ route('login') }}" class="hover:text-amber-400 transition">Đăng nhập</a>
                        <span class="text-slate-700">/</span>
                        <a href="{{ route('register') }}" class="hover:text-amber-400 transition">Đăng ký</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <header class="sticky top-0 z-50 bg-slate-950/90 backdrop-blur-md border-b border-slate-800/80 shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-full border border-amber-500/40 bg-gradient-to-br from-slate-900 to-amber-950/40 flex items-center justify-center text-amber-400 shadow-[0_0_15px_rgba(198,146,37,0.3)] group-hover:scale-105 transition-transform duration-300">
                        <i class="fa-solid fa-clock text-2xl"></i>
                    </div>
                    <div>
                        <div class="font-cinzel text-2xl md:text-3xl font-bold tracking-widest gold-gradient-text">CHRONOLUX</div>
                        <div class="text-[9px] uppercase tracking-[0.3em] text-slate-400 -mt-1 font-medium">Haute Horlogerie • Est. 2012</div>
                    </div>
                </a>

                <!-- Desktop Search Bar -->
                <div class="hidden lg:flex flex-1 max-w-md mx-6">
                    <form action="{{ route('products.index') }}" method="GET" class="w-full relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm Rolex, Omega, Automatic, Sapphire..." 
                            class="w-full bg-slate-900/90 border border-slate-700/80 rounded-full py-2.5 pl-5 pr-12 text-sm text-slate-100 placeholder-slate-400 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition shadow-inner">
                        <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-amber-500 text-slate-950 flex items-center justify-center hover:bg-amber-400 transition">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Navigation Links & Cart -->
                <div class="flex items-center space-x-6">
                    <a href="{{ route('products.index') }}" class="hidden md:inline-flex items-center gap-1.5 text-sm font-medium text-slate-200 hover:text-amber-400 transition">
                        <span>Bộ sưu tập</span>
                    </a>
                    <a href="{{ route('products.index', ['gender' => 'men']) }}" class="hidden md:inline-flex text-sm font-medium text-slate-200 hover:text-amber-400 transition">
                        Đồng hồ Nam
                    </a>
                    <a href="{{ route('products.index', ['gender' => 'women']) }}" class="hidden md:inline-flex text-sm font-medium text-slate-200 hover:text-amber-400 transition">
                        Đồng hồ Nữ
                    </a>
                    <a href="{{ route('pages.about') }}" class="hidden xl:inline-flex text-sm font-medium text-slate-200 hover:text-amber-400 transition">
                        Về chúng tôi
                    </a>

                    <!-- Cart Button with Dynamic Badge (Chỉ hiển thị cho Khách hàng, ẩn với Admin) -->
                    @if(!Auth::check() || !Auth::user()->isAdmin())
                        @php
                            $cart = session()->get('cart', []);
                            $cartCount = array_sum(array_column($cart, 'quantity'));
                        @endphp
                        <a href="{{ route('cart.index') }}" class="relative group p-2 text-slate-200 hover:text-amber-400 transition flex items-center gap-2.5">
                            <div class="relative">
                                <i class="fa-solid fa-bag-shopping text-2xl group-hover:scale-110 transition-transform"></i>
                                <span id="header-cart-count" class="absolute -top-1.5 -right-2 bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-lg">
                                    {{ $cartCount }}
                                </span>
                            </div>
                            <span class="hidden sm:inline text-xs font-semibold uppercase tracking-wider text-slate-300 group-hover:text-amber-400">Giỏ hàng</span>
                        </a>
                    @else
                        <!-- Quick Add Product Button for Admin in Header -->
                        <a href="{{ url('/?view=admin&admin_tab=products#admin-section') }}" onclick="if(typeof switchAdminTab === 'function') { switchAdminTab('products'); }" class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-amber-500/20 border border-amber-500/50 text-amber-300 hover:bg-amber-500 hover:text-slate-950 text-xs font-bold transition shadow-sm" title="Thêm & Quản lý sản phẩm">
                            <i class="fa-solid fa-plus-circle text-amber-400"></i>
                            <span>+ Thêm Sản Phẩm</span>
                        </a>
                    @endif

                    <!-- User Account / Logout Button -->
                    @auth
                        <div class="flex items-center gap-2">
                            <div class="hidden sm:flex items-center gap-2 px-3.5 py-2 rounded-xl border border-slate-700 bg-slate-900/90 text-xs text-slate-200">
                                <span class="w-2.5 h-2.5 rounded-full {{ Auth::user()->isAdmin() ? 'bg-amber-400' : 'bg-emerald-400' }}"></span>
                                <span class="max-w-[120px] truncate font-semibold">{{ Auth::user()->name }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase">({{ Auth::user()->isAdmin() ? 'Admin' : 'Khách' }})</span>
                            </div>
                            @if(Auth::user()->isAdmin())
                                <a href="{{ url('/?view=admin&admin_tab=orders#admin-section') }}" class="px-3 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase flex items-center gap-1.5 shadow transition" title="Mở trang SHOP ADMIN">
                                    <i class="fa-solid fa-clock"></i>
                                    <span class="hidden md:inline">SHOP ADMIN</span>
                                </a>
                            @endif
                            <a href="{{ route('logout') }}" class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-500 text-white font-bold text-xs uppercase tracking-wider flex items-center gap-2 shadow-lg shadow-red-950/50 transition transform hover:scale-105" title="Đăng xuất khỏi hệ thống">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Đăng Xuất</span>
                            </a>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-900 border border-slate-700 hover:border-amber-500 text-slate-200 hover:text-white font-bold text-xs uppercase tracking-wider flex items-center gap-1.5 transition">
                                <i class="fa-solid fa-arrow-right-to-bracket text-amber-400"></i>
                                <span>Đăng Nhập</span>
                            </a>
                            <a href="{{ route('register') }}" class="px-3.5 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs uppercase tracking-wider flex items-center gap-1.5 shadow-lg shadow-amber-500/20 transition transform hover:scale-105">
                                <i class="fa-solid fa-user-plus"></i>
                                <span>Đăng Ký</span>
                            </a>
                        </div>
                    @endauth

                    <!-- Mobile Menu Trigger -->
                    <button id="mobile-menu-btn" class="md:hidden text-slate-200 text-2xl p-1 hover:text-amber-400 focus:outline-none">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Secondary Subnav: Popular Brands -->
            <div class="hidden md:flex items-center justify-center py-2.5 border-t border-slate-900 text-xs uppercase tracking-widest text-slate-400 gap-8">
                <a href="{{ route('products.index', ['brand' => 'Rolex']) }}" class="hover:text-amber-400 transition">Rolex</a>
                <a href="{{ route('products.index', ['brand' => 'Omega']) }}" class="hover:text-amber-400 transition">Omega</a>
                <a href="{{ route('products.index', ['brand' => 'Patek Philippe']) }}" class="hover:text-amber-400 transition">Patek Philippe</a>
                <a href="{{ route('products.index', ['brand' => 'Hublot']) }}" class="hover:text-amber-400 transition">Hublot</a>
                <a href="{{ route('products.index', ['brand' => 'Seiko']) }}" class="hover:text-amber-400 transition">Seiko</a>
                <a href="{{ route('products.index', ['brand' => 'Tissot']) }}" class="hover:text-amber-400 transition">Tissot</a>
                <a href="{{ route('products.index', ['brand' => 'Casio']) }}" class="hover:text-amber-400 transition">Casio</a>
                <a href="{{ route('products.index', ['brand' => 'Citizen']) }}" class="hover:text-amber-400 transition">Citizen</a>
                <a href="{{ route('pages.warranty') }}" class="text-amber-400/90 hover:text-amber-300 font-semibold transition ml-4">
                    <i class="fa-solid fa-gem mr-1"></i> Bảo hành 5 Năm Vàng
                </a>
            </div>

            <!-- Mobile Navigation Drawer -->
            <div id="mobile-menu" class="hidden md:hidden py-4 border-t border-slate-800 space-y-3">
                <form action="{{ route('products.index') }}" method="GET" class="w-full relative mb-3">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm đồng hồ..." 
                        class="w-full bg-slate-900 border border-slate-700 rounded-lg py-2.5 pl-4 pr-10 text-sm text-slate-100 placeholder-slate-400 focus:outline-none focus:border-amber-500">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-amber-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <a href="{{ route('products.index') }}" class="p-2 rounded bg-slate-900 text-slate-200 hover:text-amber-400">Tất cả đồng hồ</a>
                    <a href="{{ route('products.index', ['gender' => 'men']) }}" class="p-2 rounded bg-slate-900 text-slate-200 hover:text-amber-400">Đồng hồ Nam</a>
                    <a href="{{ route('products.index', ['gender' => 'women']) }}" class="p-2 rounded bg-slate-900 text-slate-200 hover:text-amber-400">Đồng hồ Nữ</a>
                    <a href="{{ route('orders.tracking') }}" class="p-2 rounded bg-slate-900 text-slate-200 hover:text-amber-400">Tra cứu đơn</a>
                    <a href="{{ route('pages.about') }}" class="p-2 rounded bg-slate-900 text-slate-200 hover:text-amber-400">Về chúng tôi</a>
                    <a href="{{ route('pages.contact') }}" class="p-2 rounded bg-slate-900 text-slate-200 hover:text-amber-400">Liên hệ & Showroom</a>
                </div>
                <div class="pt-2 border-t border-slate-800">
                    @auth
                        <div class="flex items-center justify-between p-2 rounded-xl bg-slate-900 border border-slate-800">
                            <span class="text-xs text-slate-300">
                                <i class="fa-solid fa-user text-amber-400 mr-1"></i> {{ Auth::user()->name }}
                            </span>
                            <a href="{{ route('logout') }}" class="px-3 py-1.5 rounded-lg bg-red-600 hover:bg-red-500 text-white font-bold text-xs uppercase flex items-center gap-1">
                                <i class="fa-solid fa-right-from-bracket"></i> Đăng Xuất
                            </a>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="block text-center py-2.5 rounded-xl bg-amber-500 text-slate-950 font-bold text-xs uppercase tracking-wider">
                            <i class="fa-solid fa-arrow-right-to-bracket mr-1"></i> Đăng Nhập Hệ Thống
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Global Flash Notification Toast -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if (session('success'))
            <div class="bg-emerald-950/80 border border-emerald-500/50 text-emerald-200 px-4 py-3 rounded-xl flex items-center justify-between shadow-lg" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-rose-950/80 border border-rose-500/50 text-rose-200 px-4 py-3 rounded-xl flex items-center justify-between shadow-lg" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-400 text-lg"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="bg-amber-950/80 border border-amber-500/50 text-amber-200 px-4 py-3 rounded-xl flex items-center justify-between shadow-lg" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-amber-400 text-lg"></i>
                    <span>{{ session('warning') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-amber-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Luxury Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 pt-16 pb-8 text-slate-400 text-sm mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-800">
                
                <!-- Col 1: Brand Info -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full border border-amber-500/50 bg-slate-950 flex items-center justify-center text-amber-400">
                            <i class="fa-solid fa-clock text-xl"></i>
                        </div>
                        <span class="font-cinzel text-2xl font-bold tracking-widest gold-gradient-text">CHRONOLUX</span>
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed max-w-sm">
                        ChronoLux tự hào là điểm đến tin cậy của các tín đồ đam mê đồng hồ cao cấp tại Việt Nam. Chúng tôi cam kết 100% sản phẩm phân phối là chính hãng, đền bù gấp 10 lần giá trị nếu phát hiện hàng giả, hàng nhái.
                    </p>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center gap-2 text-slate-300">
                            <i class="fa-solid fa-location-dot text-amber-400 w-4"></i> Showroom 1: 68 Tràng Tiền, Quận Hoàn Kiếm, Hà Nội
                        </div>
                        <div class="flex items-center gap-2 text-slate-300">
                            <i class="fa-solid fa-location-dot text-amber-400 w-4"></i> Showroom 2: 128 Đồng Khởi, Quận 1, TP. Hồ Chí Minh
                        </div>
                        <div class="flex items-center gap-2 text-slate-300">
                            <i class="fa-solid fa-phone text-amber-400 w-4"></i> Hotline: 1900 8888 (24/7) - CSKH: 0988.888.999
                        </div>
                        <div class="flex items-center gap-2 text-slate-300">
                            <i class="fa-solid fa-envelope text-amber-400 w-4"></i> Email: contact@chronolux.vn
                        </div>
                    </div>
                </div>

                <!-- Col 2: Top Brands -->
                <div>
                    <h4 class="font-cinzel text-amber-400 uppercase tracking-widest text-xs font-semibold mb-4">Thương hiệu Thụy Sĩ</h4>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('products.index', ['brand' => 'Rolex']) }}" class="hover:text-amber-400 transition">Đồng hồ Rolex</a></li>
                        <li><a href="{{ route('products.index', ['brand' => 'Omega']) }}" class="hover:text-amber-400 transition">Đồng hồ Omega</a></li>
                        <li><a href="{{ route('products.index', ['brand' => 'Patek Philippe']) }}" class="hover:text-amber-400 transition">Đồng hồ Patek Philippe</a></li>
                        <li><a href="{{ route('products.index', ['brand' => 'Hublot']) }}" class="hover:text-amber-400 transition">Đồng hồ Hublot</a></li>
                        <li><a href="{{ route('products.index', ['brand' => 'Tissot']) }}" class="hover:text-amber-400 transition">Đồng hồ Tissot 1853</a></li>
                    </ul>
                </div>

                <!-- Col 3: Customer Service -->
                <div>
                    <h4 class="font-cinzel text-amber-400 uppercase tracking-widest text-xs font-semibold mb-4">Chăm sóc khách hàng</h4>
                    <ul class="space-y-2.5 text-xs">
                        <li><a href="{{ route('orders.tracking') }}" class="hover:text-amber-400 transition">Tra cứu trạng thái đơn hàng</a></li>
                        <li><a href="{{ route('pages.warranty') }}" class="hover:text-amber-400 transition">Chính sách bảo hành 5 năm</a></li>
                        <li><a href="{{ route('pages.warranty') }}" class="hover:text-amber-400 transition">Quy trình thẩm định đồng hồ</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-amber-400 transition">Đặt lịch hẹn tư vấn tại showroom</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-amber-400 transition">Hướng dẫn thanh toán & Voucher</a></li>
                    </ul>
                </div>

                <!-- Col 4: Newsletter & Guarantee -->
                <div>
                    <h4 class="font-cinzel text-amber-400 uppercase tracking-widest text-xs font-semibold mb-4">Đặc quyền Chrono Club</h4>
                    <p class="text-xs text-slate-400 mb-3">Nhận ngay voucher giảm 500.000 ₫ và cập nhật các mẫu giới hạn:</p>
                    <div class="flex">
                        <input type="email" placeholder="Email của bạn..." class="bg-slate-950 border border-slate-700 rounded-l-lg px-3 py-2 text-xs text-slate-100 focus:outline-none focus:border-amber-500 w-full">
                        <button class="bg-amber-500 hover:bg-amber-400 text-slate-950 font-semibold px-3 py-2 rounded-r-lg text-xs transition">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                    <div class="mt-4 flex items-center gap-3">
                        <span class="text-xl text-slate-400 hover:text-amber-400 cursor-pointer"><i class="fa-brands fa-facebook"></i></span>
                        <span class="text-xl text-slate-400 hover:text-amber-400 cursor-pointer"><i class="fa-brands fa-youtube"></i></span>
                        <span class="text-xl text-slate-400 hover:text-amber-400 cursor-pointer"><i class="fa-brands fa-instagram"></i></span>
                        <span class="text-xl text-slate-400 hover:text-amber-400 cursor-pointer"><i class="fa-brands fa-tiktok"></i></span>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Badges -->
            <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-slate-400 gap-4">
                <div>
                    © 2026 ChronoLux Inc. All rights reserved. Thiết kế theo tiêu chuẩn Laravel 13 & Tailwind CSS v4.
                </div>
                <div class="flex items-center space-x-4">
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-lock text-amber-400"></i> Bảo mật SSL 256-bit</span>
                    <span class="flex items-center gap-1.5"><i class="fa-solid fa-qrcode text-amber-400"></i> Hỗ trợ VietQR Napas</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Script -->
    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

    <!-- Floating Livechat ở góc dưới bên phải -->
    @include('partials.floating_livechat')

    @stack('scripts')
</body>
</html>
