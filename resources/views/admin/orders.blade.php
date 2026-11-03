@extends('admin.layout')

@section('title', 'Xử Lý & Quản Lý Đơn Hàng - SHOP ADMIN')
@section('page_title', 'Xử Lý & Quản Lý Đơn Hàng')

@section('content')

<div class="space-y-6">

    <!-- 1. Header Đơn Hàng Chuẩn Ảnh Mẫu -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-200">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-400/20 text-amber-500 flex items-center justify-center text-xl flex-shrink-0 mt-0.5">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 tracking-tight">Xử Lý & Quản Lý Đơn Hàng</h2>
                <p class="text-xs text-slate-500 mt-0.5">Theo dõi chỉ số giá trị, chuyển trạng thái và quản lý hủy đơn theo quy tắc chuẩn</p>
            </div>
        </div>
        <div class="flex-shrink-0">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-900 text-white text-xs font-bold shadow-sm">
                <i class="fa-solid fa-bag-shopping text-amber-400"></i>
                <span>Tổng cộng: {{ $totalOrders }} đơn</span>
            </span>
        </div>
    </div>

    <!-- 2. 4 Thẻ Thống Kê Chỉ Số Chuẩn Ảnh Mẫu -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Card 1: DOANH THU ĐÃ THU (Xanh lá) -->
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-emerald-500 p-4 shadow-xs space-y-1">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">DOANH THU ĐÃ THU</span>
                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">Đã bảo đảm</span>
            </div>
            <div class="text-xl font-black text-emerald-600 pt-1">
                {{ number_format($paidRevenue, 0, ',', '.') }} VNĐ
            </div>
            <div class="text-[11px] text-slate-400">
                Từ {{ $statusCounts['completed'] }} đơn đã hoàn thành
            </div>
        </div>

        <!-- Card 2: CẦN XỬ LÝ / ĐÓNG GÓI (Vàng cam) -->
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-amber-400 p-4 shadow-xs space-y-1">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">CẦN XỬ LÝ / ĐÓNG GÓI</span>
                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">🟡 Chờ duyệt/Hủy</span>
            </div>
            <div class="text-xl font-black text-slate-900 pt-1">
                {{ $statusCounts['pending'] + $statusCounts['processing'] }} đơn
            </div>
            <div class="text-[11px] text-slate-400">
                Giá trị: <strong class="text-slate-700 font-semibold">{{ number_format($pendingValue, 0, ',', '.') }} VNĐ</strong>
            </div>
        </div>

        <!-- Card 3: ĐANG VẬN CHUYỂN (Cyan) -->
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-cyan-400 p-4 shadow-xs space-y-1">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">ĐANG VẬN CHUYỂN</span>
                <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-700 text-[10px] font-bold">🔒 Không cho hủy</span>
            </div>
            <div class="text-xl font-black text-slate-900 pt-1">
                {{ $statusCounts['shipping'] }} đơn
            </div>
            <div class="text-[11px] text-slate-400">
                Giá trị: <strong class="text-slate-700 font-semibold">{{ number_format($shippingValue, 0, ',', '.') }} VNĐ</strong> (GHN giao hàng)
            </div>
        </div>

        <!-- Card 4: KẾT QUẢ ĐƠN HÀNG (Slate) -->
        <div class="bg-white rounded-2xl border border-slate-200 border-l-4 border-l-slate-400 p-4 shadow-xs space-y-1">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">KẾT QUẢ ĐƠN HÀNG</span>
                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold">Tổng: {{ $totalOrders }}</span>
            </div>
            <div class="flex items-center gap-3 pt-2 text-xs font-bold">
                <div class="flex items-center gap-1.5 text-emerald-600">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>{{ $statusCounts['completed'] }} Hoàn thành</span>
                </div>
                <div class="h-4 w-px bg-slate-200"></div>
                <div class="flex items-center gap-1.5 text-rose-600">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    <span>{{ $statusCounts['cancelled'] }} Đã hủy đơn</span>
                </div>
            </div>
        </div>

    </div>

    <!-- 3. Thanh Nút Lọc Trạng Thái Nhanh (Pills) -->
    @php
        $currSt = request('order_status', 'all');
    @endphp
    <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-semibold whitespace-nowrap">
        <a href="{{ route('admin.orders', ['order_status' => 'all']) }}" 
           class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'all' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
            Tất cả ({{ $statusCounts['all'] }})
        </a>
        <a href="{{ route('admin.orders', ['order_status' => 'pending']) }}" 
           class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'pending' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
            Chờ xử lý ({{ $statusCounts['pending'] }})
        </a>
        <a href="{{ route('admin.orders', ['order_status' => 'paid']) }}" 
           class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'paid' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
            Đã thanh toán ({{ $statusCounts['paid'] }})
        </a>
        <a href="{{ route('admin.orders', ['order_status' => 'processing']) }}" 
           class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'processing' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
            Đang đóng gói ({{ $statusCounts['processing'] }})
        </a>
        <a href="{{ route('admin.orders', ['order_status' => 'shipping']) }}" 
           class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'shipping' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
            Đang giao hàng ({{ $statusCounts['shipping'] }})
        </a>
        <a href="{{ route('admin.orders', ['order_status' => 'completed']) }}" 
           class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'completed' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
            Hoàn thành ({{ $statusCounts['completed'] }})
        </a>
        <a href="{{ route('admin.orders', ['order_status' => 'cancelled']) }}" 
           class="px-3.5 py-1.5 rounded-lg transition {{ $currSt === 'cancelled' ? 'bg-slate-900 text-white font-bold shadow-xs' : 'bg-slate-100 hover:bg-slate-200 text-slate-600' }}">
            Đã hủy ({{ $statusCounts['cancelled'] }})
        </a>
    </div>

    <!-- 4. Thanh Tìm Kiếm & Bộ Lọc Nâng Cao -->
    <form action="{{ route('admin.orders') }}" method="GET" class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 flex flex-wrap items-center gap-3 text-xs">
        
        <!-- Lọc theo Trạng Thái -->
        <div class="flex items-center gap-2">
            <label class="font-bold text-slate-700 whitespace-nowrap">Lọc theo Trạng Thái:</label>
            <select name="order_status" class="border border-slate-300 rounded-lg px-3 py-1.5 bg-white text-slate-800 focus:outline-none focus:border-blue-500 shadow-2xs">
                <option value="all" {{ request('order_status') == 'all' ? 'selected' : '' }}>-- Tất cả trạng thái --</option>
                <option value="pending" {{ request('order_status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="paid" {{ request('order_status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                <option value="processing" {{ request('order_status') == 'processing' ? 'selected' : '' }}>Đang đóng gói</option>
                <option value="shipping" {{ request('order_status') == 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                <option value="completed" {{ request('order_status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="cancelled" {{ request('order_status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
            </select>
        </div>

        <!-- Hình thức Thanh toán -->
        <div class="flex items-center gap-2">
            <label class="font-bold text-slate-700 whitespace-nowrap">Hình thức Thanh toán:</label>
            <select name="payment_method" class="border border-slate-300 rounded-lg px-3 py-1.5 bg-white text-slate-800 focus:outline-none focus:border-blue-500 shadow-2xs">
                <option value="all" {{ request('payment_method') == 'all' ? 'selected' : '' }}>-- Tất cả phương thức --</option>
                <option value="momo" {{ request('payment_method') == 'momo' ? 'selected' : '' }}>MoMo</option>
                <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>Tiền mặt khi nhận hàng (COD)</option>
                <option value="banking" {{ request('payment_method') == 'banking' ? 'selected' : '' }}>Chuyển khoản (Banking)</option>
            </select>
        </div>

        <!-- Tìm kiếm đơn hàng -->
        <div class="flex items-center gap-2 flex-1 min-w-[200px]">
            <label class="font-bold text-slate-700 whitespace-nowrap">Tìm kiếm đơn hàng:</label>
            <div class="relative flex-1">
                <input type="text" name="order_q" value="{{ request('order_q') }}" placeholder="🔍 Mã #DH, tên khách, SĐT, email..." 
                       class="w-full border border-slate-300 rounded-lg px-3 py-1.5 bg-white text-slate-800 focus:outline-none focus:border-blue-500 shadow-2xs">
            </div>
        </div>

        <!-- Nút Lọc & Xóa -->
        <div class="flex items-center gap-2">
            <button type="submit" class="px-4 py-1.5 bg-slate-900 hover:bg-black text-white font-bold rounded-lg transition shadow-sm flex items-center gap-1.5">
                <i class="fa-solid fa-filter text-amber-400"></i>
                <span>Lọc</span>
            </button>
            @if(request('order_status') || request('payment_method') || request('order_q'))
                <a href="{{ route('admin.orders') }}" class="px-3 py-1.5 bg-white border border-slate-300 hover:bg-slate-100 text-slate-600 font-semibold rounded-lg transition">
                    Xóa lọc
                </a>
            @endif
        </div>
    </form>

    <!-- 5. Bảng Danh Sách Đơn Hàng (Header Xanh Đen #182234 Chuẩn Ảnh Mẫu) -->
    <div class="overflow-x-auto border border-slate-200 rounded-2xl shadow-sm bg-white">
        <table class="w-full text-xs text-left text-slate-700 min-w-[880px] border-collapse">
            <thead class="bg-[#182234] text-white uppercase text-[11px] tracking-wider font-bold">
                <tr>
                    <th class="py-2.5 px-3.5">MÃ ĐƠN</th>
                    <th class="py-2.5 px-3.5">KHÁCH HÀNG</th>
                    <th class="py-2.5 px-3.5">SẢN PHẨM & ĐỊA CHỈ</th>
                    <th class="py-2.5 px-3.5">TỔNG TIỀN</th>
                    <th class="py-2.5 px-3.5 text-center">TRẠNG THÁI</th>
                    <th class="py-2.5 px-3.5 text-center">CHUYỂN TRẠNG THÁI</th>
                    <th class="py-2.5 px-3.5 text-center">XỬ LÝ / THAO TÁC</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($orders as $ord)
                    <tr class="hover:bg-slate-50/80 transition">
                        
                        <!-- 1. MÃ ĐƠN -->
                        <td class="py-2.5 px-3.5 align-top whitespace-nowrap">
                            <div class="font-bold text-slate-900 text-xs">{{ $ord->order_code }}</div>
                            <div class="text-[10px] text-slate-400 mt-0.5">{{ $ord->created_at->format('d/m/Y H:i') }}</div>
                        </td>

                        <!-- 2. KHÁCH HÀNG -->
                        <td class="py-2.5 px-3.5 align-top">
                            <div class="font-bold text-slate-900">{{ $ord->customer_name }}</div>
                            <div class="text-[11px] text-slate-500 flex items-center gap-1 mt-0.5 whitespace-nowrap">
                                <i class="fa-solid fa-phone text-[10px] text-slate-400"></i>
                                <span>{{ $ord->customer_phone }}</span>
                            </div>
                            @if($ord->customer_email)
                                <div class="text-[10px] text-slate-400 flex items-center gap-1 mt-0.5 truncate max-w-[150px]">
                                    <i class="fa-regular fa-envelope text-[10px]"></i>
                                    <span>{{ $ord->customer_email }}</span>
                                </div>
                            @endif
                        </td>

                        <!-- 3. SẢN PHẨM & ĐỊA CHỈ -->
                        <td class="py-2.5 px-3.5 align-top max-w-xs">
                            <div class="flex items-start gap-1.5 text-slate-900 font-medium text-xs">
                                <span class="w-4 h-4 rounded-full bg-amber-400 text-slate-950 inline-flex items-center justify-center text-[9px] mt-0.5 flex-shrink-0 shadow-xs"><i class="fa-solid fa-clock text-[8px]"></i></span>
                                <div class="space-y-0.5 min-w-0">
                                    @if($ord->items->isNotEmpty())
                                        @foreach($ord->items as $it)
                                            <div class="line-clamp-1 font-semibold text-slate-800">{{ $it->product_name }} <span class="font-bold text-slate-600">x{{ $it->quantity }}</span></div>
                                        @endforeach
                                    @else
                                        <div class="line-clamp-1 font-semibold text-slate-800">Đồng hồ ChronoLux cao cấp</div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-start gap-1.5 text-[11px] text-slate-500 mt-1">
                                <i class="fa-solid fa-location-dot text-rose-500 mt-0.5 flex-shrink-0"></i>
                                <span class="line-clamp-1">{{ $ord->shipping_address ?? 'Số 7 Phú Diễn, Phường Phúc Diễn, Hà Nội' }}</span>
                            </div>
                        </td>

                        <!-- 4. TỔNG TIỀN -->
                        <td class="py-2.5 px-3.5 align-top whitespace-nowrap">
                            <div class="font-black text-slate-900 text-xs">
                                {{ number_format($ord->total_amount, 0, ',', '.') }} VNĐ
                            </div>
                            <div class="mt-1">
                                @if($ord->payment_method === 'momo')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-[#a50064] text-white shadow-2xs">
                                        MoMo
                                    </span>
                                @elseif($ord->payment_method === 'banking')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-600 text-white shadow-2xs">
                                        BANKING
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500 text-white shadow-2xs">
                                        COD
                                    </span>
                                @endif
                            </div>
                        </td>

                        <!-- 5. TRẠNG THÁI -->
                        <td class="py-2.5 px-3.5 align-top text-center whitespace-nowrap">
                            @if($ord->order_status === 'completed')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500 text-white shadow-2xs">
                                    Hoàn thành
                                </span>
                            @elseif($ord->order_status === 'shipping')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-indigo-500 text-white shadow-2xs">
                                    Đang giao hàng
                                </span>
                            @elseif($ord->order_status === 'processing')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500 text-white shadow-2xs">
                                    Đang đóng gói
                                </span>
                            @elseif($ord->order_status === 'cancelled')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-500 text-white shadow-2xs">
                                    Đã hủy
                                </span>
                            @elseif($ord->payment_status === 'paid')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-cyan-500 text-white shadow-2xs">
                                    Đã thanh toán
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-300 shadow-2xs">
                                    Chờ xử lý
                                </span>
                            @endif
                        </td>

                        <!-- 6. CHUYỂN TRẠNG THÁI -->
                        <td class="py-2.5 px-3.5 align-top text-center whitespace-nowrap">
                            <form action="{{ route('admin.orders.status', $ord->id) }}" method="POST">
                                @csrf
                                <select name="order_status" onchange="this.form.submit()" 
                                        class="border border-slate-300 rounded-lg px-2.5 py-1 text-xs text-slate-700 bg-white focus:outline-none focus:border-blue-500 cursor-pointer shadow-2xs">
                                    <option value="pending" {{ $ord->order_status === 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="paid" {{ $ord->payment_status === 'paid' && $ord->order_status !== 'completed' ? 'selected' : '' }}>Đã thanh toán</option>
                                    <option value="processing" {{ $ord->order_status === 'processing' ? 'selected' : '' }}>Đang đóng gói</option>
                                    <option value="shipping" {{ $ord->order_status === 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                                    <option value="completed" {{ $ord->order_status === 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                    <option value="cancelled" {{ $ord->order_status === 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                            </form>
                        </td>

                        <!-- 7. XỬ LÝ / THAO TÁC -->
                        <td class="py-2.5 px-3.5 align-top text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Nút Chi Tiết -->
                                <button type="button" 
                                        onclick="showOrderDetailModal('{{ $ord->order_code }}', '{{ addslashes($ord->customer_name) }}', '{{ $ord->customer_phone }}', '{{ addslashes($ord->customer_email ?? '') }}', '{{ addslashes($ord->shipping_address ?? 'Số 7 Phú Diễn, Phường Phúc Diễn, Hà Nội') }}', '{{ number_format($ord->total_amount, 0, ',', '.') }} VNĐ', '{{ strtoupper($ord->payment_method) }}', '{{ $ord->order_status }}', '{{ $ord->created_at->format('d/m/Y H:i') }}', '{{ addslashes($ord->notes ?? 'Không có ghi chú') }}')"
                                        class="px-3 py-1 rounded-full border border-blue-400 text-blue-600 hover:bg-blue-50 font-medium text-xs flex items-center gap-1 transition shadow-2xs">
                                    <i class="fa-regular fa-eye"></i>
                                    <span>Chi tiết</span>
                                </button>

                                <!-- Nút Hủy Đơn -->
                                @if($ord->order_status !== 'cancelled' && $ord->order_status !== 'shipping' && $ord->order_status !== 'completed')
                                    <form action="{{ route('admin.orders.cancel', $ord->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng {{ $ord->order_code }}?');">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 rounded-full border border-rose-300 text-rose-500 hover:bg-rose-50 font-medium text-xs flex items-center gap-1 transition shadow-2xs">
                                            <i class="fa-solid fa-xmark"></i>
                                            <span>Hủy</span>
                                        </button>
                                    </form>
                                @else
                                    <span class="px-2 py-1 text-slate-300 text-xs">-</span>
                                @endif
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-slate-400">
                            Không tìm thấy đơn hàng nào phù hợp với bộ lọc.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="mt-4 flex flex-col sm:flex-row items-center justify-between gap-3 bg-white p-3.5 rounded-xl border border-slate-200 text-xs shadow-xs">
            <div class="text-slate-500">
                Hiển thị <span class="font-bold text-slate-800">{{ $orders->firstItem() }}</span> - <span class="font-bold text-slate-800">{{ $orders->lastItem() }}</span> trên tổng số <span class="font-bold text-slate-800">{{ $orders->total() }}</span> đơn hàng
            </div>
            <div class="flex items-center gap-1.5 flex-wrap">
                {{-- Nút trang trước --}}
                @if ($orders->onFirstPage())
                    <span class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed text-xs flex items-center gap-1">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i> Trước
                    </span>
                @else
                    <a href="{{ $orders->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-medium transition shadow-2xs text-xs flex items-center gap-1">
                        <i class="fa-solid fa-chevron-left text-[10px]"></i> Trước
                    </a>
                @endif

                {{-- Các số trang --}}
                @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                    @if ($page == $orders->currentPage())
                        <span class="w-8 h-8 rounded-lg bg-[#182234] text-white font-bold flex items-center justify-center shadow-xs text-xs">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-medium flex items-center justify-center transition shadow-2xs text-xs">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Nút trang sau --}}
                @if ($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-medium transition shadow-2xs text-xs flex items-center gap-1">
                        Sau <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </a>
                @else
                    <span class="px-3 py-1.5 rounded-lg border border-slate-200 text-slate-300 cursor-not-allowed text-xs flex items-center gap-1">
                        Sau <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    </span>
                @endif
            </div>
        </div>
    @endif

</div>

<!-- MODAL: CHI TIẾT ĐƠN HÀNG -->
<div id="modal-order-detail" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-2xl w-full space-y-5 shadow-2xl relative text-slate-800 border border-slate-200">
        <button type="button" onclick="closeOrderDetailModal()" class="absolute top-5 right-5 text-slate-400 hover:text-slate-800 transition">
            <i class="fa-solid fa-xmark text-xl"></i>
        </button>

        <div class="flex items-center gap-3 pb-3 border-b border-slate-200">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shadow-xs">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-bold text-slate-900">Chi Tiết Đơn Hàng <span id="modal-order-code" class="text-blue-600 font-mono"></span></h3>
                <p class="text-xs text-slate-500">Ngày tạo: <span id="modal-order-date"></span></p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                <div class="font-bold text-slate-900 uppercase text-[11px] tracking-wider flex items-center gap-1.5 text-blue-600">
                    <i class="fa-solid fa-user"></i>
                    <span>Thông Tin Khách Hàng</span>
                </div>
                <div><span class="text-slate-500">Họ và tên:</span> <strong id="modal-customer-name" class="text-slate-900"></strong></div>
                <div><span class="text-slate-500">Số điện thoại:</span> <span id="modal-customer-phone" class="font-semibold text-slate-900"></span></div>
                <div><span class="text-slate-500">Email:</span> <span id="modal-customer-email" class="text-slate-700"></span></div>
                <div><span class="text-slate-500">Địa chỉ nhận:</span> <span id="modal-shipping-address" class="text-slate-800 font-medium"></span></div>
                <div><span class="text-slate-500">Ghi chú:</span> <span id="modal-order-notes" class="italic text-slate-600"></span></div>
            </div>

            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-2">
                <div class="font-bold text-slate-900 uppercase text-[11px] tracking-wider flex items-center gap-1.5 text-emerald-600">
                    <i class="fa-solid fa-credit-card"></i>
                    <span>Thanh Toán & Trạng Thái</span>
                </div>
                <div><span class="text-slate-500">Tổng tiền đơn:</span> <strong id="modal-order-total" class="text-base font-black text-rose-600"></strong></div>
                <div><span class="text-slate-500">Hình thức:</span> <span id="modal-payment-method" class="font-bold px-2 py-0.5 rounded bg-slate-200 text-slate-800 text-[10px]"></span></div>
                <div><span class="text-slate-500">Trạng thái:</span> <span id="modal-order-status" class="font-bold text-blue-600"></span></div>
                <div class="pt-2 text-[11px] text-slate-500">
                    <i class="fa-solid fa-truck text-slate-400 mr-1"></i> Giao hàng tiêu chuẩn GHN hỏa tốc
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2 pt-2 border-t border-slate-200">
            <button type="button" onclick="closeOrderDetailModal()" class="px-5 py-2 rounded-xl bg-slate-900 hover:bg-black text-white font-bold text-xs transition shadow-sm">
                Đóng cửa sổ
            </button>
        </div>
    </div>
</div>

<script>
    function showOrderDetailModal(code, name, phone, email, address, total, method, status, date, notes) {
        document.getElementById('modal-order-code').textContent = code;
        document.getElementById('modal-order-date').textContent = date;
        document.getElementById('modal-customer-name').textContent = name;
        document.getElementById('modal-customer-phone').textContent = phone;
        document.getElementById('modal-customer-email').textContent = email || 'Không có';
        document.getElementById('modal-shipping-address').textContent = address || 'Địa chỉ mặc định';
        document.getElementById('modal-order-total').textContent = total;
        document.getElementById('modal-payment-method').textContent = method;
        document.getElementById('modal-order-status').textContent = status;
        document.getElementById('modal-order-notes').textContent = notes || 'Không có';
        document.getElementById('modal-order-detail').classList.remove('hidden');
    }

    function closeOrderDetailModal() {
        document.getElementById('modal-order-detail').classList.add('hidden');
    }
</script>

@endsection
