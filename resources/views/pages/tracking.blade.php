@extends('layouts.app')

@section('title', 'Tra Cứu Trạng Thái Đơn Hàng | ChronoLux')

@section('content')

<div class="bg-slate-900 border-b border-slate-800 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3">
        <span class="font-cinzel text-amber-400 text-xs uppercase tracking-widest font-semibold">Theo Dõi Đơn Hàng Trực Tuyến</span>
        <h1 class="text-3xl font-bold font-serif text-white">Tra Cứu Tiến Độ Vận Chuyển Đồng Hồ</h1>
        <p class="text-xs text-slate-400 max-w-md mx-auto">
            Nhập mã đơn hàng (Ví dụ: CL-20261031-XXXXX) hoặc số điện thoại quý khách đã đăng ký khi đặt mua.
        </p>

        <!-- Search Form -->
        <div class="max-w-lg mx-auto pt-4">
            <form action="{{ route('orders.tracking') }}" method="GET" class="flex gap-2">
                <div class="relative flex-1">
                    <input type="text" name="q" value="{{ request('q', $keyword ?? '') }}" required placeholder="Nhập mã đơn (CL-...) hoặc Số điện thoại..." 
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-xs text-white uppercase focus:outline-none focus:border-amber-500 shadow-inner">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                </div>
                <button type="submit" class="px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition flex items-center gap-1.5 shadow">
                    <span>Tra cứu</span>
                </button>
            </form>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    @if(session('momo_success_amount'))
        <!-- MoMo Demo Popup Thành công (Khớp Image 1) -->
        <div id="momo_success_modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4">
            <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl animate-in fade-in zoom-in duration-200 space-y-4">
                <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-500 mx-auto flex items-center justify-center text-4xl shadow-sm">
                    <i class="fa-solid fa-check"></i>
                </div>
                
                <h3 class="text-xl font-extrabold text-slate-800">Thanh toán thành công</h3>
                
                <div class="my-3 p-4 rounded-2xl border-2 border-dashed border-pink-300 bg-pink-50">
                    <div class="text-xs text-[#a21caf] font-extrabold uppercase tracking-wider mb-1">MOMO DEMO</div>
                    <div class="text-3xl font-black text-[#be185d] font-mono tracking-tight">
                        {{ number_format(session('momo_success_amount'), 0, ',', '.') }}đ
                    </div>
                </div>

                <div class="pt-2 space-y-2.5">
                    @if(Auth::check() && Auth::user()->isAdmin())
                        <a href="{{ url('/?view=admin&admin_tab=orders&order_status=all#admin-section') }}" 
                           class="w-full py-3.5 px-6 bg-[#0066ff] hover:bg-blue-700 text-white font-bold text-sm rounded-full shadow-md transition flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-receipt text-xs"></i>
                            <span>Về Quản Lý Đơn Hàng (Admin)</span>
                        </a>
                    @endif
                    <a href="{{ Auth::check() && Auth::user()->isAdmin() ? url('/?view=admin&admin_tab=orders#admin-section') : route('home') }}" 
                       class="w-full py-3.5 px-6 bg-[#1e293b] hover:bg-black text-white font-bold text-sm rounded-full shadow-md transition flex items-center justify-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-cart-shopping text-xs"></i>
                        <span>Tiếp Tục Mua Sắm</span>
                    </a>
                    <div>
                        <button type="button" onclick="document.getElementById('momo_success_modal').remove()" 
                                class="text-xs text-pink-600 hover:text-pink-700 font-semibold transition py-1 cursor-pointer">
                            Quay về xem đơn hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($order)
        <!-- Single Order Found -->
        <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-8">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-800">
                <div>
                    <span class="text-xs text-slate-400 block">Mã đơn hàng:</span>
                    <h2 class="text-2xl font-bold font-mono text-amber-400">{{ $order->order_code }}</h2>
                    <span class="text-[11px] text-slate-400">Ngày đặt: {{ $order->created_at->format('H:i d/m/Y') }}</span>
                </div>

                @php $badge = $order->status_badge; @endphp
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $badge['color'] }}">
                        <i class="fa-solid fa-circle-notch text-[10px] animate-spin"></i>
                        {{ $badge['label'] }}
                    </span>
                </div>
            </div>

            <!-- Progress Timeline -->
            @php
                $statusSteps = [
                    'pending' => 1,
                    'processing' => 2,
                    'shipping' => 3,
                    'completed' => 4,
                ];
                $currentStep = $statusSteps[$order->order_status] ?? 1;
            @endphp

            <div class="space-y-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Tiến trình vận chuyển:</h3>
                
                <div class="grid grid-cols-4 gap-2 text-center text-[11px]">
                    <div class="space-y-2">
                        <div class="w-10 h-10 rounded-full mx-auto flex items-center justify-center font-bold text-sm {{ $currentStep >= 1 ? 'bg-amber-500 text-slate-950' : 'bg-slate-800 text-slate-400' }}">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <span class="{{ $currentStep >= 1 ? 'text-amber-400 font-bold' : 'text-slate-400' }}">Đặt hàng</span>
                    </div>

                    <div class="space-y-2">
                        <div class="w-10 h-10 rounded-full mx-auto flex items-center justify-center font-bold text-sm {{ $currentStep >= 2 ? 'bg-amber-500 text-slate-950' : 'bg-slate-800 text-slate-400' }}">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <span class="{{ $currentStep >= 2 ? 'text-amber-400 font-bold' : 'text-slate-400' }}">Chuẩn bị hàng</span>
                    </div>

                    <div class="space-y-2">
                        <div class="w-10 h-10 rounded-full mx-auto flex items-center justify-center font-bold text-sm {{ $currentStep >= 3 ? 'bg-amber-500 text-slate-950' : 'bg-slate-800 text-slate-400' }}">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <span class="{{ $currentStep >= 3 ? 'text-amber-400 font-bold' : 'text-slate-400' }}">Đang giao hàng</span>
                    </div>

                    <div class="space-y-2">
                        <div class="w-10 h-10 rounded-full mx-auto flex items-center justify-center font-bold text-sm {{ $currentStep >= 4 ? 'bg-emerald-500 text-slate-950' : 'bg-slate-800 text-slate-400' }}">
                            <i class="fa-solid fa-house-chimney-check"></i>
                        </div>
                        <span class="{{ $currentStep >= 4 ? 'text-emerald-400 font-bold' : 'text-slate-400' }}">Giao thành công</span>
                    </div>
                </div>
            </div>

            <!-- Customer & Delivery info -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-950 p-5 rounded-2xl border border-slate-800 text-xs">
                <div class="space-y-1">
                    <span class="text-slate-400 text-[10px] uppercase block">Người nhận hàng:</span>
                    <div class="font-bold text-slate-200">{{ $order->customer_name }}</div>
                    <div class="text-slate-300">{{ $order->customer_phone }}</div>
                    <div class="text-slate-400 text-[11px]">{{ $order->shipping_address }}, {{ $order->city }}</div>
                </div>

                <div class="space-y-1">
                    <span class="text-slate-400 text-[10px] uppercase block">Hình thức thanh toán:</span>
                    <div class="font-bold text-slate-200">
                        @if($order->payment_method === 'momo')
                            <span class="inline-flex items-center gap-1.5 text-pink-400 font-bold">
                                <i class="fa-solid fa-wallet"></i> Ví MoMo (ATM/QR)
                            </span>
                        @elseif($order->payment_method === 'banking')
                            Chuyển khoản VietQR Napas
                        @else
                            Tiền mặt khi nhận hàng (COD)
                        @endif
                    </div>
                    <div class="text-[11px] text-slate-400">
                        Trạng thái thanh toán: 
                        <strong class="{{ $order->payment_status === 'paid' ? 'text-emerald-400' : 'text-amber-400' }}">
                            {{ $order->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                        </strong>
                    </div>

                    @if($order->payment_method === 'momo' && $order->payment_status !== 'paid')
                        <div class="pt-2">
                            <a href="{{ route('orders.momo.pay', $order->id) }}" class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-500 hover:to-rose-500 text-white font-bold text-xs shadow-md transition">
                                <i class="fa-solid fa-rotate-right"></i>
                                <span>Thanh toán lại qua MoMo</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ordered items list -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Sản phẩm trong đơn hàng:</h4>
                <div class="divide-y divide-slate-800 border border-slate-800 rounded-2xl overflow-hidden">
                    @foreach($order->items as $item)
                        <div class="p-4 bg-slate-950/60 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-3">
                                <img src="{{ $item->product_image }}" class="w-12 h-12 rounded-lg object-contain bg-slate-900 p-1 border border-slate-800">
                                <div>
                                    <div class="font-bold text-slate-200">{{ $item->product_name }}</div>
                                    <div class="text-[10px] text-slate-400">SKU: {{ $item->product_sku ?? 'N/A' }} | Số lượng: {{ $item->quantity }} chiếc</div>
                                </div>
                            </div>
                            <div class="font-bold text-amber-400 text-sm">
                                {{ $item->formatted_total }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Total -->
            <div class="flex justify-between items-baseline pt-4 border-t border-slate-800">
                <span class="text-sm font-bold text-slate-300">Tổng thanh toán:</span>
                <span class="text-2xl font-bold text-amber-400">{{ $order->formatted_total }}</span>
            </div>

            @if($order->paymentTransactions && $order->paymentTransactions->isNotEmpty())
                <!-- Nhật ký giao dịch tài chính (Payment Transactions) theo Lab Orders -->
                <div class="space-y-3 pt-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-amber-500"></i>
                        <span>Nhật Ký Ghi Vết Tài Chính (Payment Transactions):</span>
                    </h4>
                    <div class="divide-y divide-slate-800 border border-slate-800 rounded-2xl overflow-hidden bg-slate-950/80 text-xs">
                        @foreach($order->paymentTransactions as $tx)
                            <div class="p-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div class="space-y-0.5">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $tx->gateway === 'momo' ? 'bg-pink-900/60 text-pink-300 border border-pink-700' : 'bg-slate-800 text-slate-300' }}">
                                            {{ $tx->gateway }}
                                        </span>
                                        <span class="font-mono text-slate-300 text-[11px]">{{ $tx->gateway_order_id ?? 'Mã GD: #' . $tx->id }}</span>
                                    </div>
                                    <div class="text-[11px] text-slate-400">
                                        {{ $tx->message ?? ($tx->status === 'paid' ? 'Giao dịch thành công' : 'Đang xử lý thanh toán') }}
                                        @if($tx->transaction_id)
                                            • TransId: <span class="font-mono text-slate-300">{{ $tx->transaction_id }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center">
                                    <span class="font-bold text-amber-400">{{ number_format($tx->amount, 0, ',', '.') }} ₫</span>
                                    <span class="text-[10px] font-semibold {{ $tx->status === 'paid' ? 'text-emerald-400' : ($tx->status === 'failed' ? 'text-rose-400' : 'text-amber-400') }}">
                                        {{ $tx->status === 'paid' ? 'Thành công' : ($tx->status === 'failed' ? 'Thất bại' : 'Chờ xử lý') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    @elseif($ordersList && $ordersList->isNotEmpty())
        <!-- Multiple Orders Found By Phone -->
        <div class="space-y-6">
            <h3 class="text-sm font-bold text-white font-cinzel">Tìm thấy {{ $ordersList->count() }} đơn hàng với số điện thoại: {{ $keyword }}</h3>

            <div class="space-y-4">
                @foreach($ordersList as $ord)
                    <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-6 shadow-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <div class="font-mono font-bold text-amber-400 text-base">{{ $ord->order_code }}</div>
                            <div class="text-xs text-slate-300 mt-1">Ngày: {{ $ord->created_at->format('d/m/Y H:i') }} - {{ count($ord->items) }} món</div>
                            <div class="text-xs text-emerald-400 font-bold mt-1">Tổng tiền: {{ $ord->formatted_total }}</div>
                        </div>
                        <div class="flex items-center gap-3">
                            @php $b = $ord->status_badge; @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $b['color'] }}">
                                {{ $b['label'] }}
                            </span>
                            <a href="{{ route('orders.tracking', ['q' => $ord->order_code]) }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-slate-200 text-xs font-semibold transition">
                                Chi tiết
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    @elseif(!empty($keyword))
        <!-- Not Found -->
        <div class="bg-slate-900/60 border border-slate-800 rounded-3xl p-12 text-center space-y-4 max-w-xl mx-auto">
            <div class="w-16 h-16 rounded-full bg-slate-800 text-amber-400 flex items-center justify-center mx-auto text-2xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 class="text-lg font-bold text-white">Không tìm thấy đơn hàng phù hợp</h3>
            <p class="text-xs text-slate-400 leading-relaxed">
                Không tìm thấy đơn hàng nào với từ khóa "<strong class="text-slate-200">{{ $keyword }}</strong>". Quý khách vui lòng kiểm tra lại mã đơn hàng hoặc liên hệ tổng đài <strong>1900 8888</strong> để được hỗ trợ kiểm tra trực tiếp.
            </p>
        </div>
    @else
        <!-- Initial Guidance -->
        <div class="bg-slate-900/40 border border-slate-800 rounded-3xl p-10 text-center space-y-3 max-w-md mx-auto">
            <i class="fa-solid fa-box-archive text-3xl text-amber-400/80"></i>
            <h3 class="text-base font-bold text-slate-200">Tra cứu nhanh chóng 24/7</h3>
            <p class="text-xs text-slate-400">Mã đơn hàng được gửi kèm qua tin nhắn SMS và Email ngay sau khi quý khách hoàn tất đặt hàng.</p>
        </div>
    @endif

</div>

@endsection
