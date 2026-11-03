@extends('layouts.app')

@section('title', 'ChronoLux - Đỉnh Cao Đồng Hồ Thụy Sĩ & Nhật Bản Chính Hãng')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 overflow-hidden py-16 md:py-24 border-b border-slate-800">
    <!-- Subtle glow background elements -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-amber-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Headline -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-amber-500/30 bg-amber-500/10 text-amber-400 text-xs font-semibold tracking-wider uppercase">
                    <i class="fa-solid fa-crown text-amber-400"></i> Bộ Sưu Tập Đồng Hồ Thụy Sĩ 2026
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight leading-tight">
                    <span class="font-cinzel block gold-gradient-text">Đỉnh Cao Chế Tác</span>
                    <span class="text-slate-100 font-serif italic text-3xl sm:text-4xl lg:text-5xl">Khẳng Định Đẳng Cấp Thời Gian</span>
                </h1>

                <p class="text-slate-400 text-base sm:text-lg leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    Khám phá kiệt tác đồng hồ cơ khí tinh xảo từ các thương hiệu huyền thoại thế giới: Rolex, Omega, Patek Philippe, Hublot, Seiko, Tissot. Cam kết 100% chính hãng cùng chế độ bảo hành 5 năm vàng độc quyền tại ChronoLux.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('products.index') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl gold-gradient-bg text-slate-950 font-bold text-sm tracking-wider uppercase hover:opacity-95 hover:scale-[1.02] transition shadow-[0_0_25px_rgba(198,146,37,0.4)] flex items-center justify-center gap-2">
                        <span>Khám Phá Bộ Sưu Tập</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('pages.warranty') }}" class="w-full sm:w-auto px-7 py-4 rounded-xl border border-slate-700 bg-slate-900/60 hover:bg-slate-800 text-slate-200 font-medium text-sm transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-shield-halved text-amber-400"></i>
                        <span>Đặc Quyền Bảo Hành 5 Năm</span>
                    </a>
                </div>

                <!-- Stats summary -->
                <div class="grid grid-cols-3 gap-4 pt-8 border-t border-slate-800/80 max-w-lg mx-auto lg:mx-0 text-center">
                    <div>
                        <div class="text-2xl sm:text-3xl font-bold font-cinzel text-amber-400">100%</div>
                        <div class="text-xs text-slate-400 uppercase tracking-wider mt-1">Chính hãng nhập khẩu</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-bold font-cinzel text-amber-400">5 Năm</div>
                        <div class="text-xs text-slate-400 uppercase tracking-wider mt-1">Bảo hành toàn diện</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-bold font-cinzel text-amber-400">15.000+</div>
                        <div class="text-xs text-slate-400 uppercase tracking-wider mt-1">Khách hàng tin chọn</div>
                    </div>
                </div>
            </div>

            <!-- Right Showcase Card -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-sm rounded-3xl p-1 bg-gradient-to-b from-amber-500/40 via-slate-800 to-slate-900 shadow-2xl">
                    <div class="bg-slate-950 rounded-[22px] p-6 text-center overflow-hidden relative">
                        <div class="absolute top-4 right-4 bg-amber-500/20 text-amber-400 border border-amber-500/40 text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                            Masterpiece
                        </div>
                        <div class="relative group my-4">
                            <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=600&auto=format&fit=crop&q=80" 
                                alt="Rolex Submariner" 
                                class="w-72 h-72 object-cover mx-auto rounded-2xl group-hover:scale-105 transition duration-500 shadow-2xl">
                        </div>
                        <div class="text-amber-400 font-cinzel text-sm font-semibold tracking-widest uppercase">Rolex Swiss Made</div>
                        <h3 class="text-lg font-bold text-slate-100 mt-1 line-clamp-1">Submariner Date 41mm Royal</h3>
                        <div class="flex items-center justify-center gap-3 my-2">
                            <span class="text-xl font-bold text-amber-400">385.000.000 ₫</span>
                            <span class="text-xs text-slate-400 line-through">415.000.000 ₫</span>
                        </div>
                        <p class="text-xs text-slate-400 line-clamp-2 px-2">Vành xoay gốm Cerachrom xanh hoàng gia, kính Sapphire lúp Cyclops, độ chịu nước 300 mét.</p>
                        <div class="mt-5">
                            <a href="{{ route('products.show', 'rolex-submariner-date-41mm-oystersteel-mat-xanh-royal') }}" class="block w-full py-2.5 rounded-lg bg-amber-500/20 hover:bg-amber-500 text-amber-300 hover:text-slate-950 border border-amber-500/40 font-semibold text-xs transition duration-300">
                                Xem Chi Tiết Kiệt Tác
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- USP Feature Bar -->
<section class="bg-slate-900/60 border-b border-slate-800 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-800/40 transition">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 text-xl flex-shrink-0">
                    <i class="fa-solid fa-certificate"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-sm text-slate-100">100% Chính Hãng</h4>
                    <p class="text-xs text-slate-400">Đền 10 lần nếu phát hiện hàng giả</p>
                </div>
            </div>
            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-800/40 transition">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 text-xl flex-shrink-0">
                    <i class="fa-solid fa-gem"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-sm text-slate-100">Bảo Hành 5 Năm Vàng</h4>
                    <p class="text-xs text-slate-400">Lau dầu & thay pin miễn phí</p>
                </div>
            </div>
            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-800/40 transition">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 text-xl flex-shrink-0">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-sm text-slate-100">Kiểm Tra Khi Nhận</h4>
                    <p class="text-xs text-slate-400">Mở hộp kiểm tra trước thanh toán</p>
                </div>
            </div>
            <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-slate-800/40 transition">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 text-xl flex-shrink-0">
                    <i class="fa-solid fa-arrows-rotate"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-sm text-slate-100">Đổi Mới 30 Ngày</h4>
                    <p class="text-xs text-slate-400">Đổi trả 1-1 miễn phí nếu có lỗi</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Flash Sale section removed per user request -->

