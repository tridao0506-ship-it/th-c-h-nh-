@extends('admin.layout')

@section('title', 'Quản Lý Danh Mục & Thương Hiệu - SHOP ADMIN')
@section('page_title', 'Quản Lý Danh Mục & Thương Hiệu')

@section('content')

<!-- Stat summary -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Tổng Danh Mục / Thương Hiệu</span>
            <i class="fa-solid fa-layer-group text-sky-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-white">{{ $categories->count() }}</div>
        <span class="text-[10px] text-slate-400 mt-1 block">Bao gồm Thụy Sĩ, Nhật Bản, Đức</span>
    </div>

    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Thương Hiệu Nổi Bật</span>
            <i class="fa-solid fa-star text-amber-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-amber-400">{{ $categories->where('is_featured', true)->count() }}</div>
        <span class="text-[10px] text-slate-400 mt-1 block">Hiển thị ưu tiên trên thanh điều hướng</span>
    </div>

    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Tổng Sản Phẩm Thuộc Danh Mục</span>
            <i class="fa-solid fa-clock text-emerald-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-emerald-400">{{ $categories->sum('products_count') }}</div>
        <span class="text-[10px] text-slate-400 mt-1 block">Đang phân phối tại showroom</span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Danh sách Danh mục (2 cols) -->
    <div class="lg:col-span-2 bg-[#182234] border border-slate-800 rounded-3xl p-6 shadow-xl space-y-4">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider">Danh Sách Thương Hiệu / Danh Mục</h2>
            <span class="text-xs text-slate-400">{{ $categories->count() }} thương hiệu</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-300">
                <thead class="text-[11px] uppercase tracking-wider text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="py-3 px-4">Thương Hiệu</th>
                        <th class="py-3 px-4">Quốc Gia</th>
                        <th class="py-3 px-4">Số Mẫu Đồng Hồ</th>
                        <th class="py-3 px-4">Đường Dẫn Slug</th>
                        <th class="py-3 px-4">Trạng Thái</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-white text-sm flex items-center gap-2">
                                    <i class="fa-solid fa-shield-halved text-amber-400 text-xs"></i>
                                    <span>{{ $category->name }}</span>
                                </div>
                                @if($category->description)
                                    <div class="text-[10px] text-slate-400 line-clamp-1 mt-0.5">{{ $category->description }}</div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-300">
                                <span class="px-2.5 py-1 rounded-md bg-slate-800 border border-slate-700 text-slate-300 text-[11px]">
                                    {{ $category->country ?? 'Quốc tế' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-amber-400">
                                {{ $category->products_count }} mẫu
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-400 text-[11px]">
                                /{{ $category->slug }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if($category->is_featured)
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-emerald-950/80 text-emerald-400 border border-emerald-500/40">
                                        Nổi bật
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-semibold bg-slate-800 text-slate-400 border border-slate-700">
                                        Tiêu chuẩn
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">
                                Chưa có danh mục nào. Hãy tạo danh mục đầu tiên!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Thêm Danh Mục Mới (1 col) -->
    <div class="bg-[#182234] border border-slate-800 rounded-3xl p-6 shadow-xl space-y-5 h-fit">
        <div class="pb-3 border-b border-slate-800">
            <h3 class="text-sm font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-plus-circle text-sky-400"></i>
                <span>Thêm Thương Hiệu Mới</span>
            </h3>
            <p class="text-[11px] text-slate-400 mt-1">Đăng ký thêm thương hiệu đồng hồ vào hệ thống quản lý.</p>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4 text-xs">
            @csrf
            <div>
                <label class="block text-slate-300 font-semibold mb-1.5">Tên thương hiệu *</label>
                <input type="text" name="name" required placeholder="Ví dụ: Breitling, Tudor..."
                       class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 transition">
            </div>

            <div>
                <label class="block text-slate-300 font-semibold mb-1.5">Quốc gia xuất xứ</label>
                <input type="text" name="country" placeholder="Ví dụ: Thụy Sĩ, Nhật Bản, Đức..."
                       class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2.5 text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 transition">
            </div>

            <div>
                <label class="block text-slate-300 font-semibold mb-1.5">Mô tả ngắn</label>
                <textarea name="description" rows="3" placeholder="Đặc trưng lịch sử, tinh hoa chế tác..."
                          class="w-full bg-slate-900 border border-slate-700 rounded-xl px-3.5 py-2 text-white placeholder-slate-500 focus:outline-none focus:border-amber-400 transition resize-none"></textarea>
            </div>

            <button type="submit" class="w-full py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold transition flex items-center justify-center gap-2 shadow-lg shadow-amber-500/20">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>Lưu Thương Hiệu</span>
            </button>
        </form>
    </div>

</div>

@endsection
