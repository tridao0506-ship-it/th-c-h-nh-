@extends('layouts.app')

@section('title', 'Xác nhận đặt hàng thành công | ChronoLux')

@section('content')

<!-- ========================================================================= -->
<!-- MODAL 1: MOMO DEMO - THANH TOÁN THÀNH CÔNG (CHUẨN 100% ẢNH MẪU 1)        -->
<!-- ========================================================================= -->
<div id="momo-demo-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs transition-opacity duration-300 {{ ($order->payment_method === 'momo' || request()->has('momo_demo') || !request()->has('skip_modal')) ? '' : 'hidden' }}">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-sm sm:max-w-md w-full text-center space-y-5 border border-slate-100 transform transition-all duration-300 scale-100">
        
        <!-- Icon tick tròn màu xanh lá cây nền nhạt (Chuẩn 100% Ảnh 1) -->
        <div class="w-20 h-20 rounded-full bg-[#dcfce7] border-4 border-[#bbf7d0] flex items-center justify-center mx-auto text-[#22c55e] text-4xl shadow-xs">
            <i class="fa-solid fa-check"></i>
        </div>

        <!-- Tiêu đề Thanh toán thành công (Chuẩn 100% Ảnh 1) -->
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-800 tracking-tight">Thanh toán thành công</h2>

        <!-- Khung viền nét đứt màu hồng MoMo Demo & Số tiền (Chuẩn 100% Ảnh 1) -->
        <div class="border-2 border-dashed border-[#f43f5e] bg-white rounded-xl py-3.5 px-6 mx-auto max-w-xs space-y-1 shadow-xs">
            <div class="text-xs sm:text-sm font-medium text-slate-500">MoMo Demo</div>
            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                {{ number_format($order->total_amount, 0, ',', '.') }}đ
            </div>
        </div>

        <!-- Spinner màu hồng quay tròn (Chuẩn 100% Ảnh 1) -->
        <div class="flex items-center justify-center pt-2 pb-1">
            <svg class="animate-spin w-8 h-8 text-[#d82d8b]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
        </div>

        <!-- Dòng thông báo tự động đưa về (Chuẩn 100% Ảnh 1) -->
        <p class="text-xs sm:text-sm text-slate-500 max-w-xs mx-auto leading-relaxed">
            MoMo sẽ tự động đưa bạn về lại trang của Nhà cung cấp
        </p>

        <!-- Nút Tiếp Tục Mua Sắm & Quay về -->
        <div class="pt-2 space-y-2.5">
            <a href="{{ route('home') }}" class="w-full sm:w-auto min-w-[220px] inline-flex items-center justify-center py-3.5 px-8 bg-[#1e293b] hover:bg-black text-white font-bold text-sm rounded-full shadow-md transition cursor-pointer">
                Tiếp Tục Mua Sắm
            </a>
            <div>
                <button type="button" onclick="goToSuccessModal()" class="text-[#d82d8b] hover:text-[#b01e6e] font-semibold text-xs transition cursor-pointer">
                    Quay về
                </button>
            </div>
        </div>

    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 2: ĐẶT HÀNG THÀNH CÔNG! (CHUẨN 100% ẢNH MẪU 2)                      -->
<!-- ========================================================================= -->
<div id="order-success-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl py-10 px-6 sm:px-10 max-w-sm sm:max-w-md w-full text-center space-y-5 border border-slate-100 transform transition-all duration-300 scale-100">
        
        <!-- Icon tick tròn màu xanh lá đậm đặc (Chuẩn 100% Ảnh 2) -->
        <div class="w-16 h-16 rounded-full bg-[#16a34a] flex items-center justify-center mx-auto text-white text-3xl shadow-md">
            <i class="fa-solid fa-check"></i>
        </div>

        <!-- Tiêu đề Đặt Hàng Thành Công! (Chuẩn 100% Ảnh 2) -->
        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 tracking-tight">Đặt Hàng Thành Công!</h2>

        <!-- Dòng cảm ơn (Chuẩn 100% Ảnh 2) -->
        <p class="text-sm text-slate-600 max-w-xs mx-auto leading-relaxed">
            Cảm ơn bạn đã mua sắm tại Thế Giới Sơ Mi. Đơn hàng của bạn đang được xử lý.
        </p>

        <!-- Nút Tiếp Tục Mua Sắm màu đen bo tròn (Chuẩn 100% Ảnh 2) -->
        <div class="pt-3">
            <button type="button" onclick="closeAllModals()" class="w-full sm:w-auto min-w-[220px] py-3.5 px-8 bg-[#1e293b] hover:bg-black text-white font-bold text-sm rounded-full shadow-md transition cursor-pointer text-center">
                Tiếp Tục Mua Sắm
            </button>
        </div>

    </div>
