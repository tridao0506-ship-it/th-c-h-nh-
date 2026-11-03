<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập & Đăng Ký Tài Khoản | ChronoLux Haute Horlogerie</title>
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Instrument+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-cinzel { font-family: 'Cinzel', serif; }
        .gold-gradient-text {
            background: linear-gradient(135deg, #dfc370 0%, #c69225 50%, #fbf8eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-amber-500 selection:text-slate-950 relative overflow-x-hidden">

    <!-- Ambient Glow Backgrounds -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-amber-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Top Minimal Header -->
    <header class="py-6 px-4 border-b border-slate-900 bg-slate-950/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full border border-amber-500/50 bg-slate-900 flex items-center justify-center text-amber-400 shadow-[0_0_15px_rgba(198,146,37,0.3)]">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>
                <div>
                    <span class="font-cinzel text-xl sm:text-2xl font-bold tracking-widest gold-gradient-text">CHRONOLUX</span>
                    <span class="text-[9px] uppercase tracking-[0.25em] text-slate-400 block -mt-1 font-medium">Haute Horlogerie • Est. 2012</span>
                </div>
            </div>

            <!-- Bypass to guest browse -->
            <a href="{{ url('/?guest=1') }}" class="text-xs text-slate-400 hover:text-amber-400 transition flex items-center gap-1.5 px-3.5 py-2 rounded-full border border-slate-800 hover:border-amber-500/40 bg-slate-900/70 shadow-sm">
                <span>Vào xem trang web (Khách vãng lai)</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </header>

    <!-- Main Auth Container -->
    <main class="flex-grow flex items-center justify-center px-4 py-10 relative z-10">
        <div class="w-full max-w-lg space-y-5">
            
            <!-- Logged-in Notice (If user is already signed in) -->
            @auth
                <div class="bg-amber-950/70 border border-amber-500/40 rounded-2xl p-4 text-xs text-amber-200 shadow-xl space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 font-bold text-amber-300">
                            <i class="fa-solid fa-circle-user text-base text-amber-400"></i>
                            <span>Đang đăng nhập: {{ Auth::user()->name }} ({{ Auth::user()->isAdmin() ? 'Admin' : 'Khách' }})</span>
                        </div>
                        <a href="{{ route('logout') }}" class="px-3 py-1 rounded-lg bg-red-600 hover:bg-red-500 text-white font-bold text-[11px] transition">
                            <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
                        </a>
                    </div>
                    <div class="flex items-center justify-between pt-1 text-[11px] text-slate-300">
                        <span>Hoặc tiếp tục sử dụng:</span>
                        <a href="{{ url('/?guest=1') }}" class="text-amber-400 hover:underline font-semibold flex items-center gap-1">
                            <span>Vào trang chủ ChronoLux</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endauth

            <!-- Global Flash Messages -->
            @if(session('success'))
                <div class="bg-emerald-950/80 border border-emerald-500/50 text-emerald-200 px-4 py-3 rounded-2xl text-xs flex items-center gap-2 shadow-lg">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-950/80 border border-rose-500/50 text-rose-200 px-4 py-3 rounded-2xl text-xs flex items-center gap-2 shadow-lg">
                    <i class="fa-solid fa-triangle-exclamation text-rose-400 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
            @if(session('info'))
                <div class="bg-blue-950/80 border border-blue-500/50 text-blue-200 px-4 py-3 rounded-2xl text-xs flex items-center gap-2 shadow-lg">
                    <i class="fa-solid fa-circle-info text-blue-400 text-sm"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <!-- Validation Errors Banner -->
            @if(isset($errors) && $errors->any())
                <div class="bg-rose-950/80 border border-rose-500/50 text-rose-200 px-4 py-3.5 rounded-2xl text-xs space-y-1.5 shadow-lg">
                    <div class="font-bold flex items-center gap-1.5 text-rose-300">
                        <i class="fa-solid fa-circle-exclamation text-rose-400"></i>
                        <span>Vui lòng kiểm tra lại thông tin:</span>
                    </div>
                    @foreach($errors->all() as $err)
                        <div class="pl-5 text-rose-200/90">• {{ $err }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Main Auth Card -->
            <div class="bg-slate-900/95 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6 backdrop-blur-md">
                
                <!-- Heading -->
                <div class="text-center space-y-1">
                    <div class="w-12 h-12 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center mx-auto mb-2 text-xl shadow-[0_0_15px_rgba(245,158,11,0.2)]">
                        <i class="fa-solid fa-user-check" id="main-auth-icon"></i>
                    </div>
                    <h1 class="text-2xl font-serif font-bold text-white tracking-wide" id="main-auth-title">Đăng Nhập Khách Hàng</h1>
                    <p class="text-xs text-slate-400" id="main-auth-desc">Vui lòng đăng nhập tài khoản để tiếp tục trải nghiệm mua sắm</p>
                </div>

                <!-- ================================================================= -->
                <!-- 1. SECTION: KHÁCH HÀNG ĐĂNG NHẬP                                  -->
                <!-- ================================================================= -->
                <div id="section-login" class="space-y-4">
                    
                    <!-- Customer Login Form -->
                    <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="login_type" value="customer">

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Email đăng nhập</label>
                            <input type="email" id="cust-login-email" name="email" value="{{ old('email') }}" required placeholder="Nhập email của bạn..." 
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Mật khẩu</label>
                            <input type="password" id="cust-login-password" name="password" value="" required placeholder="••••••••" 
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-500 transition">
                        </div>

                        <div class="flex items-center justify-between text-xs text-slate-400">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember" checked class="rounded text-amber-500 bg-slate-950 border-slate-700">
                                <span>Ghi nhớ đăng nhập</span>
                            </label>
                            <button type="button" onclick="switchLoginRole('register')" class="text-amber-400 hover:underline">
                                Chưa có tài khoản?
                            </button>
                        </div>

                        <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span>ĐĂNG NHẬP KHÁCH HÀNG</span>
                        </button>
                    </form>

                    <!-- Switch link to Register -->
                    <div class="pt-2 text-center text-xs text-slate-400 border-t border-slate-800/80">
                        Bạn chưa có tài khoản thành viên? 
                        <button type="button" onclick="switchLoginRole('register')" class="text-amber-400 font-bold hover:underline ml-1">
                            Đăng ký ngay tại đây →
                        </button>
                    </div>

                </div>

                <!-- ================================================================= -->
                <!-- 2. SECTION: KHÁCH HÀNG ĐĂNG KÝ TÀI KHOẢN MỚI                     -->
                <!-- ================================================================= -->
                <div id="section-register" class="space-y-4 hidden">

                    <!-- Customer Register Form -->
                    <form action="{{ route('register.post') }}" method="POST" class="space-y-3.5">
                        @csrf
                        
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1">Họ và tên quý khách *</label>
                            <input type="text" id="reg-name" name="name" value="{{ old('name') }}" required placeholder="Nguyễn Văn A" 
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500 transition">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Số điện thoại *</label>
                                <input type="tel" id="reg-phone" name="phone" value="{{ old('phone') }}" required placeholder="0988 888 888" 
                                    class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Email đăng ký *</label>
                                <input type="email" id="reg-email" name="email" value="{{ old('email') }}" required placeholder="email@gmail.com" 
                                    class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500 transition">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Mật khẩu *</label>
                                <input type="password" id="reg-password" name="password" required placeholder="Tối thiểu 3 ký tự" 
                                    class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Nhập lại mật khẩu *</label>
                                <input type="password" id="reg-password-confirmation" name="password_confirmation" required placeholder="Xác nhận mật khẩu" 
                                    class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500 transition">
                            </div>
                        </div>

                        <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2 mt-1">
                            <i class="fa-solid fa-user-plus"></i>
                            <span>ĐĂNG KÝ TÀI KHOẢN</span>
                        </button>
                    </form>

                    <!-- Switch link to Login -->
                    <div class="pt-2 text-center text-xs text-slate-400 border-t border-slate-800/80">
                        Bạn đã có sẵn tài khoản? 
                        <button type="button" onclick="switchLoginRole('login')" class="text-amber-400 font-bold hover:underline ml-1">
                            Chuyển sang Đăng nhập →
                        </button>
                    </div>

                </div>

                <!-- ================================================================= -->
                <!-- 3. SECTION: QUẢN TRỊ VIÊN (ADMIN) ĐĂNG NHẬP                       -->
                <!-- ================================================================= -->
                <div id="section-admin" class="space-y-4 hidden">
                    
                    <div class="p-3 rounded-2xl bg-amber-950/30 border border-amber-500/30 text-xs text-amber-300 flex items-center gap-2.5">
                        <i class="fa-solid fa-shield-halved text-base text-amber-400 flex-shrink-0"></i>
                        <span>Khu vực bảo mật dành riêng cho Quản trị viên để quản lý đơn hàng, kho đồng hồ và doanh thu.</span>
                    </div>

                    <!-- Admin Login Form -->
                    <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="login_type" value="admin">

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Email Quản Trị Viên (Admin)</label>
                            <input type="email" id="adm-email" name="email" value="{{ old('email') }}" required placeholder="admin@gmail.com" 
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Mật khẩu quản trị</label>
                            <input type="password" id="adm-password" name="password" value="" required placeholder="••••••••" 
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-500 transition">
                        </div>

                        <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-right-to-bracket"></i>
                            <span>ĐĂNG NHẬP QUẢN TRỊ VIÊN (ADMIN)</span>
                        </button>
                    </form>

                    <div class="pt-2 text-center text-xs text-slate-400 border-t border-slate-800/80">
                        <button type="button" onclick="switchLoginRole('login')" class="text-amber-400 font-bold hover:underline">
                            ← Quay lại Đăng nhập Khách Hàng
                        </button>
                    </div>

                </div>

            </div>

            <!-- Guest Link -->
            <div class="text-center pt-1">
                <a href="{{ url('/?guest=1') }}" class="text-xs text-slate-400 hover:text-amber-400 transition inline-flex items-center gap-2 py-2 px-4 rounded-full border border-slate-800 bg-slate-900/60 shadow-sm">
                    <i class="fa-solid fa-eye text-amber-400"></i>
                    <span>Bỏ qua đăng nhập • Xem website với tư cách Khách vãng lai</span>
                </a>
            </div>

        </div>
    </main>

    <!-- Bottom Footer -->
    <footer class="py-4 text-center text-xs text-slate-600 border-t border-slate-900">
        © 2026 ChronoLux Haute Horlogerie. All rights reserved.
    </footer>

    <script>
        function switchLoginRole(tab) {
            const secLogin = document.getElementById('section-login');
            const secRegister = document.getElementById('section-register');
            const secAdmin = document.getElementById('section-admin');

            const title = document.getElementById('main-auth-title');
            const desc = document.getElementById('main-auth-desc');
            const icon = document.getElementById('main-auth-icon');

            // Hide all sections first
            if (secLogin) secLogin.classList.add('hidden');
            if (secRegister) secRegister.classList.add('hidden');
            if (secAdmin) secAdmin.classList.add('hidden');

            if (tab === 'register') {
                if (secRegister) secRegister.classList.remove('hidden');
                if (title) title.textContent = "Đăng Ký Tài Khoản Khách Hàng";
                if (desc) desc.textContent = "Tạo tài khoản mới để nhận ưu đãi mua sắm và theo dõi bảo hành";
                if (icon) icon.className = "fa-solid fa-user-plus";
            } else if (tab === 'admin') {
                if (secAdmin) secAdmin.classList.remove('hidden');
                if (title) title.textContent = "Đăng Nhập Quản Trị Viên (Admin)";
                if (desc) desc.textContent = "Cổng truy cập khu vực quản lý cửa hàng và hệ thống ChronoLux";
                if (icon) icon.className = "fa-solid fa-shield-halved";
            } else {
                if (secLogin) secLogin.classList.remove('hidden');
                if (title) title.textContent = "Đăng Nhập Khách Hàng";
                if (desc) desc.textContent = "Vui lòng đăng nhập tài khoản để tiếp tục trải nghiệm mua sắm";
                if (icon) icon.className = "fa-solid fa-user-check";
            }
        }

        // Tự động kích hoạt tab dựa theo URL hoặc lỗi form
        document.addEventListener('DOMContentLoaded', function() {
            @if(isset($errors) && $errors->any() && (old('name') || old('phone') || $errors->has('name') || $errors->has('phone') || $errors->has('password_confirmation')))
                switchLoginRole('register');
            @else
                const initialTab = '{{ $tab ?? "login" }}';
                if (initialTab === 'register') {
                    switchLoginRole('register');
                } else if (initialTab === 'admin') {
                    switchLoginRole('admin');
                } else {
                    switchLoginRole('login');
                }
            @endif
        });
    </script>
</body>
</html>
