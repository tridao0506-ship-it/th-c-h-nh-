@extends('layouts.app')

@section('title', 'Xác Thực Email | ChronoLux')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl text-center space-y-5">
        <div class="w-16 h-16 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 flex items-center justify-center mx-auto text-2xl shadow-[0_0_20px_rgba(245,158,11,0.2)]">
            <i class="fa-solid fa-envelope-circle-check"></i>
        </div>

        <div>
            <h1 class="text-xl sm:text-2xl font-serif font-bold text-white mb-2">Xác Thực Địa Chỉ Email</h1>
            <p class="text-xs text-slate-300 leading-relaxed">
                Hệ thống đã gửi liên kết kích hoạt đến email:<br>
                <strong class="text-amber-400 font-semibold">{{ Auth::user()->email ?? 'của bạn' }}</strong>.
            </p>
            <p class="text-[11px] text-slate-400 mt-2">
                Vui lòng kiểm tra hộp thư đến (hoặc thư mục Spam / Rác) và nhấp vào liên kết để hoàn tất kích hoạt tài khoản.
            </p>
        </div>

        @if (session('error'))
            <div class="p-3.5 rounded-2xl bg-rose-950/80 border border-rose-500/50 text-rose-300 text-xs flex items-center gap-2 text-left">
                <i class="fa-solid fa-triangle-exclamation text-rose-400 flex-shrink-0 text-base"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if (session('message'))
            <div class="p-3 rounded-2xl bg-emerald-950/80 border border-emerald-500/50 text-emerald-300 text-xs flex items-center gap-2 text-left">
                <i class="fa-solid fa-circle-check text-emerald-400 flex-shrink-0"></i>
                <span>{{ session('message') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="p-3 rounded-2xl bg-amber-950/80 border border-amber-500/50 text-amber-300 text-xs flex items-center gap-2 text-left">
                <i class="fa-solid fa-circle-info text-amber-400 flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="pt-2 space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Gửi Lại Email Xác Thực</span>
                </button>
            </form>

            <div class="flex items-center justify-between text-xs pt-2 border-t border-slate-800 text-slate-400">
                <a href="{{ url('/') }}" class="hover:text-amber-400 transition flex items-center gap-1">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Về trang chủ</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-rose-400 hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Đăng xuất</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
