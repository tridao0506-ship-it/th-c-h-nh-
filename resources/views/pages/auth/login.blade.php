@extends('layouts.app')

@section('title', 'Đăng Nhập Khách Hàng & Quản Trị Viên | ChronoLux')

@section('content')

<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-6">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-full bg-amber-500/20 text-amber-400 border border-amber-500/40 flex items-center justify-center mx-auto text-xl mb-3">
                <i class="fa-solid fa-lock"></i>
            </div>
            <span class="font-cinzel text-amber-400 text-xs uppercase tracking-widest font-semibold">Cổng Đăng Nhập Hệ Thống</span>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-white">ChronoLux Authentication</h1>
            <p class="text-xs text-slate-400">Chọn vai trò đăng nhập phù hợp với tài khoản của bạn</p>
        </div>

        <!-- Role Tabs Switcher -->
        <div class="grid grid-cols-2 p-1.5 rounded-2xl bg-slate-950 border border-slate-800 text-xs font-bold text-center">
            <button type="button" onclick="selectRole('customer')" id="btn-tab-customer" 
                class="py-2.5 rounded-xl transition duration-200 {{ ($role ?? 'customer') === 'customer' ? 'bg-amber-500 text-slate-950 shadow' : 'text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-user mr-1.5"></i> 1. Khách Hàng
            </button>
            <button type="button" onclick="selectRole('admin')" id="btn-tab-admin" 
                class="py-2.5 rounded-xl transition duration-200 {{ ($role ?? '') === 'admin' ? 'bg-amber-500 text-slate-950 shadow' : 'text-slate-400 hover:text-white' }}">
                <i class="fa-solid fa-shield-halved mr-1.5"></i> 2. Quản Trị Viên (Admin)
            </button>
        </div>

        <!-- Customer Login & Register Form Container -->
        <div id="section-customer" class="{{ ($role ?? 'customer') === 'customer' ? '' : 'hidden' }} space-y-5">
            
            <div class="flex justify-between items-center text-xs pb-2 border-b border-slate-800">
                <span class="font-bold text-slate-200" id="customer-mode-title">Đăng nhập tài khoản khách hàng</span>
                <button type="button" onclick="toggleCustomerMode()" id="customer-toggle-btn" class="text-amber-400 hover:underline">
                    Chưa có tài khoản? Đăng ký ngay
                </button>
            </div>

            <!-- Customer Login Form -->
            <form id="customer-login-form" action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="login_type" value="customer">

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Email tài khoản</label>
                    <input type="email" id="customer-email" name="email" value="{{ old('email') }}" required placeholder="khachhang@gmail.com" 
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Mật khẩu</label>
                    <input type="password" id="customer-password" name="password" required placeholder="••••••••" 
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-500">
                </div>

                <div class="flex items-center justify-between text-xs text-slate-400">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded text-amber-500 bg-slate-950 border-slate-700">
                        <span>Ghi nhớ đăng nhập</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-amber-500/20">
                    Đăng Nhập Khách Hàng
                </button>
            </form>

            <!-- Customer Register Form (Initially Hidden) -->
            <form id="customer-register-form" action="{{ route('register.post') }}" method="POST" class="space-y-3 hidden">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Họ và tên *</label>
                    <input type="text" name="name" required placeholder="Nguyễn Văn A" 
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Số điện thoại *</label>
                    <input type="tel" name="phone" required placeholder="0988 888 888" 
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Email đăng ký *</label>
                    <input type="email" name="email" required placeholder="email@gmail.com" 
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Mật khẩu *</label>
                        <input type="password" name="password" required placeholder="Tối thiểu 3 ký tự" 
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1">Nhập lại MK *</label>
                        <input type="password" name="password_confirmation" required placeholder="Xác nhận" 
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500">
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-amber-500/20 mt-2">
                    Tạo Tài Khoản Khách Hàng
                </button>
            </form>

        </div>

        <!-- Admin Login Form Container -->
        <div id="section-admin" class="{{ ($role ?? '') === 'admin' ? '' : 'hidden' }} space-y-4">
            
            <div class="p-3 rounded-2xl bg-amber-950/30 border border-amber-500/30 text-xs text-amber-300 flex items-center gap-2.5">
                <i class="fa-solid fa-shield-halved text-base text-amber-400 flex-shrink-0"></i>
                <span>Khu vực dành riêng cho Quản trị viên hệ thống quản lý đơn hàng & doanh thu.</span>
            </div>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="login_type" value="admin">

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Email quản trị viên (Admin)</label>
                    <input type="email" id="admin-email" name="email" required placeholder="admin@gmail.com" 
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Mật khẩu bảo mật</label>
                    <input type="password" id="admin-password" name="password" required placeholder="••••••••" 
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-xs text-white focus:outline-none focus:border-amber-500">
                </div>

                <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span>Đăng Nhập Quản Trị Viên</span>
                </button>
            </form>

        </div>

        <div class="pt-4 border-t border-slate-800 text-center">
            <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-amber-400 transition flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-arrow-left"></i> Quay lại trang chủ ChronoLux
            </a>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
    function selectRole(role) {
        const secCustomer = document.getElementById('section-customer');
        const secAdmin = document.getElementById('section-admin');
        const btnCustomer = document.getElementById('btn-tab-customer');
        const btnAdmin = document.getElementById('btn-tab-admin');

        if (role === 'customer') {
            secCustomer.classList.remove('hidden');
            secAdmin.classList.add('hidden');
            btnCustomer.className = "py-2.5 rounded-xl transition duration-200 bg-amber-500 text-slate-950 shadow font-bold";
            btnAdmin.className = "py-2.5 rounded-xl transition duration-200 text-slate-400 hover:text-white font-bold";
        } else {
            secCustomer.classList.add('hidden');
            secAdmin.classList.remove('hidden');
            btnAdmin.className = "py-2.5 rounded-xl transition duration-200 bg-amber-500 text-slate-950 shadow font-bold";
            btnCustomer.className = "py-2.5 rounded-xl transition duration-200 text-slate-400 hover:text-white font-bold";
        }
    }

    function toggleCustomerMode() {
        const loginForm = document.getElementById('customer-login-form');
        const registerForm = document.getElementById('customer-register-form');
        const title = document.getElementById('customer-mode-title');
        const btn = document.getElementById('customer-toggle-btn');

        if (loginForm.classList.contains('hidden')) {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            title.textContent = "Đăng nhập tài khoản khách hàng";
            btn.textContent = "Chưa có tài khoản? Đăng ký ngay";
        } else {
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
            title.textContent = "Đăng ký thành viên khách hàng mới";
            btn.textContent = "Đã có tài khoản? Đăng nhập";
        }
    }
</script>
@endpush
