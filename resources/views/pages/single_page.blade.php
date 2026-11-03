@extends('layouts.app')

@section('title', 'ChronoLux - Hệ Thống Đồng Hồ Cao Cấp & Quản Trị Toàn Diện')

@section('content')

<!-- Sticky Navigation Pills for 4 Core Sections & Mode Switcher -->
<div class="sticky top-20 z-40 bg-slate-900/95 backdrop-blur-md border-b border-amber-500/20 py-3 shadow-xl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between gap-4 overflow-x-auto pb-1 sm:pb-0">
            <div class="flex items-center space-x-2 sm:space-x-2.5 text-xs font-semibold whitespace-nowrap">
                @if(Auth::check() && Auth::user()->isAdmin())
                    <a href="#admin-section" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold transition flex items-center gap-2 border border-amber-500/40 shadow-lg shadow-amber-500/20">
                        <i class="fa-solid fa-clock text-slate-950"></i>
                        <span>1. SHOP ADMIN (Quản Trị Hệ Thống)</span>
                    </a>
                    <a href="#admin-section" onclick="switchAdminTab('products');" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white transition flex items-center gap-2 border border-slate-700">
                        <i class="fa-solid fa-boxes-stacked text-amber-400"></i>
                        <span>2. Quản Lý & Thêm Sản Phẩm</span>
                    </a>
                    <a href="#admin-section" onclick="switchAdminTab('orders');" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white transition flex items-center gap-2 border border-slate-700">
                        <i class="fa-solid fa-receipt text-amber-400"></i>
                        <span>3. Xử Lý & Quản Lý Đơn Hàng</span>
                    </a>
                    <a href="#products-section" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white transition flex items-center gap-2 border border-slate-700">
                        <i class="fa-solid fa-eye text-amber-400"></i>
                        <span>4. Xem Kho Đồng Hồ Hiển Thị</span>
                    </a>
                @else
                    <a href="#home-section" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold transition flex items-center gap-2 border border-amber-500/40 shadow-lg shadow-amber-500/20">
                        <i class="fa-solid fa-house text-slate-950"></i>
                        <span>1. Trang Chủ Mua Hàng</span>
                    </a>
                    <a href="#products-section" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white transition flex items-center gap-2 border border-slate-700">
                        <i class="fa-solid fa-clock text-amber-400"></i>
                        <span>2. Bộ Sưu Tập Đồng Hồ</span>
                    </a>
                    <a href="#tracking-section" class="px-3.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white transition flex items-center gap-2 border border-slate-700">
                        <i class="fa-solid fa-magnifying-glass-location text-amber-400"></i>
                        <span>3. Tra Cứu Đơn Hàng</span>
                    </a>
                @endif
            </div>

            <!-- Right Action: [+ Thêm Sản Phẩm Mới] cho Admin / [Giỏ Hàng] cho Khách Hàng -->
            <div class="flex items-center gap-2.5">
                @if(Auth::check() && Auth::user()->isAdmin())
                    <button type="button" onclick="openAddProductModal()" class="px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-bold text-xs flex items-center gap-2 shadow-lg hover:scale-105 transition flex-shrink-0 whitespace-nowrap" title="Mở biểu mẫu thêm đồng hồ mới">
                        <i class="fa-solid fa-plus-circle text-slate-950 text-sm"></i>
                        <span>+ Thêm Sản Phẩm Mới</span>
                    </button>
                @else
                    <button onclick="toggleCartDrawer()" class="px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 text-slate-950 font-bold text-xs flex items-center gap-2 shadow-lg hover:scale-105 transition flex-shrink-0 whitespace-nowrap">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span>Giỏ Hàng ({{ array_sum(array_column($cart, 'quantity')) }})</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MỤC: KHU VỰC SHOP ADMIN (CHỈ HIỂN THỊ KHI ĐĂNG NHẬP TÀI KHOẢN ADMIN)     -->
<!-- ========================================================================= -->
@if(Auth::check() && Auth::user()->isAdmin())
<section id="admin-section" class="pt-6 pb-12 bg-slate-950 border-b border-amber-500/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-800">
            <div>
                <span class="font-cinzel text-amber-400 text-xs uppercase tracking-widest font-bold">Khu Vực Quản Trị Hệ Thống Tích Hợp</span>
                <h2 class="text-2xl sm:text-3xl font-serif font-bold text-white mt-1">Bảng Quản Trị SHOP ADMIN</h2>
                <p class="text-xs text-slate-400 mt-1">Quản lý giao dịch thanh toán, đơn hàng, khách hàng và tồn kho trực tiếp tại đây.</p>
            </div>
            
            <div class="flex items-center gap-2.5">
                <a href="#home-section" class="px-4 py-2 rounded-xl bg-slate-900 border border-slate-700 hover:border-amber-400 text-slate-200 hover:text-white text-xs font-semibold flex items-center gap-2 transition shadow">
                    <i class="fa-solid fa-arrow-down text-amber-400"></i>
                    <span>Cuộn xuống Trang Mua Hàng của Khách ↓</span>
                </a>
                <span class="px-3.5 py-2 rounded-xl bg-amber-500/20 border border-amber-500/40 text-amber-300 text-xs font-semibold">
                    <i class="fa-solid fa-crown text-amber-400 mr-1"></i> SHOP ADMIN v2.0
                </span>
            </div>
        </div>

        <!-- Embedded SHOP ADMIN Component matching Image 2 -->
        @include('pages.partials.shop_admin_embedded')

    </div>
