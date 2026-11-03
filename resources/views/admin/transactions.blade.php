@extends('admin.layout')

@section('title', 'Giao Dịch Thanh Toán - Quản Trị Hệ Thống')
@section('page_title', 'Giao Dịch Thanh Toán')

@section('content')

<div class="space-y-6">

    <!-- Top Filter Row matching Screenshot Image 2 -->
    <div class="bg-white">
        <form action="{{ route('admin.finance.transactions') }}" method="GET" class="flex flex-wrap items-center gap-3">
            <span class="text-xs font-semibold text-slate-700">Sắp xếp</span>
            
            <div class="relative">
                <select name="sort" class="border border-slate-300 rounded-lg px-4 py-1.5 text-xs text-slate-700 bg-white pr-8 focus:outline-none focus:border-blue-500 appearance-none shadow-sm cursor-pointer">
                    <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Mới nhất</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá trị cao nhất</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá trị thấp nhất</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-slate-500">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
            </div>

            <button type="submit" class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                Áp dụng bộ lọc
            </button>

            <a href="{{ route('admin.finance.transactions') }}" class="px-4 py-1.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-semibold shadow-sm transition">
                Xóa bộ lọc
            </a>
        </form>

        <p class="text-xs text-slate-500 mt-4">
            Có <span class="font-bold text-slate-800">{{ $totalCount }}</span> đơn phù hợp bộ lọc. Số tiền bao gồm phí vận chuyển, ngày lọc là ngày tạo đơn.
        </p>
    </div>

    <!-- Section Header matching Screenshot Image 2 -->
    <div class="pt-2">
        <h2 class="text-sm font-bold text-slate-900">Danh sách giao dịch ({{ $totalCount }} đơn)</h2>
        <p class="text-xs text-slate-500 mt-0.5">
            COD: Xác nhận thu tiền hoặc thất bại; đơn đã thu tiền có thể chuyển sang chờ hoàn tiền rồi xác nhận đã hoàn tiền.
        </p>
    </div>

    <!-- Table Transactions matching Screenshot Image 2 -->
    <div class="overflow-x-auto border-t border-slate-200">
        <table class="w-full text-xs text-left text-slate-700 border-collapse">
            <thead>
                <tr class="border-b border-slate-200 bg-white">
                    <th class="py-3 px-4 font-bold text-slate-900 text-xs">Đơn hàng</th>
                    <th class="py-3 px-4 font-bold text-slate-900 text-xs">Khách hàng</th>
                    <th class="py-3 px-4 font-bold text-slate-900 text-xs">Phương thức</th>
                    <th class="py-3 px-4 font-bold text-slate-900 text-xs">Số tiền</th>
                    <th class="py-3 px-4 font-bold text-slate-900 text-xs">Thanh toán</th>
                    <th class="py-3 px-4 font-bold text-slate-900 text-xs">Cập nhật COD</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($transactions as $tx)
                    <tr class="hover:bg-slate-50/80 transition">
                        <!-- 1. Đơn hàng -->
                        <td class="py-3 px-4 align-top">
                            <span class="font-bold text-slate-900 text-xs">{{ $tx->order_code }}</span>
                            <div class="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                                <i class="fa-regular fa-clock text-[10px]"></i>
                                <span>{{ $tx->created_at ? $tx->created_at->format('d/m/Y H:i') : '24/09/2026 02:01' }}</span>
                            </div>
                        </td>

                        <!-- 2. Khách hàng -->
                        <td class="py-3 px-4 align-top">
                            <div class="font-semibold text-slate-800">{{ $tx->customer_name }}</div>
                            <div class="text-[11px] text-slate-500 flex items-center gap-1.5 mt-0.5">
                                <i class="fa-solid fa-phone text-[10px]"></i>
                                <span>{{ $tx->customer_phone }}</span>
                            </div>
                        </td>

                        <!-- 3. Phương thức -->
                        <td class="py-3 px-4 align-top">
                            @if(strtolower($tx->payment_method) === 'momo')
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#a50064] text-white inline-flex items-center gap-1 shadow-sm">
                                    <i class="fa-solid fa-wallet text-[9px]"></i>
                                    <span>MoMo</span>
                                </span>
                            @elseif(strtolower($tx->payment_method) === 'cod')
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-400 text-slate-950 inline-flex items-center gap-1 shadow-sm">
                                    <i class="fa-solid fa-truck text-[9px]"></i>
                                    <span>COD</span>
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-600 text-white inline-flex items-center gap-1 shadow-sm">
                                    <i class="fa-solid fa-building-columns text-[9px]"></i>
                                    <span>Banking</span>
                                </span>
                            @endif
                        </td>

                        <!-- 4. Số tiền -->
                        <td class="py-3 px-4 align-top">
                            <span class="font-bold text-slate-900 text-xs">
                                {{ number_format($tx->total_amount, 0, ',', '.') }} đ
                            </span>
                        </td>

                        <!-- 5. Thanh toán -->
                        <td class="py-3 px-4 align-top">
                            @if($tx->payment_status === 'paid')
                                <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-300">
                                    <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i>
                                    <span>Đã thanh toán</span>
                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5 pl-1">
                                    {{ $tx->updated_at ? $tx->updated_at->format('H:i d/m/Y') : '02:02 24/09/2026' }}
                                </div>
                            @elseif(strtolower($tx->payment_method) === 'momo')
                                <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-purple-50 text-purple-700 border border-purple-300">
                                    <i class="fa-solid fa-clock text-purple-600 text-[10px]"></i>
                                    <span>Đang chờ MoMo</span>
                                </div>
                            @elseif($tx->payment_status === 'failed')
                                <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-rose-50 text-rose-700 border border-rose-300">
                                    <i class="fa-solid fa-circle-xmark text-rose-600 text-[10px]"></i>
                                    <span>Thất bại</span>
                                </div>
                            @else
                                <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-amber-50 text-amber-700 border border-amber-300">
                                    <i class="fa-solid fa-clock text-amber-600 text-[10px]"></i>
                                    <span>Chờ thanh toán</span>
                                </div>
                            @endif
                        </td>

                        <!-- 6. Cập nhật COD -->
                        <td class="py-3 px-4 align-top">
                            @if(strtolower($tx->payment_method) !== 'cod')
                                <span class="px-2.5 py-1 rounded-full text-[11px] bg-slate-100 text-slate-600 border border-slate-200 inline-flex items-center gap-1">
                                    <i class="fa-solid fa-robot text-slate-500 text-[10px]"></i>
                                    <span>MoMo tự động</span>
                                </span>
                            @else
                                @if($tx->payment_status === 'paid')
                                    <span class="text-xs text-emerald-700 font-semibold flex items-center gap-1">
                                        <i class="fa-solid fa-check text-[10px]"></i> Đã thu tiền
                                    </span>
                                @else
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.transactions.status', $tx->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="payment_status" value="paid">
                                            <button type="submit" class="px-2.5 py-1 rounded bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-medium flex items-center gap-1 shadow-sm transition">
                                                <i class="fa-solid fa-check text-[10px]"></i>
                                                <span>Xác nhận thu tiền</span>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.transactions.status', $tx->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="payment_status" value="failed">
                                            <button type="submit" class="text-rose-600 hover:text-rose-700 hover:underline text-[11px] font-medium transition">
                                                Thất bại
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400 text-xs">
                            Không có giao dịch nào phù hợp với bộ lọc hiện tại.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pt-4 border-t border-slate-200">
        {{ $transactions->appends(request()->query())->links() }}
    </div>

</div>

@endsection