<!-- Brand Logos Carousel / Grid -->
<section class="py-14 bg-slate-950 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-10">
            <h2 class="font-cinzel text-xs font-semibold text-amber-400 uppercase tracking-[0.3em] mb-2">Thương Hiệu Đồng Hành</h2>
            <p class="text-2xl font-serif text-slate-100">Các Biểu Tượng Cơ Khí Danh Tiếng</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['brand' => $category->name]) }}" 
                   class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800 hover:border-amber-500/50 hover:bg-slate-800/80 transition text-center group flex flex-col items-center justify-center">
                    <div class="w-12 h-12 rounded-full bg-slate-950 border border-slate-700 group-hover:border-amber-400 flex items-center justify-center text-amber-400 text-lg mb-2 shadow-inner group-hover:scale-110 transition duration-300">
                        <i class="fa-solid fa-crown text-sm"></i>
                    </div>
                    <span class="font-cinzel text-xs font-bold text-slate-200 group-hover:text-amber-400 transition">{{ $category->name }}</span>
                    <span class="text-[10px] text-slate-400 mt-0.5">{{ $category->products_count }} mẫu</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-16 bg-slate-900/40 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
            <div>
                <span class="font-cinzel text-xs font-semibold text-amber-400 uppercase tracking-[0.25em] block mb-1">Kiệt Tác Tuyển Chọn</span>
                <h2 class="text-3xl font-bold font-serif text-slate-100">Đồng Hồ Nổi Bật Nhất</h2>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('products.index') }}" class="text-xs uppercase tracking-wider font-semibold text-amber-400 hover:text-amber-300 transition flex items-center gap-1.5">
                    <span>Xem tất cả sản phẩm</span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="bg-slate-900 rounded-2xl border border-slate-800/80 hover:border-amber-500/50 p-4 transition duration-300 flex flex-col justify-between group shadow-xl hover:-translate-y-1">
                    <div>
                        <!-- Product Image -->
                        <div class="relative overflow-hidden rounded-xl bg-slate-950 p-3 mb-4">
                            <span class="absolute top-2 right-2 bg-slate-900/90 text-slate-300 text-[10px] px-2 py-0.5 rounded border border-slate-700">
                                {{ $product->dial_size }}
                            </span>
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                                    class="w-full h-56 object-cover rounded-lg group-hover:scale-108 transition duration-500">
                            </a>
                        </div>

                        <!-- Brand & Title -->
                        <div class="flex items-center justify-between text-xs mb-1">
                            <span class="font-cinzel text-amber-400 font-bold uppercase tracking-wider">{{ $product->brand }}</span>
                            <span class="text-slate-400 text-[11px]">{{ $product->gender_label }}</span>
                        </div>
                        <h3 class="font-semibold text-sm text-slate-100 hover:text-amber-400 transition line-clamp-2">
                            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>

                        <!-- Specs highlights -->
                        <div class="flex items-center gap-2 my-2 text-[11px] text-slate-400">
                            <span class="bg-slate-950 px-2 py-0.5 rounded border border-slate-800"><i class="fa-solid fa-gears text-amber-400 mr-1"></i>{{ $product->movement }}</span>
                            <span class="bg-slate-950 px-2 py-0.5 rounded border border-slate-800"><i class="fa-solid fa-droplet text-amber-400 mr-1"></i>{{ $product->water_resistance }}</span>
                        </div>

                        <!-- Price -->
                        <div class="mt-3">
                            <div class="text-lg font-bold text-amber-400">{{ $product->formatted_price }}</div>
                            @if($product->formatted_original_price)
                                <div class="text-xs text-slate-400 line-through">{{ $product->formatted_original_price }}</div>
                            @endif
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="mt-4 pt-3 border-t border-slate-800/80 flex items-center gap-1.5">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="px-2.5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-amber-400 hover:text-white border border-slate-700 font-semibold text-xs transition flex items-center justify-center gap-1 cursor-pointer" title="Thêm vào giỏ hàng">
                                <i class="fa-solid fa-cart-plus text-xs"></i>
                                <span class="text-[11px]">Giỏ</span>
                            </button>
                        </form>
                        <a href="{{ route('buy.now', $product->id) }}" class="flex-1 py-2.5 px-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition text-center flex items-center justify-center gap-1 shadow cursor-pointer">
                            <i class="fa-solid fa-bolt text-xs"></i>
                            <span>Mua</span>
                        </a>
                        <a href="{{ route('products.show', $product->slug) }}" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white flex items-center justify-center text-xs transition border border-slate-700 cursor-pointer" title="Xem chi tiết">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>

