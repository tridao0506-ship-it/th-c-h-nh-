@extends('layouts.app')

@section('title', 'Giỏ Hàng Của Bạn | ChronoLux')

@section('content')

<div class="bg-slate-900 border-b border-slate-800 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs text-slate-400 mb-2 space-x-2">
            <a href="{{ route('home') }}" class="hover:text-amber-400 transition">Trang chủ</a>
            <span>/</span>
            <span class="text-amber-400 font-medium">Giỏ hàng</span>
        </nav>
        <h1 class="text-3xl font-bold font-cinzel text-white">Giỏ Hàng Đồng Hồ Của Bạn</h1>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    @if(empty($cart))
        <div class="bg-slate-900/40 border border-slate-800 rounded-3xl p-16 text-center space-y-5 max-w-2xl mx-auto">
            <div class="w-20 h-20 rounded-full bg-slate-800/80 text-amber-400 flex items-center justify-center mx-auto text-3xl shadow-inner">
                <i class="fa-solid fa-basket-shopping"></i>
            </div>
            <h2 class="text-2xl font-bold text-white font-serif">Giỏ hàng của bạn đang trống</h2>
            <p class="text-xs text-slate-400 leading-relaxed max-w-md mx-auto">
                Hãy lựa chọn cho mình hoặc người thân một kiệt tác đồng hồ tinh xảo với chính sách bảo hành 5 năm vàng tại ChronoLux.
            </p>
            <div class="pt-2">
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-amber-500/20">
                    <i class="fa-solid fa-clock"></i>
                    <span>Khám phá bộ sưu tập ngay</span>
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Items Table -->
            <div class="lg:col-span-8 bg-slate-900/90 border border-slate-800 rounded-3xl p-6 shadow-xl">
                <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-6">
                    <h2 class="text-base font-bold text-white font-cinzel">Danh sách sản phẩm ({{ count($cart) }})</h2>
                    <a href="{{ route('cart.clear') }}" onclick="return confirm('Bạn có chắc muốn xóa tất cả sản phẩm khỏi giỏ hàng?')" class="text-xs text-red-400 hover:text-red-300 transition flex items-center gap-1">
                        <i class="fa-solid fa-trash-can"></i> Xóa tất cả
                    </a>
                </div>

                <div class="divide-y divide-slate-800/80">
                    @foreach($cart as $item)
                        <div class="py-6 flex flex-col sm:flex-row items-center gap-6">
                            <!-- Image -->
                            <div class="w-24 h-24 rounded-2xl bg-slate-950 p-2 flex-shrink-0 border border-slate-800">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-contain rounded-xl">
                            </div>

                            <!-- Details -->
                            <div class="flex-1 text-center sm:text-left space-y-1">
                                <span class="font-cinzel text-amber-400 text-[10px] font-bold uppercase tracking-wider">{{ $item['brand'] ?? 'ChronoLux' }}</span>
                                <h3 class="font-semibold text-sm text-slate-100 hover:text-amber-400 transition">
                                    <a href="{{ !empty($item['slug']) ? route('products.show', $item['slug']) : (!empty($item['id']) ? route('products.show', $item['id']) : '#') }}">{{ $item['name'] }}</a>
                                </h3>
                                <div class="text-[11px] text-slate-400">Mã SKU: {{ $item['sku'] ?? 'N/A' }}</div>
                                <div class="text-xs font-bold text-amber-400 sm:hidden mt-2">
                                    {{ number_format($item['price'], 0, ',', '.') }} ₫
                                </div>
                            </div>

                            <!-- Quantity controller -->
                            <div class="flex items-center gap-2">
                                <form action="{{ route('cart.update') }}" method="POST" class="flex items-center bg-slate-950 border border-slate-700 rounded-xl overflow-hidden">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                    <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" class="px-3 py-1.5 text-slate-400 hover:text-white hover:bg-slate-800 transition">
                                        <i class="fa-solid fa-minus text-[10px]"></i>
                                    </button>
                                    <span class="w-10 text-center text-xs font-bold text-white">{{ $item['quantity'] }}</span>
                                    <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="px-3 py-1.5 text-slate-400 hover:text-white hover:bg-slate-800 transition">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Item Total -->
                            <div class="hidden sm:block text-right w-36">
                                <div class="text-sm font-bold text-amber-400">
                                    {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} ₫
                                </div>
                                <div class="text-[10px] text-slate-400 mt-0.5">
                                    {{ number_format($item['price'], 0, ',', '.') }} ₫ / chiếc
                                </div>
                            </div>

                            <!-- Remove item button -->
                            <div>
                                <a href="{{ route('cart.remove', $item['id']) }}" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-red-950/80 text-slate-400 hover:text-red-400 flex items-center justify-center transition" title="Xóa sản phẩm">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pt-6 border-t border-slate-800 flex items-center justify-between text-xs">
                    <a href="{{ route('products.index') }}" class="text-amber-400 hover:underline flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-left"></i> Tiếp tục chọn thêm đồng hồ
                    </a>
                </div>
            </div>

            <!-- Order Summary & Voucher -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Voucher Box -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 shadow-xl">
                    <h3 class="text-sm font-bold text-white font-cinzel mb-3">Mã Giảm Giá & Khuyến Mãi</h3>
                    
                    @if($voucher)
                        <div class="bg-amber-950/40 border border-amber-500/40 rounded-xl p-3 flex items-center justify-between">
                            <div class="text-xs">
                                <span class="font-bold text-amber-400 font-mono">{{ $voucher['code'] }}</span>
                                <div class="text-[11px] text-slate-300 mt-0.5">{{ $voucher['desc'] }}</div>
                            </div>
                            <a href="{{ route('cart.voucher.remove') }}" class="text-slate-400 hover:text-red-400 text-xs ml-2">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>
                    @else
                        <form action="{{ route('cart.voucher') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="voucher_code" placeholder="Nhập mã (CHRONO10, LUXURY500)" required
                                class="flex-1 bg-slate-950 border border-slate-700 rounded-xl px-3.5 py-2.5 text-xs text-white uppercase focus:outline-none focus:border-amber-500">
                            <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-amber-400 font-semibold text-xs transition">
                                Áp dụng
                            </button>
                        </form>
                        <div class="text-[11px] text-slate-400 mt-2 flex items-center gap-1">
                            <i class="fa-solid fa-circle-info text-amber-400"></i>
                            <span>Gợi ý: Dùng mã <strong>CHRONO10</strong> giảm ngay 10%</span>
                        </div>
                    @endif
                </div>

                <!-- Price Breakdown Card -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 shadow-xl space-y-4">
                    <h3 class="text-sm font-bold text-white font-cinzel pb-3 border-b border-slate-800">Tóm Tắt Đơn Hàng</h3>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between text-slate-300">
                            <span>Tạm tính ({{ count($cart) }} món):</span>
                            <span class="font-semibold text-white">{{ number_format($subtotal, 0, ',', '.') }} ₫</span>
                        </div>

                        @if($discount > 0)
                            <div class="flex justify-between text-emerald-400">
                                <span>Giảm giá Voucher:</span>
                                <span class="font-semibold">-{{ number_format($discount, 0, ',', '.') }} ₫</span>
                            </div>
                        @endif

                        <div class="flex justify-between text-slate-300">
                            <span>Phí vận chuyển bảo hiểm:</span>
                            <span class="text-emerald-400 font-semibold">Miễn phí toàn quốc</span>
                        </div>

                        <div class="pt-3 border-t border-slate-800 flex justify-between items-baseline">
                            <span class="text-sm font-bold text-white">Tổng thanh toán:</span>
                            <span class="text-2xl font-bold text-amber-400">{{ number_format($total, 0, ',', '.') }} ₫</span>
                        </div>
                    </div>

                    <div class="pt-2">
                        <a href="{{ route('checkout.index') }}" class="block w-full py-4 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider text-center transition shadow-lg shadow-amber-500/20">
                            Tiến Hành Thanh Toán <i class="fa-solid fa-arrow-right ml-1"></i>
                        </a>
                    </div>

                    <div class="pt-3 border-t border-slate-800/80 space-y-2 text-[11px] text-slate-400">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-shield text-amber-400"></i>
                            <span>Cam kết bảo mật thông tin khách hàng tuyệt đối</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-box-open text-amber-400"></i>
                            <span>Được mở hộp kiểm tra đồng hồ trước khi nhận</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    @endif
</div>

@endsection