</section>
@endif

<!-- ========================================================================= -->
<!-- MỤC 1: TRANG CHỦ & FLASH SALE & THƯƠNG HIỆU                               -->
<!-- ========================================================================= -->
<section id="home-section" class="pt-10 pb-16 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Hero Banner -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-950 via-slate-900 to-amber-950/40 border border-amber-500/30 p-8 sm:p-14 shadow-2xl">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8 space-y-5">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold uppercase tracking-wider">
                        <i class="fa-solid fa-crown text-amber-400"></i> Kiệt Tác Thời Gian 2026
                    </div>
                    <h1 class="text-3xl sm:text-5xl font-serif font-bold text-white leading-tight">
                        Đỉnh Cao Chế Tác <br>
                        <span class="gold-gradient-text font-cinzel">Khẳng Định Đẳng Cấp</span>
                    </h1>
                    <p class="text-slate-400 text-xs sm:text-sm max-w-xl leading-relaxed">
                        Phân phối chính hãng các huyền thoại Rolex, Omega, Patek Philippe, Hublot, Seiko, Tissot. Tuyển chọn tinh tế, bảo hành 5 năm vàng chính hãng.
                    </p>
                    <div class="flex flex-wrap gap-3 pt-2">
                        <a href="#products-section" class="px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-amber-500/20 flex items-center gap-2">
                            <span>Khám phá bộ sưu tập</span>
                            <i class="fa-solid fa-arrow-down"></i>
                        </a>
                        <a href="#tracking-section" class="px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs transition border border-slate-700 flex items-center gap-2">
                            <i class="fa-solid fa-magnifying-glass text-amber-400"></i>
                            <span>Tra cứu đơn hàng</span>
                        </a>
                        @if(Auth::check() && Auth::user()->isAdmin())
                            <a href="#admin-section" class="px-6 py-3 rounded-xl bg-slate-950 hover:bg-slate-800 text-amber-400 font-semibold text-xs transition border border-amber-500/40 flex items-center gap-2">
                                <i class="fa-solid fa-gear text-amber-400"></i>
                                <span>Bảng quản trị Admin</span>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-4 text-center">
                    <div class="relative group max-w-xs mx-auto">
                        @php
                            $heroWatch = $allProducts->firstWhere('id', 1) ?? $allProducts->first();
                        @endphp
                        @if($heroWatch)
                            <img src="{{ $heroWatch->image }}" 
                                alt="{{ $heroWatch->name }}" 
                                referrerpolicy="no-referrer"
                                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=600&auto=format&fit=crop&q=80';"
                                class="w-64 h-64 object-cover mx-auto rounded-2xl shadow-2xl group-hover:scale-105 transition duration-500 border border-amber-500/40">
                            <div class="mt-3 text-xs font-cinzel font-bold text-amber-400 uppercase tracking-widest">{{ $heroWatch->name }}</div>
                            <div class="text-[11px] text-slate-400">Giá: {{ $heroWatch->formatted_price }} ({{ $heroWatch->origin ?? 'Swiss Made' }})</div>
                        @else
                            <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=600&auto=format&fit=crop&q=80" 
                                alt="Rolex Submariner" referrerpolicy="no-referrer" class="w-64 h-64 object-cover mx-auto rounded-2xl shadow-2xl group-hover:scale-105 transition duration-500 border border-amber-500/40">
                            <div class="mt-3 text-xs font-cinzel font-bold text-amber-400 uppercase tracking-widest">Rolex Submariner Date 41mm</div>
                            <div class="text-[11px] text-slate-400">Giá: 385.000.000 ₫ (Swiss Made)</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- 4 Core Trust Badges -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center gap-3">
                <i class="fa-solid fa-certificate text-amber-400 text-2xl"></i>
                <div class="text-xs">
                    <div class="font-bold text-white">100% Chính Hãng</div>
                    <div class="text-slate-400 text-[10px]">Đền 10 lần nếu phát hiện fake</div>
                </div>
            </div>
            <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center gap-3">
                <i class="fa-solid fa-shield-halved text-amber-400 text-2xl"></i>
                <div class="text-xs">
                    <div class="font-bold text-white">Bảo Hành 5 Năm Vàng</div>
                    <div class="text-slate-400 text-[10px]">Lau dầu & thay pin miễn phí</div>
                </div>
            </div>
            <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center gap-3">
                <i class="fa-solid fa-truck-fast text-amber-400 text-2xl"></i>
                <div class="text-xs">
                    <div class="font-bold text-white">Giao Hỏa Tốc Toàn Quốc</div>
                    <div class="text-slate-400 text-[10px]">Kiểm tra trước khi trả tiền</div>
                </div>
            </div>
            <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center gap-3">
                <i class="fa-solid fa-arrows-rotate text-amber-400 text-2xl"></i>
                <div class="text-xs">
                    <div class="font-bold text-white">Đổi Mới 30 Ngày</div>
                    <div class="text-slate-400 text-[10px]">Đổi 1-1 miễn phí nếu có lỗi</div>
                </div>
            </div>
        </div>

        <!-- Brands selector -->
        <div>
            <div class="text-center mb-6">
                <span class="font-cinzel text-xs text-amber-400 uppercase tracking-widest font-bold">Thương Hiệu Hợp Tác</span>
                <h3 class="text-xl font-serif text-white mt-1">Các Nhà Sản Xuất Đồng Hồ Huyền Thoại</h3>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
                @foreach($categories as $cat)
                    <a href="?brand={{ $cat->name }}#products-section" 
                       class="p-3 rounded-2xl bg-slate-900 border border-slate-800 hover:border-amber-500/50 hover:bg-slate-800/60 transition text-center group">
                        <div class="w-10 h-10 rounded-full bg-slate-950 text-amber-400 flex items-center justify-center mx-auto mb-2 text-sm border border-slate-700 group-hover:scale-110 transition">
                            <i class="fa-solid fa-crown text-xs"></i>
                        </div>
                        <div class="font-cinzel text-xs font-bold text-slate-200 group-hover:text-amber-400">{{ $cat->name }}</div>
                        <div class="text-[10px] text-slate-500">{{ $cat->products_count }} mẫu</div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- MỤC 2: BỘ SƯU TẬP ĐỒNG HỒ & BỘ LỌC TÌM KIẾM                             -->