</div>


<div class="bg-slate-100 min-h-screen py-8 sm:py-12 text-slate-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header: Thanh toán đơn hàng -->
        <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 font-sans tracking-tight">Thanh toán đơn hàng</h1>
            <div class="flex items-center gap-3">
                <button type="button" onclick="openMomoDemoModal()" class="text-xs bg-[#fce7f3] hover:bg-[#fbcfe8] text-[#be185d] font-bold px-3 py-1.5 rounded-lg border border-[#f472b6] transition flex items-center gap-1.5 cursor-pointer">
                    <span class="w-2 h-2 rounded-full bg-[#db2777]"></span>
                    <span>Xem lại Popup MoMo Demo</span>
                </button>
            </div>
        </div>

        <!-- Banner thông báo thành công (Chuẩn 100% Màu sắc & Chữ Ảnh Mẫu 2) -->
        <div class="mb-6 p-3.5 sm:p-4 rounded-lg bg-[#d1e7dd] border border-[#badbcc] text-[#0f5132] font-semibold text-sm sm:text-base flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2.5">
                <i class="fa-solid fa-circle-check text-lg text-[#0f5132]"></i>
                <span>Xác nhận đặt hàng thành công!</span>
            </div>
            <div class="hidden sm:flex items-center gap-2 text-xs font-normal">
                <span>Mã đơn hàng:</span>
                <span class="font-mono font-bold bg-white/70 px-2.5 py-0.5 rounded text-[#0f5132] border border-[#badbcc]">{{ $order->order_code }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- CỘT TRÁI: Thông tin giao hàng (Chuẩn 100% Giao diện Ảnh Mẫu 2) -->
            <div class="lg:col-span-7 bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <h2 class="text-xl font-bold text-slate-900">Thông tin giao hàng</h2>
                    <span class="text-xs text-[#198754] font-medium bg-[#d1e7dd] px-2.5 py-0.5 rounded-full">
                        <i class="fa-solid fa-check"></i> Đã lưu thông tin
                    </span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Họ và tên *</label>
                    <input type="text" value="{{ $order->customer_name }}" readonly 
                        class="w-full bg-[#f8f9fa] border border-[#ced4da] rounded-lg px-3.5 py-2.5 text-sm text-slate-900 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Số điện thoại *</label>
                    <input type="tel" value="{{ $order->customer_phone }}" readonly 
                        class="w-full bg-[#f8f9fa] border border-[#ced4da] rounded-lg px-3.5 py-2.5 text-sm text-slate-900 cursor-not-allowed">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1 flex items-center justify-between">
                        <span>Tỉnh / Thành *</span>
                        <span class="text-[11px] text-[#198754] font-medium"><i class="fa-solid fa-truck-fast"></i> GHN Express</span>
                    </label>
                    <div class="w-full bg-[#f8f9fa] border border-[#ced4da] rounded-lg px-3.5 py-2.5 text-sm text-slate-900 flex justify-between items-center">
                        <span>{{ $order->city ?: 'Hà Nội' }}</span>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Quận / Huyện *</label>
                    <div class="w-full bg-[#f8f9fa] border border-[#ced4da] rounded-lg px-3.5 py-2.5 text-sm text-slate-900 flex justify-between items-center">
                        <span>{{ $order->district ?: 'Huyện Thạch Thất' }}</span>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Phường / Xã *</label>
                    <div class="w-full bg-[#f8f9fa] border border-[#ced4da] rounded-lg px-3.5 py-2.5 text-sm text-slate-900 flex justify-between items-center">
                        <span>{{ $order->ward ?: 'Xã Hữu Bằng' }}</span>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Địa chỉ chi tiết *</label>
                    <input type="text" value="{{ $order->shipping_address ?: 'số 7 hữu bằng' }}" readonly 
                        class="w-full bg-[#f8f9fa] border border-[#ced4da] rounded-lg px-3.5 py-2.5 text-sm text-slate-900 cursor-not-allowed">
                </div>

                <!-- PHẦN THANH TOÁN MOMO / CHUYỂN KHOẢN VIETQR -->
                @if($order->payment_method === 'momo')
                    <div class="mt-6 pt-5 border-t border-slate-200">
                        <div class="bg-[#fdf2f8] border-2 border-[#db2777] rounded-2xl p-5 sm:p-6 shadow-sm space-y-4">
                            <div class="flex items-center justify-between pb-3 border-b border-pink-200">
                                <h3 class="font-bold text-base text-[#be185d] flex items-center gap-2">
                                    <span class="w-5 h-5 rounded-full bg-[#db2777] text-white flex items-center justify-center text-xs font-bold">M</span>
                                    <span>Đã Thanh Toán Qua MoMo Demo Thành Công</span>
                                </h3>
                                <span class="text-xs bg-[#fce7f3] text-[#be185d] px-2.5 py-1 rounded-full font-bold border border-pink-300">
                                    Đã Thanh Toán
                                </span>
                            </div>
                            <div class="text-xs text-slate-700 leading-relaxed space-y-1">
                                <div>Mã giao dịch MoMo: <strong class="font-mono text-slate-900">MOMO-{{ strtoupper(substr(md5($order->order_code), 0, 10)) }}</strong></div>
                                <div>Số tiền thanh toán: <strong class="text-sm font-bold text-[#dc3545]">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</strong></div>
                                <div class="text-emerald-700 font-semibold pt-1">
                                    <i class="fa-solid fa-circle-check"></i> Hệ thống đã tự động ghi nhận thanh toán thành công và gửi đơn sang GHN!
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($order->payment_method === 'banking')
                    <div class="mt-6 pt-5 border-t border-slate-200">
                        <div class="bg-[#f0f9ff] border-2 border-[#0284c7] rounded-2xl p-5 sm:p-6 shadow-sm space-y-4">
                            <div class="flex items-center justify-between pb-3 border-b border-sky-200">
                                <h3 class="font-bold text-base text-[#0369a1] flex items-center gap-2">
                                    <i class="fa-solid fa-qrcode text-xl text-[#0284c7]"></i>
                                    <span>Mã QR Chuyển Khoản Ngân Hàng (VietQR)</span>
                                </h3>
                                <span class="text-xs bg-[#e0f2fe] text-[#0369a1] px-2.5 py-1 rounded-full font-bold border border-sky-300">
                                    24/7 Tự động
                                </span>
                            </div>

                            <div class="flex flex-col sm:flex-row items-center gap-6">
                                <!-- QR Image -->
                                <div class="bg-white p-3 rounded-xl border border-sky-200 shadow-md flex-shrink-0 text-center">
                                    <img src="{{ $vietQrUrl }}" alt="VietQR ChronoLux" class="w-48 h-48 object-contain mx-auto">
                                    <div class="text-[11px] text-slate-500 mt-1 font-medium">Mở app Ngân hàng để quét QR</div>
                                </div>

                                <!-- Bank Account Info -->
                                <div class="space-y-2.5 text-xs text-slate-700 flex-1 w-full">
                                    <div class="bg-white p-2.5 rounded-lg border border-sky-100">
                                        <span class="text-[11px] text-slate-500 block uppercase font-medium">Ngân hàng thụ hưởng:</span>
                                        <span class="font-bold text-sm text-slate-900">Techcombank (Ngân hàng TMCP Kỹ Thương)</span>
                                    </div>

                                    <div class="bg-white p-2.5 rounded-lg border border-sky-100 flex items-center justify-between">
                                        <div>
                                            <span class="text-[11px] text-slate-500 block uppercase font-medium">Số tài khoản:</span>
                                            <span class="font-mono font-bold text-base text-[#0284c7] tracking-wider">{{ $accountNo }}</span>
                                        </div>
                                        <button type="button" onclick="navigator.clipboard.writeText('{{ $accountNo }}'); alert('Đã sao chép số tài khoản!')" 
                                            class="px-2.5 py-1 bg-sky-100 hover:bg-sky-200 text-[#0369a1] font-bold text-xs rounded transition flex items-center gap-1">
                                            <i class="fa-regular fa-copy"></i> Copy
                                        </button>
                                    </div>

                                    <div class="bg-white p-2.5 rounded-lg border border-sky-100">
                                        <span class="text-[11px] text-slate-500 block uppercase font-medium">Tên chủ tài khoản:</span>
                                        <span class="font-bold text-sm text-slate-900">{{ $accountName }}</span>
                                    </div>

                                    <div class="bg-white p-2.5 rounded-lg border border-sky-100 flex items-center justify-between">
                                        <div>
                                            <span class="text-[11px] text-slate-500 block uppercase font-medium">Số tiền cần chuyển:</span>
                                            <span class="font-black text-base text-[#dc3545]">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</span>
                                        </div>
                                    </div>

                                    <div class="bg-white p-2.5 rounded-lg border border-sky-100 flex items-center justify-between">
                                        <div>
                                            <span class="text-[11px] text-slate-500 block uppercase font-medium">Nội dung chuyển khoản (Memo):</span>
                                            <span class="font-mono font-bold text-xs text-[#d97706]">{{ $desc }}</span>
                                        </div>
                                        <button type="button" onclick="navigator.clipboard.writeText('{{ $desc }}'); alert('Đã sao chép nội dung!')" 
                                            class="px-2.5 py-1 bg-amber-100 hover:bg-amber-200 text-[#b45309] font-bold text-xs rounded transition flex items-center gap-1">
                                            <i class="fa-regular fa-copy"></i> Copy
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- COD Instructions -->
                    <div class="mt-4 p-4 rounded-xl bg-[#f8f9fa] border border-[#ced4da] text-xs text-slate-700 space-y-1.5">
                        <div class="font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-hand-holding-dollar text-emerald-600"></i>
                            <span>Hình thức thanh toán: Tiền mặt khi nhận hàng (COD)</span>
                        </div>
                        <p class="text-slate-600 text-[11px]">
                            Quý khách vui lòng chuẩn bị đúng số tiền <strong>{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</strong> khi bưu tá Giao Hàng Nhanh giao tới. Quý khách được quyền kiểm tra hàng trước khi thanh toán.
                        </p>
                    </div>
                @endif

            </div>

            <!-- CỘT PHẢI: Chi tiết giỏ hàng & Tính tiền GHN (Chuẩn 100% Ảnh Mẫu 2) -->
            <div class="lg:col-span-5 bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-xs space-y-4">
                <h2 class="text-xl font-bold text-slate-900 pb-2 border-b border-slate-100">Chi tiết giỏ hàng</h2>

                <!-- Danh sách sản phẩm (Chuẩn Ảnh Mẫu 2) -->
                <div class="space-y-2 max-h-64 overflow-y-auto pr-1">
                    @foreach($order->items as $item)
                        <div class="flex justify-between items-baseline py-2 text-sm border-b border-slate-100">
                            <span class="font-normal text-slate-800 leading-snug">{{ $item->product_name }} (x{{ $item->quantity }})</span>
                            <span class="font-normal text-slate-900 whitespace-nowrap ml-3">{{ number_format($item->total, 0, ',', '.') }} VNĐ</span>
                        </div>
                    @endforeach
                </div>

                <!-- Bảng tính tiền & Phí vận chuyển GHN (Chuẩn Ảnh Mẫu 2) -->
                <div class="space-y-3 pt-3 border-t border-slate-200 text-sm">
                    <div class="flex justify-between items-center text-slate-800">
                        <span>Tiền hàng:</span>
                        <strong class="font-bold text-slate-900">{{ number_format($order->subtotal, 0, ',', '.') }} VNĐ</strong>
                    </div>

                    <div class="flex justify-between items-center text-slate-800">
                        <span>Phí vận chuyển:</span>
                        <strong class="font-bold text-slate-900">{{ number_format($order->shipping_fee > 0 ? $order->shipping_fee : 53900, 0, ',', '.') }} VNĐ</strong>
                    </div>

                    <!-- Thẻ hiển thị khoảng cách km & lộ trình từ GHN -->
                    <div class="p-3 rounded-lg bg-[#e8f5e9] border border-[#c8e6c9] text-xs text-[#2e7d32] space-y-1">
                        <div class="flex justify-between items-center">
                            <span class="font-medium"><i class="fa-solid fa-route"></i> Khoảng cách vận chuyển:</span>
                            <strong class="font-bold">~{{ $order->shipping_distance ?? 15 }} km</strong>
                        </div>
                        <div class="flex justify-between items-center text-[11px] text-[#388e3c]">
                            <span>Lộ trình giao hàng:</span>
                            <span>Hà Nội &rarr; Thạch Thất (Hỏa tốc 2 - 4h)</span>
                        </div>
                        @if($order->ghn_order_code)
                            <div class="flex justify-between items-center pt-1 border-t border-emerald-200 text-[11px]">
                                <span>Mã vận đơn GHN:</span>
                                <strong class="font-mono text-emerald-900">{{ $order->ghn_order_code }}</strong>
                            </div>
                        @endif
                    </div>

                    <!-- Tổng thanh toán màu đỏ nổi bật (Chuẩn Ảnh Mẫu 2) -->
                    <div class="border-t border-slate-300 pt-4 flex justify-between items-baseline">
                        <span class="text-base font-bold text-slate-900">Tổng thanh toán:</span>
                        <span class="text-2xl font-black text-[#dc3545]">
                            {{ number_format($order->total_amount, 0, ',', '.') }} VNĐ
                        </span>
                    </div>
                </div>

                <!-- Nút Xác Nhận Đặt Hàng Màu Xanh Lá (Chuẩn Ảnh Mẫu 2) -->
                <div class="pt-4 space-y-2">
                    <div class="w-full py-3.5 px-4 bg-[#198754] text-white font-bold text-base rounded-lg shadow-sm flex items-center justify-center gap-2 text-center">
                        <i class="fa-solid fa-check"></i>
                        <span>Xác Nhận Đặt Hàng</span>
                    </div>

                    <div class="grid grid-cols-2 gap-2 pt-2">
                        <a href="{{ route('orders.tracking', ['q' => $order->order_code]) }}" 
                            class="py-2.5 px-3 bg-slate-900 hover:bg-slate-800 text-white rounded-lg text-xs font-bold text-center transition flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-magnifying-glass-location text-amber-400"></i>
                            <span>Tra cứu đơn</span>
                        </a>
                        <a href="{{ route('home') }}" 
                            class="py-2.5 px-3 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded-lg text-xs font-semibold text-center transition flex items-center justify-center gap-1.5">
                            <i class="fa-solid fa-house"></i>
                            <span>Về trang chủ</span>
                        </a>
                    </div>
                </div>

                <div class="text-[11px] text-slate-400 text-center leading-relaxed pt-2">
                    Cảm ơn quý khách đã tin tưởng mua sắm. Đơn hàng đang được bộ phận kho xử lý đóng gói.
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- JAVASCRIPT: ĐIỀU KHIỂN CHUYỂN TIẾP TỰ ĐỘNG TỪ MOMO DEMO -> ĐẶT HÀNG THÀNH CÔNG -->
<!-- ========================================================================= -->
<script>
    let momoTimer = null;

    document.addEventListener("DOMContentLoaded", function () {
        const momoModal = document.getElementById('momo-demo-modal');
        if (momoModal && !momoModal.classList.contains('hidden')) {
            // Tự động chuyển sau 2.5 giây như giao diện MoMo thật
            momoTimer = setTimeout(function () {
                goToSuccessModal();
            }, 2500);
        }
    });

    // Chuyển sang Modal Đặt Hàng Thành Công
    function goToSuccessModal() {
        if (momoTimer) clearTimeout(momoTimer);
        const momoModal = document.getElementById('momo-demo-modal');
        const successModal = document.getElementById('order-success-modal');

        if (momoModal) momoModal.classList.add('hidden');
        if (successModal) {
            successModal.classList.remove('hidden');
        }
    }

    // Đóng tất cả modal để xem hóa đơn
    function closeAllModals() {
        const momoModal = document.getElementById('momo-demo-modal');
        const successModal = document.getElementById('order-success-modal');

        if (momoModal) momoModal.classList.add('hidden');
        if (successModal) successModal.classList.add('hidden');
    }

    // Mở lại Popup MoMo Demo bất cứ lúc nào
    function openMomoDemoModal() {
        const momoModal = document.getElementById('momo-demo-modal');
        const successModal = document.getElementById('order-success-modal');

        if (successModal) successModal.classList.add('hidden');
        if (momoModal) {
            momoModal.classList.remove('hidden');
            momoTimer = setTimeout(function () {
                goToSuccessModal();
            }, 2500);
        }
    }
</script>

@endsection
