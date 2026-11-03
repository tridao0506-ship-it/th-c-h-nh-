@extends('admin.layout')

@section('title', 'Quản Lý Sản Phẩm - SHOP ADMIN')
@section('page_title', 'Danh Sách Đồng Hồ Trong Kho')

@section('content')

<div class="bg-[#182234] border border-slate-800 rounded-3xl p-6 shadow-xl space-y-4">
    <div class="flex items-center justify-between pb-4 border-b border-slate-800">
        <h2 class="text-sm font-bold text-white uppercase tracking-wider">Tổng Số Sản Phẩm ({{ $products->total() }})</h2>
        <a href="{{ route('products.index') }}" target="_blank" class="text-xs text-sky-400 hover:underline">
            Xem trên giao diện khách hàng →
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-xs text-left text-slate-300">
            <thead class="text-[11px] uppercase tracking-wider text-slate-400 border-b border-slate-800">
                <tr>
                    <th class="py-3 px-4">Ảnh</th>
                    <th class="py-3 px-4">Đồng Hồ</th>
                    <th class="py-3 px-4">Thương Hiệu / Bộ Máy</th>
                    <th class="py-3 px-4">Giá Bán</th>
                    <th class="py-3 px-4">Đã Bán</th>
                    <th class="py-3 px-4">Tồn Kho & Nổi Bật</th>
                    <th class="py-3 px-4">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @foreach($products as $product)
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="py-3 px-4">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-xl object-contain bg-slate-950 p-1 border border-slate-800">
                        </td>
                        <td class="py-3 px-4 max-w-xs">
                            <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="font-semibold text-white hover:text-amber-400 line-clamp-1">
                                {{ $product->name }}
                            </a>
                            <div class="text-[10px] text-slate-400 mt-0.5">Mã SKU: {{ $product->sku }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <span class="font-cinzel text-amber-400 font-bold">{{ $product->brand }}</span>
                            <div class="text-[10px] text-slate-400">{{ $product->movement }} • {{ $product->dial_size }}</div>
                        </td>
                        <td class="py-3 px-4 font-bold text-amber-400">
                            {{ $product->formatted_price }}
                        </td>
                        <td class="py-3 px-4 font-semibold text-slate-300">
                            {{ $product->sold_count }} chiếc
                        </td>
                        <td class="py-3 px-4">
                            <form action="{{ route('admin.products.stock', $product->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <input type="number" name="stock" value="{{ $product->stock }}" min="0" class="w-16 bg-slate-950 border border-slate-700 rounded-lg px-2 py-1 text-xs text-white text-center focus:outline-none focus:border-amber-500">
                                <label class="flex items-center gap-1 text-[11px] text-slate-400">
                                    <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="rounded text-amber-500">
                                    <span>Hot</span>
                                </label>
                                <button type="submit" class="px-2 py-1 bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-slate-200 rounded text-[10px] font-bold transition">
                                    Lưu
                                </button>
                            </form>
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="text-slate-400 hover:text-amber-400 transition" title="Xem trên web">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pt-4">
        {{ $products->links() }}
    </div>
</div>

@endsection
