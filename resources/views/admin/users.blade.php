@extends('admin.layout')

@section('title', 'Quản Lý Người Dùng - SHOP ADMIN')
@section('page_title', 'Quản Lý Người Dùng Hệ Thống')

@section('content')

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Tổng Người Dùng</span>
            <i class="fa-solid fa-user-group text-sky-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-white">{{ $totalUsers }}</div>
        <span class="text-[10px] text-slate-400 mt-1 block">Tài khoản đã đăng ký trên hệ thống</span>
    </div>

    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Tài Khoản Quản Trị (Admin)</span>
            <i class="fa-solid fa-user-shield text-amber-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-amber-400">{{ $adminCount }}</div>
        <span class="text-[10px] text-amber-400/80 mt-1 block">Có toàn quyền quản lý hệ thống</span>
    </div>

    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Khách Hàng Mua Sắm</span>
            <i class="fa-solid fa-users text-emerald-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-emerald-400">{{ $customerCount }}</div>
        <span class="text-[10px] text-slate-400 mt-1 block">Khách hàng thành viên đã kích hoạt</span>
    </div>
</div>

<!-- Table Users -->
<div class="bg-[#182234] border border-slate-800 rounded-3xl p-6 shadow-xl space-y-4">
    <div class="flex items-center justify-between pb-4 border-b border-slate-800">
        <div>
            <h2 class="text-sm font-bold text-white uppercase tracking-wider">Danh Sách Tài Khoản Thành Viên</h2>
            <p class="text-[11px] text-slate-400 mt-0.5">Phân quyền, kiểm tra email và quản lý khách hàng</p>
        </div>
        <span class="text-xs text-slate-400">Hiển thị {{ $users->total() }} tài khoản</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-xs text-left text-slate-300">
            <thead class="text-[11px] uppercase tracking-wider text-slate-400 border-b border-slate-800">
                <tr>
                    <th class="py-3 px-4">Thành Viên</th>
                    <th class="py-3 px-4">Email Đăng Nhập</th>
                    <th class="py-3 px-4">Số Điện Thoại</th>
                    <th class="py-3 px-4">Vai Trò</th>
                    <th class="py-3 px-4">Ngày Tham Gia</th>
                    <th class="py-3 px-4 text-right">Phân Quyền</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @foreach($users as $user)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-white text-xs">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-white">{{ $user->name }}</div>
                                    @if($user->id === Auth::id())
                                        <span class="text-[9px] text-cyan-400 font-semibold">(Tài khoản của bạn)</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4 font-mono text-slate-300">
                            {{ $user->email }}
                        </td>
                        <td class="py-3.5 px-4 font-mono text-amber-400">
                            {{ $user->phone ?? 'Chưa cập nhật' }}
                        </td>
                        <td class="py-3.5 px-4">
                            @if($user->isAdmin())
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-500/20 text-amber-300 border border-amber-500/40 inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-crown text-[9px]"></i>
                                    Quản Trị Viên
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-slate-800 text-slate-300 border border-slate-700 inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-user text-[9px]"></i>
                                    Khách Hàng
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-4 text-slate-400">
                            {{ $user->created_at ? $user->created_at->format('H:i d/m/Y') : 'Khởi tạo hệ thống' }}
                        </td>
                        <td class="py-3.5 px-4 text-right">
                            @if($user->id !== Auth::id())
                                <form action="{{ route('admin.users.role', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn đổi vai trò cho {{ $user->name }}?');">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-[10px] font-semibold transition {{ $user->isAdmin() ? 'bg-slate-800 hover:bg-slate-700 text-slate-300 border border-slate-700' : 'bg-amber-500/20 hover:bg-amber-500 hover:text-slate-950 text-amber-300 border border-amber-500/40' }}">
                                        {{ $user->isAdmin() ? 'Hạ xuống Khách hàng' : 'Thăng cấp Quản trị' }}
                                    </button>
                                </form>
                            @else
                                <span class="text-[10px] text-slate-500 italic">Đang đăng nhập</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pt-4 border-t border-slate-800">
        {{ $users->links() }}
    </div>
</div>

@endsection