<!-- ========================================================================= -->
<section id="products-section" class="py-16 border-b border-slate-800 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="font-cinzel text-amber-400 text-xs uppercase tracking-widest font-bold">Mục 2 Trên Trang</span>
                <h2 class="text-3xl font-serif font-bold text-white mt-1">Bộ Sưu Tập Đồng Hồ Chính Hãng</h2>
                <p class="text-xs text-slate-400 mt-1">Tìm kiếm và lọc trực tiếp các mẫu đồng hồ theo phân khúc, thương hiệu và mức giá.</p>
            </div>
            <div class="text-xs text-slate-400">
                Hiển thị <span class="text-amber-400 font-bold">{{ $allProducts->count() }}</span> mẫu đồng hồ
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <form action="{{ route('home') }}#products-section" method="GET" class="bg-slate-900/90 border border-slate-800 p-5 rounded-3xl shadow-xl space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                
                <!-- Search input -->
                <div>
                    <label class="block text-[11px] text-slate-400 mb-1">Tìm kiếm từ khóa:</label>
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Rolex, Omega, Sapphire..." 
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl pl-8 pr-3 py-2 text-xs text-white focus:outline-none focus:border-amber-500">
                        <i class="fa-solid fa-magnifying-glass absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                    </div>
                </div>

                <!-- Brand filter -->
                <div>
                    <label class="block text-[11px] text-slate-400 mb-1">Thương hiệu:</label>
                    <select name="brand" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-500">
                        <option value="all">Tất cả thương hiệu</option>
                        @foreach($brands as $b)
                            <option value="{{ $b }}" {{ request('brand') === $b ? 'selected' : '' }}>{{ $b }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Gender filter -->
                <div>
                    <label class="block text-[11px] text-slate-400 mb-1">Đối tượng:</label>
                    <select name="gender" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-500">
                        <option value="all">Tất cả đối tượng</option>
                        <option value="men" {{ request('gender') === 'men' ? 'selected' : '' }}>Đồng hồ Nam</option>
                        <option value="women" {{ request('gender') === 'women' ? 'selected' : '' }}>Đồng hồ Nữ</option>
                        <option value="unisex" {{ request('gender') === 'unisex' ? 'selected' : '' }}>Unisex</option>
                    </select>
                </div>

                <!-- Movement filter -->
                <div>
                    <label class="block text-[11px] text-slate-400 mb-1">Loại bộ máy:</label>
                    <select name="movement" class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-500">
                        <option value="all">Tất cả bộ máy</option>
                        <option value="Automatic" {{ request('movement') === 'Automatic' ? 'selected' : '' }}>Cơ Automatic</option>
                        <option value="Quartz" {{ request('movement') === 'Quartz' ? 'selected' : '' }}>Máy Pin Quartz</option>
                        <option value="Eco-Drive" {{ request('movement') === 'Eco-Drive' ? 'selected' : '' }}>Năng lượng ánh sáng</option>
                    </select>
                </div>

                <!-- Action Button -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition">
                        Lọc kết quả
                    </button>
                    <a href="{{ route('home') }}#products-section" class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-400 text-xs" title="Đặt lại">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                </div>

            </div>
        </form>

        <!-- Products Grid -->
        @if($allProducts->isEmpty())
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-12 text-center text-xs text-slate-400">
                Không tìm thấy mẫu đồng hồ nào phù hợp với bộ lọc hiện tại. Vui lòng bấm "Đặt lại" để xem toàn bộ sản phẩm.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($allProducts as $product)
                    <div class="bg-slate-900 rounded-2xl border border-slate-800 hover:border-amber-500/50 p-4 transition duration-300 flex flex-col justify-between group shadow-xl">
                        <div>
                            <!-- Image Box -->
                            <div class="relative overflow-hidden rounded-xl bg-slate-950 p-3 mb-3">
                                <span class="absolute top-2 right-2 bg-slate-900 text-slate-300 text-[10px] px-2 py-0.5 rounded border border-slate-700">
                                    {{ $product->dial_size }}
                                </span>
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                                    referrerpolicy="no-referrer"
                                    onerror="this.onerror=null; this.src='https://placehold.co/400x400?text=ChronoLux';"
                                    class="w-full h-52 object-contain rounded-lg group-hover:scale-105 transition duration-500">
                            </div>

                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="font-cinzel text-amber-400 font-bold uppercase">{{ $product->brand }}</span>
                                <span class="text-slate-400 text-[10px]">{{ $product->sku }}</span>
                            </div>

                            <h3 class="font-semibold text-xs text-slate-100 line-clamp-2 hover:text-amber-400 transition">
                                {{ $product->name }}
                            </h3>

                            <div class="flex items-center gap-2 my-2 text-[10px] text-slate-400">
                                <span class="bg-slate-950 px-2 py-0.5 rounded border border-slate-800">{{ $product->movement }}</span>
                                <span class="bg-slate-950 px-2 py-0.5 rounded border border-slate-800">{{ $product->water_resistance }}</span>
                            </div>

                            <div class="mt-2">
                                <div class="text-base font-bold text-amber-400">{{ $product->formatted_price }}</div>
                                @if($product->formatted_original_price)
                                    <div class="text-[10px] text-slate-500 line-through">{{ $product->formatted_original_price }}</div>
                                @endif
                            </div>
                        </div>

                        <!-- Action Buttons: Khách hàng (Mua/Giỏ) | Admin (Quản lý tồn kho/Sửa sản phẩm) -->
                        @if(Auth::check() && Auth::user()->isAdmin())
                            <div class="mt-4 pt-3 border-t border-slate-800 flex items-center justify-between gap-2">
                                <span class="text-xs text-amber-400 font-semibold flex items-center gap-1.5">
                                    <i class="fa-solid fa-warehouse"></i> Tồn kho: <strong class="text-white">{{ $product->stock }}</strong>
                                </span>
                                <div class="flex items-center gap-1.5">
                                    <button type="button" onclick="openEditProductModal({{ $product->id }}, '{{ addslashes($product->name) }}', '{{ addslashes($product->brand) }}', {{ $product->price }}, {{ $product->original_price ?? $product->price }}, {{ $product->stock }}, '{{ addslashes($product->movement) }}', '{{ addslashes($product->image) }}')" 
                                        class="px-3 py-1.5 rounded-xl bg-amber-500/20 hover:bg-amber-500 hover:text-slate-950 text-amber-300 font-bold text-xs transition flex items-center gap-1 border border-amber-500/40" title="Chỉnh sửa sản phẩm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Quản lý</span>
                                    </button>
                                    <button onclick="openProductModal('{{ addslashes($product->name) }}', '{{ $product->brand }}', '{{ $product->formatted_price }}', '{{ $product->image }}', '{{ addslashes($product->description) }}', '{{ $product->movement }}', '{{ $product->dial_size }}', '{{ $product->glass_type }}', '{{ $product->water_resistance }}', '{{ $product->warranty_years }}')" 
                                        class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 flex items-center justify-center text-xs transition" title="Xem thông số kỹ thuật">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="mt-4 pt-3 border-t border-slate-800 flex items-center gap-1.5">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="px-2.5 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-amber-400 hover:text-white border border-slate-700 font-semibold text-xs transition flex items-center justify-center gap-1 cursor-pointer" title="Thêm vào giỏ">
                                        <i class="fa-solid fa-cart-plus text-xs"></i>
                                        <span class="text-[11px]">Giỏ</span>
                                    </button>
                                </form>
                                <a href="{{ route('buy.now', $product->id) }}" 
                                    class="flex-1 py-2 px-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition text-center flex items-center justify-center gap-1 shadow-sm cursor-pointer">
                                    <i class="fa-solid fa-bolt text-xs"></i>
                                    <span>Mua</span>
                                </a>
                                <button onclick="openProductModal('{{ addslashes($product->name) }}', '{{ $product->brand }}', '{{ $product->formatted_price }}', '{{ $product->image }}', '{{ addslashes($product->description) }}', '{{ $product->movement }}', '{{ $product->dial_size }}', '{{ $product->glass_type }}', '{{ $product->water_resistance }}', '{{ $product->warranty_years }}')" 
                                    class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 flex items-center justify-center text-xs transition border border-slate-700 cursor-pointer" title="Xem thông số kỹ thuật">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>

<!-- ========================================================================= -->
<!-- MỤC 3: TRA CỨU ĐƠN HÀNG TRỰC TIẾP TRÊN TRANG                             -->
<!-- ========================================================================= -->
<section id="tracking-section" class="py-16 border-b border-slate-800 bg-slate-900/40">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div class="text-center space-y-2">
            <span class="font-cinzel text-amber-400 text-xs uppercase tracking-widest font-bold">Mục 3 Trên Trang</span>
            <h2 class="text-3xl font-serif font-bold text-white">Tra Cứu Tiến Độ Đơn Hàng</h2>
            <p class="text-xs text-slate-400 max-w-md mx-auto">
                Nhập mã đơn hàng (Ví dụ: CL-...) hoặc số điện thoại để kiểm tra tiến trình giao hàng ngay tại chỗ.
            </p>
        </div>

        <!-- Search Form -->
        <form action="{{ route('home') }}#tracking-section" method="GET" class="max-w-xl mx-auto flex gap-2">
            <div class="relative flex-1">
                <input type="text" name="track_q" value="{{ request('track_q', $trackKeyword) }}" required placeholder="Nhập mã đơn (CL-...) hoặc Số điện thoại..." 
                    class="w-full bg-slate-950 border border-slate-700 rounded-xl pl-10 pr-4 py-3 text-xs text-white uppercase focus:outline-none focus:border-amber-500 shadow-inner">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
            </div>
            <button type="submit" class="px-6 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition shadow">
                Kiểm tra
            </button>
        </form>

        <!-- Tracking Results Card -->
        @if($trackedOrder)
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-6">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-800">
                    <div>
                        <div class="text-[10px] text-slate-400 uppercase tracking-wider">Mã đơn hàng:</div>
                        <div class="font-mono font-bold text-xl text-amber-400">{{ $trackedOrder->order_code }}</div>
                        <div class="text-[10px] text-slate-400">Thời gian tạo: {{ $trackedOrder->created_at->format('H:i d/m/Y') }}</div>
                    </div>
                    @php $badge = $trackedOrder->status_badge; @endphp
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold border {{ $badge['color'] }}">
                            {{ $badge['label'] }}
                        </span>
                    </div>
                </div>

                <!-- 4 Step Timeline -->
                @php
                    $steps = ['pending' => 1, 'processing' => 2, 'shipping' => 3, 'completed' => 4];
                    $cur = $steps[$trackedOrder->order_status] ?? 1;
                @endphp
                <div class="grid grid-cols-4 gap-2 text-center text-[11px]">
                    <div class="space-y-1.5">
                        <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center font-bold {{ $cur >= 1 ? 'bg-amber-500 text-slate-950' : 'bg-slate-800 text-slate-400' }}">1</div>
                        <span class="{{ $cur >= 1 ? 'text-amber-400 font-bold' : 'text-slate-400' }}">Đặt hàng</span>
                    </div>
                    <div class="space-y-1.5">
                        <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center font-bold {{ $cur >= 2 ? 'bg-amber-500 text-slate-950' : 'bg-slate-800 text-slate-400' }}">2</div>
                        <span class="{{ $cur >= 2 ? 'text-amber-400 font-bold' : 'text-slate-400' }}">Chuẩn bị hàng</span>
                    </div>
                    <div class="space-y-1.5">
                        <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center font-bold {{ $cur >= 3 ? 'bg-amber-500 text-slate-950' : 'bg-slate-800 text-slate-400' }}">3</div>
                        <span class="{{ $cur >= 3 ? 'text-amber-400 font-bold' : 'text-slate-400' }}">Đang vận chuyển</span>
                    </div>
                    <div class="space-y-1.5">
                        <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center font-bold {{ $cur >= 4 ? 'bg-emerald-500 text-slate-950' : 'bg-slate-800 text-slate-400' }}">4</div>
                        <span class="{{ $cur >= 4 ? 'text-emerald-400 font-bold' : 'text-slate-400' }}">Đã giao hàng</span>
                    </div>
                </div>

                <!-- Customer Details & Items -->
                <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800 grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase">Khách hàng nhận:</span>
                        <div class="font-bold text-white">{{ $trackedOrder->customer_name }} - {{ $trackedOrder->customer_phone }}</div>
                        <div class="text-slate-400 text-[11px] mt-0.5">{{ $trackedOrder->shipping_address }}, {{ $trackedOrder->city }}</div>
                    </div>
                    <div>
                        <span class="text-[10px] text-slate-400 uppercase">Phương thức thanh toán:</span>
                        <div class="font-bold text-slate-200">
                            {{ $trackedOrder->payment_method === 'banking' ? 'Chuyển khoản VietQR' : 'Tiền mặt khi nhận hàng (COD)' }}
                        </div>
                        <div class="text-emerald-400 font-bold text-sm mt-1">Tổng tiền: {{ $trackedOrder->formatted_total }}</div>
                        @if($trackedOrder->shipping_fee > 0 || $trackedOrder->shipping_distance)
                            <div class="mt-1 text-[11px] text-slate-400 flex items-center justify-between">
                                <span><i class="fa-solid fa-truck-fast text-amber-400 mr-1"></i> Phí ship GHN: {{ number_format($trackedOrder->shipping_fee, 0, ',', '.') }} ₫</span>
                                <span class="text-amber-400 font-semibold">~{{ $trackedOrder->shipping_distance ? $trackedOrder->shipping_distance . ' km' : '15 km' }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Items list -->
                <div class="divide-y divide-slate-800 border border-slate-800 rounded-2xl overflow-hidden">
                    @foreach($trackedOrder->items as $it)
                        <div class="p-3 bg-slate-950 flex items-center justify-between text-xs">
                            <div class="flex items-center gap-3">
                                <img src="{{ $it->product_image }}" class="w-10 h-10 object-contain rounded bg-slate-900 p-1">
                                <div>
                                    <div class="font-semibold text-white">{{ $it->product_name }}</div>
                                    <div class="text-[10px] text-slate-400">SL: {{ $it->quantity }} chiếc</div>
                                </div>
                            </div>
                            <span class="font-bold text-amber-400">{{ $it->formatted_total }}</span>
                        </div>
                    @endforeach
                </div>

                @if($trackedOrder->order_status === 'pending')
                    <div class="pt-2 flex justify-end">
                        <form action="{{ route('orders.cancel', $trackedOrder->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng {{ $trackedOrder->order_code }} không?');">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer">
                                <i class="fa-solid fa-ban"></i>
                                <span>Hủy đơn hàng này</span>
                            </button>
                        </form>
                    </div>
                @elseif($trackedOrder->order_status === 'cancelled')
                    <div class="p-3 rounded-xl bg-rose-950/40 border border-rose-800/50 text-rose-300 text-xs text-center font-medium">
                        <i class="fa-solid fa-circle-exclamation mr-1 text-rose-400"></i> Đơn hàng này đã bị hủy.
                    </div>
                @endif

            </div>
        @elseif(!empty($trackKeyword))
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 text-center text-xs text-slate-400">
                Không tìm thấy đơn hàng nào với từ khóa "{{ $trackKeyword }}". Vui lòng kiểm tra lại mã đơn hoặc gọi Hotline 1900 8888.
            </div>
        @else
            <div class="bg-slate-900/60 border border-slate-800 rounded-3xl p-8 text-center text-xs text-slate-400">
                Nhập mã đơn hàng ở ô phía trên để tra cứu tiến độ vận chuyển trực tiếp.
            </div>
        @endif

    </div>
</section>

<!-- ========================================================================= -->
<!-- SLIDE-OVER CART DRAWER & QUICK CHECKOUT MODAL (CHỈ DÀNH CHO KHÁCH HÀNG)   -->
<!-- ========================================================================= -->
@if(!Auth::check() || !Auth::user()->isAdmin())
<div id="cart-drawer-backdrop" onclick="toggleCartDrawer()" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden transition-opacity"></div>

<div id="cart-drawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-slate-900 border-l border-slate-800 z-50 transform translate-x-full transition duration-300 flex flex-col justify-between shadow-2xl p-6">
    <div class="space-y-4 flex-1 overflow-y-auto">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
            <h3 class="font-cinzel text-base font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-bag-shopping text-amber-400"></i>
                <span>Giỏ Hàng Đồng Hồ</span>
            </h3>
            <button onclick="toggleCartDrawer()" class="text-slate-400 hover:text-white text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        @if(empty($cart))
            <div class="text-center py-12 space-y-3">
                <i class="fa-solid fa-basket-shopping text-3xl text-slate-600"></i>
                <div class="text-xs text-slate-400">Giỏ hàng của bạn đang trống.</div>
                <button onclick="toggleCartDrawer()" class="px-4 py-2 rounded-xl bg-amber-500 text-slate-950 font-bold text-xs uppercase">
                    Chọn mua đồng hồ
                </button>
            </div>
        @else
            <!-- Items in cart -->
            <div class="divide-y divide-slate-800">
                @foreach($cart as $item)
                    <div class="py-3 flex items-center gap-3 text-xs">
                        <img src="{{ $item['image'] }}" class="w-12 h-12 object-contain bg-slate-950 p-1 rounded-lg border border-slate-800 flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-white truncate">{{ $item['name'] }}</h4>
                            <div class="text-[10px] text-amber-400 font-bold">{{ number_format($item['price'], 0, ',', '.') }} ₫</div>
                            <div class="text-[10px] text-slate-400">SL: {{ $item['quantity'] }}</div>
                        </div>
                        <a href="{{ route('cart.remove', $item['id']) }}" class="text-slate-500 hover:text-red-400 p-1">
                            <i class="fa-solid fa-trash-can text-xs"></i>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Voucher Code -->
            <div class="pt-3 border-t border-slate-800">
                <form action="{{ route('cart.voucher') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="text" name="voucher_code" placeholder="Mã giảm giá (CHRONO10)" required 
                        class="flex-1 bg-slate-950 border border-slate-700 rounded-xl px-3 py-1.5 text-xs text-white uppercase focus:outline-none focus:border-amber-500">
                    <button type="submit" class="px-3 py-1.5 bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-amber-400 font-bold text-xs rounded-xl transition">
                        Áp dụng
                    </button>
                </form>
            </div>

            <!-- Total summary -->
            <div class="space-y-2 pt-3 border-t border-slate-800 text-xs">
                <div class="flex justify-between text-slate-400">
                    <span>Tạm tính:</span>
                    <span class="text-white">{{ number_format($subtotal, 0, ',', '.') }} ₫</span>
                </div>
                @if($discount > 0)
                    <div class="flex justify-between text-emerald-400">
                        <span>Giảm giá (Voucher):</span>
                        <span>-{{ number_format($discount, 0, ',', '.') }} ₫</span>
                    </div>
                @endif
                <div class="flex justify-between text-slate-400">
                    <span>Vận chuyển:</span>
                    <span class="text-emerald-400">Miễn phí toàn quốc</span>
                </div>
                <div class="flex justify-between text-sm font-bold pt-2 border-t border-slate-800">
                    <span class="text-white">Tổng tiền:</span>
                    <span class="text-amber-400">{{ number_format($totalAmount, 0, ',', '.') }} ₫</span>
                </div>
            </div>
        @endif
    </div>

    @if(!empty($cart))
        <div class="pt-4 border-t border-slate-800 space-y-2">
            <a href="{{ route('checkout.index') }}" class="block w-full py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider text-center transition shadow-lg shadow-amber-500/20">
                Chuyển Đến Trang Thanh Toán <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
            <a href="{{ route('cart.index') }}" class="block w-full py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-xs text-center transition">
                Xem Chi Tiết Giỏ Hàng
            </a>
        </div>
    @endif
</div>

<!-- ========================================================================= -->
<!-- MODAL: ĐẶT HÀNG NHANH 1-CLICK (QUICK ORDER MODAL)                         -->
<!-- ========================================================================= -->
<div id="quick-order-modal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 max-w-lg w-full space-y-5 shadow-2xl relative">
        <button onclick="closeQuickOrderModal()" class="absolute top-5 right-5 text-slate-400 hover:text-white">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <div class="flex items-center gap-3 pb-3 border-b border-slate-800">
            <img id="modal-img" src="" class="w-14 h-14 object-contain rounded-xl bg-slate-950 p-1 border border-slate-800">
            <div>
                <h3 id="modal-title" class="font-bold text-sm text-white line-clamp-1"></h3>
                <div id="modal-price" class="text-sm font-bold text-amber-400"></div>
            </div>
        </div>

        <form action="{{ route('quick.order') }}" method="POST" class="space-y-3">
            @csrf
            <input type="hidden" name="product_id" id="modal-product-id">

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] text-slate-300 mb-1">Họ tên của bạn *</label>
                    <input type="text" name="customer_name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required placeholder="Nguyễn Văn A" 
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-500">
                </div>
                <div>
                    <label class="block text-[11px] text-slate-300 mb-1">Số điện thoại *</label>
                    <input type="tel" name="customer_phone" value="{{ Auth::check() ? (Auth::user()->phone ?? '') : '' }}" required placeholder="0988 888 888" 
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-500">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] text-slate-300 mb-1">Tỉnh / Thành phố *</label>
                    <input type="text" name="city" required placeholder="Hà Nội, TP.HCM..." 
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-500">
                </div>
                <div>
                    <label class="block text-[11px] text-slate-300 mb-1">Số lượng đặt:</label>
                    <input type="number" name="quantity" value="1" min="1" max="10" 
                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-500">
                </div>
            </div>

            <div>
                <label class="block text-[11px] text-slate-300 mb-1">Địa chỉ nhận hàng chi tiết *</label>
                <input type="text" name="shipping_address" value="{{ Auth::check() ? (Auth::user()->address ?? '') : '' }}" required placeholder="Số nhà, tên đường, phường..." 
                    class="w-full bg-slate-950 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-500">
            </div>

            <div>
                <label class="block text-[11px] text-slate-300 mb-1">Hình thức thanh toán:</label>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-950 border border-slate-700 cursor-pointer">
                        <input type="radio" name="payment_method" value="cod" checked class="text-amber-500">
                        <span>Tiền mặt (COD)</span>
                    </label>
                    <label class="flex items-center gap-2 p-2.5 rounded-xl bg-slate-950 border border-slate-700 cursor-pointer">
                        <input type="radio" name="payment_method" value="banking" class="text-amber-500">
                        <span>Chuyển khoản VietQR</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition shadow-lg shadow-amber-500/20">
                Xác Nhận Đặt Mua Ngay
            </button>
        </form>
    </div>
</div>
@endif

<!-- ========================================================================= -->
<!-- MODAL: XEM THÔNG SỐ KỸ THUẬT (QUICK VIEW MODAL)                           -->
<!-- ========================================================================= -->
<div id="product-modal" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 sm:p-8 max-w-2xl w-full space-y-4 shadow-2xl relative max-h-[90vh] overflow-y-auto">
        <button onclick="closeProductModal()" class="absolute top-5 right-5 text-slate-400 hover:text-white">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <div class="flex items-center gap-4 pb-4 border-b border-slate-800">
            <img id="detail-img" src="" class="w-20 h-20 object-contain rounded-xl bg-slate-950 p-1 border border-slate-800">
            <div>
                <div id="detail-brand" class="font-cinzel text-amber-400 text-xs font-bold uppercase"></div>
                <h3 id="detail-title" class="font-bold text-base text-white"></h3>
                <div id="detail-price" class="text-lg font-bold text-amber-400 mt-1"></div>
            </div>
        </div>

        <div class="space-y-3">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Thông số kỹ thuật:</h4>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <div class="bg-slate-950 p-2.5 rounded-xl border border-slate-800">
                    <span class="text-[10px] text-slate-400 block">Bộ máy:</span>
                    <span id="detail-movement" class="font-semibold text-slate-200"></span>
                </div>
                <div class="bg-slate-950 p-2.5 rounded-xl border border-slate-800">
                    <span class="text-[10px] text-slate-400 block">Kích thước mặt:</span>
                    <span id="detail-size" class="font-semibold text-slate-200"></span>
                </div>
                <div class="bg-slate-950 p-2.5 rounded-xl border border-slate-800">
                    <span class="text-[10px] text-slate-400 block">Kính:</span>
                    <span id="detail-glass" class="font-semibold text-slate-200"></span>
                </div>
                <div class="bg-slate-950 p-2.5 rounded-xl border border-slate-800">
                    <span class="text-[10px] text-slate-400 block">Kháng nước:</span>
                    <span id="detail-water" class="font-semibold text-slate-200"></span>
                </div>
            </div>
            
            <div class="pt-2">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Mô tả:</h4>
                <p id="detail-desc" class="text-xs text-slate-300 leading-relaxed"></p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Live Countdown Timer
    function startTimer() {
        let h = 8, m = 45, s = 20;
        setInterval(() => {
            if (s > 0) s--;
            else {
                s = 59;
                if (m > 0) m--;
                else { m = 59; if (h > 0) h--; }
            }
            const elH = document.getElementById('p1-timer-hours');
            const elM = document.getElementById('p1-timer-min');
            const elS = document.getElementById('p1-timer-sec');
            if (elH && elM && elS) {
                elH.textContent = String(h).padStart(2, '0');
                elM.textContent = String(m).padStart(2, '0');
                elS.textContent = String(s).padStart(2, '0');
            }
        }, 1000);
    }
    startTimer();

    // Toggle Cart Drawer
    function toggleCartDrawer() {
        const drawer = document.getElementById('cart-drawer');
        const backdrop = document.getElementById('cart-drawer-backdrop');
        if (drawer.classList.contains('translate-x-full')) {
            drawer.classList.remove('translate-x-full');
            backdrop.classList.remove('hidden');
        } else {
            drawer.classList.add('translate-x-full');
            backdrop.classList.add('hidden');
        }
    }

    // Quick Order Modal
    function openQuickOrderModal(id, title, price, img) {
        document.getElementById('modal-product-id').value = id;
        document.getElementById('modal-title').textContent = title;
        document.getElementById('modal-price').textContent = price;
        document.getElementById('modal-img').src = img;
        document.getElementById('quick-order-modal').classList.remove('hidden');
    }

    function closeQuickOrderModal() {
        document.getElementById('quick-order-modal').classList.add('hidden');
    }

    // Quick View Spec Modal
    function openProductModal(title, brand, price, img, desc, movement, size, glass, water, warranty) {
        document.getElementById('detail-title').textContent = title;
        document.getElementById('detail-brand').textContent = brand;
        document.getElementById('detail-price').textContent = price;
        document.getElementById('detail-img').src = img;
        document.getElementById('detail-desc').textContent = desc;
        document.getElementById('detail-movement').textContent = movement;
        document.getElementById('detail-size').textContent = size;
        document.getElementById('detail-glass').textContent = glass;
        document.getElementById('detail-water').textContent = water;
        document.getElementById('product-modal').classList.remove('hidden');
    }

    function closeProductModal() {
        document.getElementById('product-modal').classList.add('hidden');
    }
</script>
@endpush