<!-- Collection Categories: Men & Women split banners -->
<section class="py-16 bg-slate-950 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Men's Collection Banner -->
            <div class="relative overflow-hidden rounded-3xl border border-slate-800 group h-80 flex flex-col justify-end p-8 bg-slate-900">
                <img src="https://images.unsplash.com/photo-1547996160-71dfabb1d894?w=1000&auto=format&fit=crop&q=80" 
                    alt="Đồng hồ nam" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>
                
                <div class="relative z-10 space-y-2">
                    <span class="font-cinzel text-amber-400 text-xs uppercase tracking-widest font-semibold">Gentleman Collection</span>
                    <h3 class="text-2xl font-bold font-serif text-white">Đồng Hồ Nam Đẳng Cấp</h3>
                    <p class="text-xs text-slate-300 max-w-sm">Mạnh mẽ, chuẩn mực quý ông với các thiết kế bấm giờ thể thao Chronograph và máy cơ Automatic.</p>
                    <div class="pt-2">
                        <a href="{{ route('products.index', ['gender' => 'men']) }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-amber-400 hover:text-amber-300">
                            <span>Khám phá ngay</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Women's Collection Banner -->
            <div class="relative overflow-hidden rounded-3xl border border-slate-800 group h-80 flex flex-col justify-end p-8 bg-slate-900">
                <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=1000&auto=format&fit=crop&q=80" 
                    alt="Đồng hồ nữ" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>
                
                <div class="relative z-10 space-y-2">
                    <span class="font-cinzel text-amber-400 text-xs uppercase tracking-widest font-semibold">Lady Collection</span>
                    <h3 class="text-2xl font-bold font-serif text-white">Đồng Hồ Nữ Quý Phái</h3>
                    <p class="text-xs text-slate-300 max-w-sm">Thanh lịch và kiêu sa với mặt số khảm xà cừ thiên nhiên và viền đính đá quý tinh xảo.</p>
                    <div class="pt-2">
                        <a href="{{ route('products.index', ['gender' => 'women']) }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-amber-400 hover:text-amber-300">
                            <span>Khám phá ngay</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Craftsmanship & Quality Assurance -->
