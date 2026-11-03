@extends('admin.layout')

@section('title', 'Báo Cáo Hoạt Động & Tồn Kho - SHOP ADMIN')
@section('page_title', 'Báo Cáo Bán Hàng & Kho Đồng Hồ')

@section('content')

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Tổng Doanh Thu Đạt Được</span>
            <i class="fa-solid fa-chart-line text-amber-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-amber-400">
            {{ number_format($totalRevenue, 0, ',', '.') }} ₫
        </div>
        <span class="text-[10px] text-emerald-400 font-semibold mt-1 block">Tất cả đơn hàng thành công</span>
    </div>

    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Tổng Mẫu Trong Kho</span>
            <i class="fa-solid fa-boxes-stacked text-sky-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-white">{{ $totalProducts }}</div>
        <span class="text-[10px] text-slate-400 mt-1 block">Thuộc các bộ sưu tập cao cấp</span>
    </div>

    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Sản Phẩm Cảnh Báo Tồn Thấp</span>
            <i class="fa-solid fa-triangle-exclamation text-rose-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-rose-400">{{ $lowStockProducts->count() }}</div>
        <span class="text-[10px] text-rose-400/80 mt-1 block">Số lượng còn lại ≤ 5 chiếc</span>
    </div>

    <div class="bg-[#182234] border border-slate-800 p-6 rounded-2xl shadow-lg">
        <div class="flex items-center justify-between text-slate-400 text-xs mb-2">
            <span>Đơn Hàng Bị Hủy</span>
            <i class="fa-solid fa-ban text-slate-400 text-lg"></i>
        </div>
        <div class="text-2xl font-bold text-slate-300">{{ $cancelledOrders }}</div>
        <span class="text-[10px] text-slate-400 mt-1 block">Tỷ lệ hủy: {{ $totalOrders > 0 ? round(($cancelledOrders / $totalOrders) * 100, 1) : 0 }}%</span>
    </div>

</div>

<!-- Top Selling Products & Low Stock Alerts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    
    <!-- Top Selling Products -->
    <div class="bg-[#182234] border border-slate-800 rounded-3xl p-6 shadow-xl space-y-4">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-fire text-amber-400"></i>
                <span>Top Đồng Hồ Bán Chạy Nhất</span>
            </h2>
            <span class="text-xs text-amber-400 font-semibold">Theo lượt bán ra</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-300">
                <thead class="text-[11px] uppercase tracking-wider text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="py-3 px-4">Đồng Hồ</th>
                        <th class="py-3 px-4">Thương Hiệu</th>
                        <th class="py-3 px-4">Đơn Giá</th>
                        <th class="py-3 px-4 text-right">Đã Bán</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @foreach($topProducts as $item)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3 px-4 flex items-center gap-2.5">
                                <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-8 h-8 rounded-lg object-contain bg-slate-900 border border-slate-700 p-0.5">
                                <span class="font-semibold text-white line-clamp-1 max-w-[160px]">{{ $item->name }}</span>
                            </td>
                            <td class="py-3 px-4 font-bold text-amber-400">{{ $item->brand }}</td>
                            <td class="py-3 px-4 font-semibold text-slate-300">{{ $item->formatted_price }}</td>
                            <td class="py-3 px-4 text-right">
                                <span class="px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/40 font-bold text-[10px]">
                                    {{ $item->sold_count }} chiếc
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="bg-[#182234] border border-slate-800 rounded-3xl p-6 shadow-xl space-y-4">
        <div class="flex items-center justify-between pb-4 border-b border-slate-800">
            <h2 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-400"></i>
                <span>Cảnh Báo Tồn Kho Sắp Hết (≤ 5)</span>
            </h2>
            <a href="{{ route('admin.products') }}" class="text-xs text-sky-400 hover:underline">Quản lý kho →</a>
        </div>

        @if($lowStockProducts->isEmpty())
            <div class="py-12 text-center text-slate-400 text-xs">
                <i class="fa-solid fa-circle-check text-emerald-400 text-2xl mb-2 block"></i>
                Mọi mẫu đồng hồ đều đang có số lượng tồn kho dồi dào.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-slate-300">
                    <thead class="text-[11px] uppercase tracking-wider text-slate-400 border-b border-slate-800">
                        <tr>
                            <th class="py-3 px-4">Đồng Hồ</th>
                            <th class="py-3 px-4">SKU</th>
                            <th class="py-3 px-4 text-right">Tồn Còn Lại</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @foreach($lowStockProducts as $low)
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="py-3 px-4 flex items-center gap-2.5">
                                    <img src="{{ $low->image }}" alt="{{ $low->name }}" class="w-8 h-8 rounded-lg object-contain bg-slate-900 border border-slate-700 p-0.5">
                                    <span class="font-semibold text-white line-clamp-1 max-w-[180px]">{{ $low->name }}</span>
                                </td>
                                <td class="py-3 px-4 font-mono text-slate-400">{{ $low->sku }}</td>
                                <td class="py-3 px-4 text-right">
                                    <span class="px-2.5 py-0.5 rounded-full font-bold text-[10px] {{ $low->stock == 0 ? 'bg-rose-950 text-rose-400 border border-rose-500/50' : 'bg-amber-950 text-amber-400 border border-amber-500/50' }}">
                                        {{ $low->stock == 0 ? 'Hết hàng (0)' : 'Còn ' . $low->stock . ' chiếc' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

@endsection
