<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Giao Dịch Thanh Toán - Quản Trị Hệ Thống')</title>
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Chart.js for Business Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-slate-800 font-sans antialiased min-h-screen flex selection:bg-blue-600 selection:text-white">

    <!-- Admin Sidebar matching Screenshot Image 2 -->
    <aside id="shop-sidebar" class="w-64 bg-[#182234] border-r border-slate-800/90 flex flex-col justify-between flex-shrink-0 min-h-screen transition-all duration-300 z-30 select-none">
        
        <div>
            <!-- Header: Yellow Clock Icon + QUẢN LÝ ĐỒNG HỒ / SHOP ADMIN + Hamburger Icon -->
            <div class="px-5 py-4 border-b border-slate-700/60 flex items-center justify-between">
                <a href="{{ route('admin.orders') }}" class="flex items-center gap-2.5 group">
                    <i class="fa-solid fa-clock text-yellow-400 text-xl group-hover:scale-110 transition-transform"></i>
                    <div>
                        <span class="font-bold text-white text-base tracking-wider font-sans whitespace-nowrap sidebar-text block leading-tight">QUẢN LÝ ĐỒNG HỒ</span>
                        <span class="text-[9px] text-slate-400 font-semibold uppercase tracking-widest sidebar-text">SHOP ADMIN</span>
                    </div>
                </a>
                <button id="sidebar-toggle" type="button" class="text-slate-400 hover:text-white p-1 rounded transition focus:outline-none" title="Đóng / Mở menu">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
            </div>

            <!-- Profile Info: Chào, Administrator matching screenshot -->
            <div class="px-5 py-3 border-b border-slate-700/60 flex items-center gap-2.5 text-xs text-yellow-400 font-medium">
                <i class="fa-solid fa-user text-yellow-400 text-sm"></i>
                <span class="sidebar-text">Chào, Administrator</span>
            </div>

            <!-- Menu Navigation Items matching Screenshot Image 2 -->
            <nav class="py-2 text-sm font-medium">
                
                <!-- 1. Dashboard / Tổng quan -->
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ request()->routeIs('admin.dashboard') ? 'border-cyan-400 bg-slate-800/90 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }}"
                   title="Tổng quan">
                    <i class="fa-solid fa-gauge-high w-5 text-center text-base {{ request()->routeIs('admin.dashboard') ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span class="sidebar-text">Tổng quan</span>
                </a>

                <!-- 2. Báo cáo doanh thu -->
                <a href="{{ route('admin.finance') }}"
                   class="flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ request()->routeIs('admin.finance*') && !request()->routeIs('admin.finance.transactions*') ? 'border-cyan-400 bg-slate-800/90 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }}"
                   title="Báo cáo doanh thu">
                    <i class="fa-solid fa-chart-line w-5 text-center text-base {{ request()->routeIs('admin.finance*') && !request()->routeIs('admin.finance.transactions*') ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span class="sidebar-text">Báo cáo doanh thu</span>
                </a>

                <!-- 3. Danh mục -->
                <a href="{{ route('admin.categories') }}"
                   class="flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ request()->routeIs('admin.categories*') ? 'border-cyan-400 bg-slate-800/90 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }}"
                   title="Danh mục">
                    <i class="fa-solid fa-layer-group w-5 text-center text-base {{ request()->routeIs('admin.categories*') ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span class="sidebar-text">Danh mục</span>
                </a>

                <!-- 4. Sản phẩm -->
                <a href="{{ route('admin.products') }}"
                   class="flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ request()->routeIs('admin.products*') ? 'border-cyan-400 bg-slate-800/90 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }}"
                   title="Sản phẩm">
                    <i class="fa-solid fa-clock w-5 text-center text-base {{ request()->routeIs('admin.products*') ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span class="sidebar-text">Sản phẩm</span>
                </a>

                <!-- 5. Đơn hàng (ACTIVE) -->
                <a href="{{ route('admin.orders') }}"
                   class="flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ request()->routeIs('admin.orders*') ? 'border-cyan-400 bg-slate-800/90 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }}"
                   title="Đơn hàng">
                    <i class="fa-solid fa-receipt w-5 text-center text-base {{ request()->routeIs('admin.orders*') ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span class="sidebar-text">Đơn hàng</span>
                </a>

                <!-- 6. Người dùng -->
                <a href="{{ route('admin.users') }}"
                   class="flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ request()->routeIs('admin.users*') ? 'border-cyan-400 bg-slate-800/90 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }}"
                   title="Người dùng">
                    <i class="fa-solid fa-user-group w-5 text-center text-base {{ request()->routeIs('admin.users*') ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span class="sidebar-text">Người dùng</span>
                </a>

                <!-- 7. Giao dịch thanh toán COD -->
                <a href="{{ route('admin.finance.transactions') }}"
                   class="flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ request()->routeIs('admin.transactions*') || request()->routeIs('admin.finance.transactions*') ? 'border-cyan-400 bg-slate-800/90 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }}"
                   title="Giao dịch COD">
                    <i class="fa-solid fa-money-bill-wave w-5 text-center text-base {{ request()->routeIs('admin.transactions*') || request()->routeIs('admin.finance.transactions*') ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span class="sidebar-text">Giao dịch COD</span>
                </a>

                <!-- 8. Báo cáo -->
                <a href="{{ route('admin.reports') }}"
                   class="flex items-center gap-3.5 px-5 py-3 transition border-l-4 {{ request()->routeIs('admin.reports*') ? 'border-cyan-400 bg-slate-800/90 text-white font-semibold' : 'border-transparent text-slate-300 hover:text-white hover:bg-slate-800/40' }}"
                   title="Báo cáo">
                    <i class="fa-solid fa-file-invoice-dollar w-5 text-center text-base {{ request()->routeIs('admin.reports*') ? 'text-cyan-400' : 'text-slate-400' }}"></i>
                    <span class="sidebar-text">Báo cáo</span>
                </a>
                </a>

            </nav>
        </div>

        <!-- Bottom Footer: Logout (Red) & Return to Shop -->
        <div class="px-5 py-4 border-t border-slate-800/80 space-y-2">
            <!-- Đăng xuất in Red matching screenshot -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3.5 py-2 text-rose-500 hover:text-rose-400 font-semibold text-sm transition focus:outline-none" title="Đăng xuất">
                    <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center text-base text-rose-500"></i>
                    <span class="sidebar-text">Đăng xuất</span>
                </button>
            </form>

            <!-- Store link -->
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 py-1 text-slate-400 hover:text-amber-400 text-xs transition" title="Xem cửa hàng bán lẻ">
                <i class="fa-solid fa-store w-5 text-center"></i>
                <span class="sidebar-text">Về cửa hàng</span>
            </a>
        </div>

    </aside>

    <!-- Main Content Area with Light Theme matching Image 2 -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-white">
        <!-- Top bar -->
        <header class="h-14 bg-white border-b border-slate-200 px-6 sm:px-8 flex items-center justify-between sticky top-0 z-20">
            <div class="flex items-center gap-3">
                <button id="mobile-toggle" type="button" class="lg:hidden text-slate-600 hover:text-slate-900 p-2">
                    <i class="fa-solid fa-bars text-lg"></i>
                </button>
                <div class="text-xs font-semibold text-slate-500 flex items-center gap-2">
                    <span>Quản trị SHOP</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    <span class="text-slate-900 font-bold">@yield('page_title', 'Giao Dịch Thanh Toán')</span>
                </div>
            </div>

            <div class="flex items-center gap-3 text-xs">
                <div class="hidden sm:flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-600">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Admin:</span>
                    <span class="font-bold text-slate-900">{{ Auth::user()->email ?? 'admin@gmail.com' }}</span>
                </div>
                <a href="{{ route('home') }}" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium transition flex items-center gap-1.5 border border-slate-200">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    <span>Trang bán hàng</span>
                </a>
            </div>
        </header>

        <!-- Flash messages -->
        <div class="px-6 sm:px-8 pt-4">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-2.5 rounded-lg text-xs flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-300 text-rose-800 px-4 py-2.5 rounded-lg text-xs flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-rose-600"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800"><i class="fa-solid fa-xmark"></i></button>
                </div>
            @endif
        </div>

        <!-- Page View Body -->
        <main class="p-6 sm:p-8 flex-1 bg-white">
            @yield('content')
        </main>
    </div>

    <!-- Script for Collapsible Sidebar Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('shop-sidebar');
            const toggleBtn = document.getElementById('sidebar-toggle');
            const mobileBtn = document.getElementById('mobile-toggle');

            function toggleSidebar() {
                if (sidebar.classList.contains('w-64')) {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-20');
                    document.querySelectorAll('.sidebar-text').forEach(el => el.classList.add('hidden'));
                } else {
                    sidebar.classList.remove('w-20');
                    sidebar.classList.add('w-64');
                    document.querySelectorAll('.sidebar-text').forEach(el => el.classList.remove('hidden'));
                }
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', toggleSidebar);
            }
            if (mobileBtn) {
                mobileBtn.addEventListener('click', toggleSidebar);
            }
        });
    </script>
</body>
</html>