<section class="py-16 bg-slate-900/60 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <div class="space-y-6">
                <span class="font-cinzel text-amber-400 text-xs uppercase tracking-[0.3em] font-semibold">Tiêu Chuẩn Chế Tác</span>
                <h2 class="text-3xl sm:text-4xl font-serif font-bold text-white leading-tight">
                    Nghệ Thuật Đồng Hồ Cơ Khí <br>Và Quy Trình Kiểm Định Khắt Khe
                </h2>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Mỗi chiếc đồng hồ tại ChronoLux trước khi đến tay chủ nhân đều phải trải qua quy trình kiểm tra 6 bước nghiêm ngặt theo tiêu chuẩn của Hiệp hội Công nghiệp Đồng hồ Thụy Sĩ (FH).
                </p>

                <div class="space-y-4 pt-2">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 text-lg flex-shrink-0 mt-1">
                            <i class="fa-solid fa-compass-drafting"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-100 text-sm">Kiểm Tra Sai Số Bằng Máy Đo Vi Sai Điện Tử Witschi</h4>
                            <p class="text-xs text-slate-400 mt-0.5">Đảm bảo độ chính xác theo tiêu chuẩn Chronometer (-4/+6 giây/ngày hoặc cao hơn).</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 text-lg flex-shrink-0 mt-1">
                            <i class="fa-solid fa-water"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-100 text-sm">Thử Áp Suất Kháng Nước Chân Không</h4>
                            <p class="text-xs text-slate-400 mt-0.5">Kiểm định khả năng chịu nước thực tế trong buồng nén chuyên dụng đạt chuẩn ISO 6425.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 text-lg flex-shrink-0 mt-1">
                            <i class="fa-solid fa-file-shield"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-slate-100 text-sm">Thẻ Bảo Hành Điện Tử & Sổ Hãng Độc Quyền</h4>
                            <p class="text-xs text-slate-400 mt-0.5">Đầy đủ số Series number trùng khớp trên đồng hồ, nắp đáy và hệ thống tra cứu toàn cầu.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="rounded-3xl overflow-hidden border border-slate-800 shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=800&auto=format&fit=crop&q=80" 
                        alt="Horologist Workshop" class="w-full h-[450px] object-cover">
                </div>
                <div class="absolute -bottom-6 -left-6 bg-slate-900 border border-amber-500/40 rounded-2xl p-5 shadow-2xl max-w-xs hidden sm:block">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-medal text-amber-400 text-3xl"></i>
                        <div>
                            <div class="font-bold text-sm text-slate-100">Bảo Hành 5 Năm Vàng</div>
                            <div class="text-xs text-slate-400">Độc quyền duy nhất tại ChronoLux</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Customer Testimonials -->
<section class="py-16 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-12">
            <span class="font-cinzel text-xs font-semibold text-amber-400 uppercase tracking-[0.3em] mb-2 block">Khách Hàng Nói Về Chúng Tôi</span>
            <h2 class="text-3xl font-serif font-bold text-slate-100">Niềm Tin Từ Cộng Đồng Đam Mê Đồng Hồ</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($recentReviews->take(3) as $review)
                <div class="bg-slate-900/80 border border-slate-800 p-6 rounded-2xl relative flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-1 text-amber-400 text-sm mb-3">
                            @for($i = 1; $i <= $review->rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <p class="text-slate-300 text-xs italic leading-relaxed mb-4">
                            "{{ $review->comment }}"
                        </p>
                    </div>
                    <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between text-xs">
                        <div>
                            <div class="font-semibold text-slate-100">{{ $review->customer_name }}</div>
                            <div class="text-[10px] text-amber-400 flex items-center gap-1 mt-0.5">
                                <i class="fa-solid fa-circle-check"></i> Đã mua tại ChronoLux
                            </div>
                        </div>
                        @if($review->product)
                            <a href="{{ route('products.show', $review->product->slug) }}" class="text-[11px] text-slate-400 hover:text-amber-400 font-cinzel line-clamp-1 max-w-[120px]">
                                {{ $review->product->brand }}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Live Countdown Timer
    function startCountdown() {
        let hours = 8, minutes = 45, seconds = 20;
        setInterval(() => {
            if (seconds > 0) {
                seconds--;
            } else {
                seconds = 59;
                if (minutes > 0) {
                    minutes--;
                } else {
                    minutes = 59;
                    if (hours > 0) hours--;
                }
            }
            const h = document.getElementById('timer-hours');
            const m = document.getElementById('timer-minutes');
            const s = document.getElementById('timer-seconds');
            if (h && m && s) {
                h.textContent = String(hours).padStart(2, '0');
                m.textContent = String(minutes).padStart(2, '0');
                s.textContent = String(seconds).padStart(2, '0');
            }
        }, 1000);
    }
    startCountdown();
</script>
@endpush
