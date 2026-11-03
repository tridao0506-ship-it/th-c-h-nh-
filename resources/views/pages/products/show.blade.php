@extends('layouts.app')

@section('title', $product->name . ' - ChronoLux Chính Hãng')

@section('content')
<script>
    window.currentWatchProductId = {{ $product->id }};
</script>

<!-- Breadcrumb -->
<div class="bg-slate-900 border-b border-slate-800 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs text-slate-400 space-x-2">
            <a href="{{ route('home') }}" class="hover:text-amber-400 transition">Trang chủ</a>
            <span>/</span>
            <a href="{{ route('products.index') }}" class="hover:text-amber-400 transition">Đồng hồ</a>
            <span>/</span>
            <a href="{{ route('products.index', ['brand' => $product->brand]) }}" class="hover:text-amber-400 transition">{{ $product->brand }}</a>
            <span>/</span>
            <span class="text-amber-400 font-medium line-clamp-1">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        
        <!-- Left: Image Gallery -->
        <div class="lg:col-span-6 space-y-4">
            <!-- Main Large Image -->
            <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 text-center relative overflow-hidden group">
                <span class="absolute top-4 right-4 bg-slate-950 text-amber-400 border border-amber-500/30 text-xs font-medium px-3 py-1 rounded-full z-10">
                    <i class="fa-solid fa-crown text-[10px] mr-1"></i> {{ $product->origin }}
                </span>
                
                <img id="main-product-image" src="{{ $product->image }}" alt="{{ $product->name }}" 
                    class="w-full h-96 sm:h-[450px] object-contain mx-auto rounded-2xl group-hover:scale-105 transition duration-500">
            </div>

            <!-- Thumbnails -->
            <div class="flex items-center gap-3 overflow-x-auto pb-2">
                <button onclick="changeImage('{{ $product->image }}')" class="thumbnail-btn w-20 h-20 rounded-xl bg-slate-900 border-2 border-amber-500 p-1 flex-shrink-0 focus:outline-none">
                    <img src="{{ $product->image }}" class="w-full h-full object-cover rounded-lg">
                </button>
                @if($product->gallery && is_array($product->gallery))
                    @foreach($product->gallery as $galImg)
                        <button onclick="changeImage('{{ $galImg }}')" class="thumbnail-btn w-20 h-20 rounded-xl bg-slate-900 border border-slate-800 hover:border-amber-500/50 p-1 flex-shrink-0 focus:outline-none transition">
                            <img src="{{ $galImg }}" class="w-full h-full object-cover rounded-lg">
                        </button>
                    @endforeach
                @endif
            </div>

            <!-- Trust Badges -->
            <div class="grid grid-cols-2 gap-3 pt-4">
                <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800 flex items-center gap-3 text-xs">
                    <i class="fa-solid fa-certificate text-amber-400 text-lg"></i>
                    <div>
                        <div class="font-bold text-slate-200">100% Chính Hãng</div>
                        <div class="text-[11px] text-slate-400">Đền 10 lần nếu phát hiện fake</div>
                    </div>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800 flex items-center gap-3 text-xs">
                    <i class="fa-solid fa-shield-halved text-amber-400 text-lg"></i>
                    <div>
                        <div class="font-bold text-slate-200">Bảo Hành {{ $product->warranty_years }} Năm Vàng</div>
                        <div class="text-[11px] text-slate-400">Bao gồm cả lỗi người dùng</div>
                    </div>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800 flex items-center gap-3 text-xs">
                    <i class="fa-solid fa-truck-fast text-amber-400 text-lg"></i>
                    <div>
                        <div class="font-bold text-slate-200">Giao Hỏa Tốc Miễn Phí</div>
                        <div class="text-[11px] text-slate-400">Kiểm tra đồng hồ trước trả tiền</div>
                    </div>
                </div>
                <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800 flex items-center gap-3 text-xs">
                    <i class="fa-solid fa-repeat text-amber-400 text-lg"></i>
                    <div>
                        <div class="font-bold text-slate-200">Đổi Mới 30 Ngày</div>
                        <div class="text-[11px] text-slate-400">Thủ tục nhanh chóng trong 15p</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Product Info & Purchase Options -->
        <div class="lg:col-span-6 space-y-6">
            
            <div>
                <a href="{{ route('products.index', ['brand' => $product->brand]) }}" class="font-cinzel text-amber-400 font-bold uppercase tracking-widest text-xs hover:underline">
                    {{ $product->brand }}
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold font-serif text-white mt-1 leading-snug">
                    {{ $product->name }}
                </h1>
                
                <div class="flex flex-wrap items-center gap-4 text-xs mt-3 text-slate-400">
                    <div class="flex items-center gap-1 text-amber-400">
                        <i class="fa-solid fa-star"></i>
                        <span class="font-bold ml-0.5">{{ $product->rating }}</span>
                    </div>
                    <span>•</span>
                    <a href="#reviews-section" class="hover:text-amber-400 transition underline underline-offset-4">
                        {{ $product->reviews_count }} Đánh giá từ khách hàng
                    </a>
                    <span>•</span>
                    <span>Mã SP: <strong class="text-slate-200">{{ $product->sku }}</strong></span>
                    <span>•</span>
                    <span class="text-emerald-400 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-check"></i> Còn hàng ({{ $product->stock }} chiếc)
                    </span>
                </div>
            </div>

            <!-- Price Card -->
            <div class="bg-slate-900/80 border border-slate-800 rounded-2xl p-5">
                <div class="flex items-baseline gap-4">
                    <span class="text-3xl sm:text-4xl font-bold text-amber-400">{{ $product->formatted_price }}</span>
                    @if($product->formatted_original_price)
                        <span class="text-base text-slate-400 line-through">{{ $product->formatted_original_price }}</span>
                    @endif
                </div>
                <div class="mt-2 text-xs text-slate-400 flex items-center gap-2">
                    <i class="fa-solid fa-tags text-amber-400"></i>
                    <span>Giá đã bao gồm VAT và miễn phí vận chuyển bảo hiểm toàn quốc.</span>
                </div>
            </div>

            <!-- Quick Specs highlights -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center text-xs">
                <div class="bg-slate-900 border border-slate-800 p-3 rounded-xl">
                    <div class="text-slate-400 text-[10px] uppercase">Bộ máy</div>
                    <div class="font-bold text-slate-200 mt-1 line-clamp-1">{{ $product->movement }}</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-3 rounded-xl">
                    <div class="text-slate-400 text-[10px] uppercase">Đường kính</div>
                    <div class="font-bold text-slate-200 mt-1">{{ $product->dial_size }}</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-3 rounded-xl">
                    <div class="text-slate-400 text-[10px] uppercase">Chống nước</div>
                    <div class="font-bold text-slate-200 mt-1">{{ $product->water_resistance }}</div>
                </div>
                <div class="bg-slate-900 border border-slate-800 p-3 rounded-xl">
                    <div class="text-slate-400 text-[10px] uppercase">Kính</div>
                    <div class="font-bold text-slate-200 mt-1 line-clamp-1">{{ $product->glass_type }}</div>
                </div>
            </div>

            <!-- Short description -->
            @if($product->short_description)
                <p class="text-slate-300 text-sm leading-relaxed border-l-2 border-amber-500 pl-4 py-1">
                    {{ $product->short_description }}
                </p>
            @endif

            <!-- Purchase Form (Khách hàng) vs Admin Management Action (Admin) -->
            @if(Auth::check() && Auth::user()->isAdmin())
                <div class="p-5 rounded-2xl bg-amber-950/30 border border-amber-500/40 space-y-4">
                    <div class="flex items-center gap-2 text-amber-400 font-bold text-sm">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Khu Vực Quản Lý Của Quản Trị Viên (Admin)</span>
                    </div>
                    <p class="text-xs text-slate-300">
                        Tài khoản Quản trị viên chỉ quản lý sản phẩm, tồn kho và danh mục. Không có tính năng đặt mua hàng và giỏ hàng.
                    </p>

                    <div class="flex flex-wrap items-center gap-3 pt-1">
                        <form action="{{ route('admin.products.stock', $product->id) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            <span class="text-xs text-slate-300 font-semibold">Tồn kho:</span>
                            <input type="number" name="stock" value="{{ $product->stock }}" min="0" class="w-20 bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white font-bold text-center">
                            <button type="submit" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition">
                                Lưu tồn kho
                            </button>
                        </form>

                        <a href="{{ url('/?view=admin&admin_tab=products#admin-section') }}" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase flex items-center gap-1.5 transition">
                            <i class="fa-solid fa-shirt"></i>
                            <span>Về SHOP ADMIN Quản Lý</span>
                        </a>
                    </div>
                </div>
            @else
                <form action="{{ route('cart.add') }}" method="POST" class="space-y-4 pt-2">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="flex items-center gap-4">
                        <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Số lượng:</label>
                        <div class="flex items-center bg-slate-900 border border-slate-700 rounded-xl overflow-hidden">
                            <button type="button" onclick="decrementQty()" class="px-4 py-2 text-slate-400 hover:text-white hover:bg-slate-800 transition">
                                <i class="fa-solid fa-minus text-xs"></i>
                            </button>
                            <input type="number" id="purchase-qty" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                class="w-14 text-center bg-transparent text-white font-bold text-sm focus:outline-none">
                            <button type="button" onclick="incrementQty()" class="px-4 py-2 text-slate-400 hover:text-white hover:bg-slate-800 transition">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                        <button type="submit" class="w-full py-4 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-sm uppercase tracking-wider transition duration-200 flex items-center justify-center gap-2 shadow-lg shadow-amber-500/20">
                            <i class="fa-solid fa-cart-plus text-base"></i>
                            <span>Thêm Vào Giỏ Hàng</span>
                        </button>
                        
                        <button type="submit" formaction="{{ route('cart.add') }}?redirect_to=checkout" class="w-full py-4 rounded-xl border-2 border-amber-500 bg-amber-500/10 hover:bg-amber-500 text-amber-400 hover:text-slate-950 font-bold text-sm uppercase tracking-wider transition duration-200 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-bolt text-base"></i>
                            <span>Mua Ngay Trả Sau 0%</span>
                        </button>
                    </div>
                </form>
            @endif

            <!-- Hotline Consultation Box -->
            <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800 flex items-center justify-between text-xs">
                <div>
                    <div class="font-semibold text-slate-200">Cần tư vấn trực tiếp về mẫu đồng hồ này?</div>
                    <div class="text-slate-400 mt-0.5">Chuyên gia đồng hồ ChronoLux sẵn sàng giải đáp 24/7</div>
                </div>
                <a href="tel:19008888" class="px-4 py-2 rounded-lg bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-amber-400 font-bold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-phone"></i>
                    <span>1900 8888</span>
                </a>
            </div>

        </div>

    </div>

    <!-- Details, Specifications & Reviews Tabs -->
    <div class="mt-16 pt-10 border-t border-slate-800">
        
        <div class="flex border-b border-slate-800 space-x-8 text-sm font-semibold uppercase tracking-wider">
            <button onclick="switchTab('specs')" id="tab-specs-btn" class="tab-btn pb-4 border-b-2 border-amber-500 text-amber-400 font-bold">
                Thông Số Kỹ Thuật
            </button>
            <button onclick="switchTab('description')" id="tab-desc-btn" class="tab-btn pb-4 border-b-2 border-transparent text-slate-400 hover:text-slate-200">
                Mô Tả Chi Tiết
            </button>
            <button onclick="switchTab('reviews')" id="tab-reviews-btn" class="tab-btn pb-4 border-b-2 border-transparent text-slate-400 hover:text-slate-200">
                Đánh Giá ({{ $product->reviews_count }})
            </button>
        </div>

        <!-- Tab 1: Specifications Table -->
        <div id="tab-specs" class="tab-content py-8">
            <div class="max-w-3xl">
                <table class="w-full text-xs text-left border border-slate-800 divide-y divide-slate-800 rounded-2xl overflow-hidden">
                    <tbody class="divide-y divide-slate-800">
                        <tr class="bg-slate-900/50">
                            <td class="px-6 py-3.5 font-semibold text-slate-400 w-1/3">Thương hiệu</td>
                            <td class="px-6 py-3.5 font-bold text-amber-400 font-cinzel">{{ $product->brand }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3.5 font-semibold text-slate-400">Mã sản phẩm (SKU)</td>
                            <td class="px-6 py-3.5 text-slate-200">{{ $product->sku }}</td>
                        </tr>
                        <tr class="bg-slate-900/50">
                            <td class="px-6 py-3.5 font-semibold text-slate-400">Xuất xứ</td>
                            <td class="px-6 py-3.5 text-slate-200">{{ $product->origin }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3.5 font-semibold text-slate-400">Dòng sản phẩm</td>
                            <td class="px-6 py-3.5 text-slate-200">{{ $product->gender_label }}</td>
                        </tr>
                        <tr class="bg-slate-900/50">
                            <td class="px-6 py-3.5 font-semibold text-slate-400">Loại bộ máy</td>
                            <td class="px-6 py-3.5 text-slate-200 font-medium">{{ $product->movement }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3.5 font-semibold text-slate-400">Đường kính mặt số</td>
                            <td class="px-6 py-3.5 text-slate-200">{{ $product->dial_size }}</td>
                        </tr>
                        <tr class="bg-slate-900/50">
                            <td class="px-6 py-3.5 font-semibold text-slate-400">Mặt kính</td>
                            <td class="px-6 py-3.5 text-slate-200">{{ $product->glass_type }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3.5 font-semibold text-slate-400">Chất liệu vỏ</td>
                            <td class="px-6 py-3.5 text-slate-200">{{ $product->case_material }}</td>
                        </tr>
                        <tr class="bg-slate-900/50">
                            <td class="px-6 py-3.5 font-semibold text-slate-400">Chất liệu dây đeo</td>
                            <td class="px-6 py-3.5 text-slate-200">{{ $product->strap_material }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3.5 font-semibold text-slate-400">Độ chịu nước</td>
                            <td class="px-6 py-3.5 text-slate-200">{{ $product->water_resistance }}</td>
                        </tr>
                        <tr class="bg-slate-900/50">
                            <td class="px-6 py-3.5 font-semibold text-slate-400">Thời gian trữ cót / Pin</td>
                            <td class="px-6 py-3.5 text-slate-200">{{ $product->power_reserve ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3.5 font-semibold text-slate-400">Chế độ bảo hành</td>
                            <td class="px-6 py-3.5 text-emerald-400 font-bold">{{ $product->warranty_years }} năm toàn diện tại ChronoLux</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab 2: Detailed Description -->
        <div id="tab-description" class="tab-content py-8 hidden max-w-4xl space-y-4 text-slate-300 text-sm leading-relaxed">
            <h3 class="text-xl font-bold font-serif text-white">Nghệ thuật chế tác và nguồn cảm hứng</h3>
            <p>{{ $product->description }}</p>
            <p>
                Toàn bộ sản phẩm được phân phối bởi ChronoLux đều đi kèm đầy đủ hộp gỗ chính hãng, thẻ bảo hành điện tử quốc tế có mã số định danh trùng khớp với thân vỏ đồng hồ, sách hướng dẫn sử dụng và chứng nhận thẩm định của ChronoLux Master Watchmakers.
            </p>
        </div>

        <!-- Tab 3: Reviews -->
        <div id="tab-reviews" class="tab-content py-8 hidden max-w-4xl space-y-8" id="reviews-section">
            
            <!-- List of existing reviews -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold font-serif text-white">Đánh giá từ khách hàng đã mua ({{ $product->reviews->count() }})</h3>
                
                @forelse($product->reviews as $rev)
                    <div class="bg-slate-900/60 border border-slate-800 p-5 rounded-2xl space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-100">{{ $rev->customer_name }}</span>
                                @if($rev->is_verified_buyer)
                                    <span class="text-emerald-400 text-[10px] bg-emerald-950/60 border border-emerald-800/80 px-2 py-0.5 rounded-full flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check"></i> Đã mua tại ChronoLux
                                    </span>
                                @endif
                            </div>
                            <span class="text-slate-400">{{ $rev->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex text-amber-400 text-xs">
                            @for($i = 1; $i <= $rev->rating; $i++)
                                <i class="fa-solid fa-star"></i>
                            @endfor
                        </div>
                        <p class="text-slate-300 text-xs leading-relaxed">
                            {{ $rev->comment }}
                        </p>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic">Chưa có đánh giá nào cho sản phẩm này. Hãy là người đầu tiên trải nghiệm và để lại nhận xét!</p>
                @endforelse
            </div>

            <!-- Submit a new Review Form -->
            <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl">
                <h4 class="text-base font-bold text-white mb-4">Gửi nhận xét của bạn về chiếc đồng hồ này</h4>
                <form action="{{ route('products.review', $product->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-slate-300 mb-1">Họ tên của bạn *</label>
                            <input type="text" name="customer_name" required placeholder="Nguyễn Văn A" 
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs text-slate-300 mb-1">Đánh giá số sao *</label>
                            <select name="rating" required class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500">
                                <option value="5">⭐⭐⭐⭐⭐ (5/5 Sao - Tuyệt vời)</option>
                                <option value="4">⭐⭐⭐⭐ (4/5 Sao - Rất hài lòng)</option>
                                <option value="3">⭐⭐⭐ (3/5 Sao - Bình thường)</option>
                                <option value="2">⭐⭐ (2/5 Sao - Cần cải thiện)</option>
                                <option value="1">⭐ (1/5 Sao - Không hài lòng)</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-300 mb-1">Cảm nhận chi tiết của bạn *</label>
                        <textarea name="comment" rows="3" required placeholder="Chia sẻ cảm giác đeo lên tay, độ hoàn thiện, độ chuẩn giờ..." 
                            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-2.5 text-xs text-white focus:outline-none focus:border-amber-500"></textarea>
                    </div>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition">
                        Gửi Đánh Giá Ngay
                    </button>
                </form>
            </div>

        </div>

    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div class="mt-20 pt-10 border-t border-slate-800">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="font-cinzel text-amber-400 text-xs uppercase tracking-widest font-semibold">Cùng Phân Khúc</span>
                    <h3 class="text-2xl font-serif font-bold text-white mt-1">Đồng Hồ Cùng Thương Hiệu {{ $product->brand }}</h3>
                </div>
                <a href="{{ route('products.index', ['brand' => $product->brand]) }}" class="text-xs uppercase text-amber-400 font-semibold hover:text-amber-300">
                    Xem tất cả <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <div class="bg-slate-900 rounded-2xl border border-slate-800 hover:border-amber-500/50 p-4 transition duration-300 flex flex-col justify-between group shadow-xl">
                        <div>
                            <div class="relative overflow-hidden rounded-xl bg-slate-950 p-3 mb-4">
                                <a href="{{ route('products.show', $rel->slug) }}">
                                    <img src="{{ $rel->image }}" alt="{{ $rel->name }}" class="w-full h-48 object-cover rounded-lg group-hover:scale-108 transition duration-500">
                                </a>
                            </div>
                            <span class="font-cinzel text-amber-400 text-[10px] font-bold uppercase">{{ $rel->brand }}</span>
                            <h4 class="font-semibold text-xs text-slate-100 hover:text-amber-400 transition line-clamp-2 mt-1">
                                <a href="{{ route('products.show', $rel->slug) }}">{{ $rel->name }}</a>
                            </h4>
                            <div class="mt-2 text-base font-bold text-amber-400">{{ $rel->formatted_price }}</div>
                        </div>
                        <div class="mt-3 pt-3 border-t border-slate-800">
                            <a href="{{ route('products.show', $rel->slug) }}" class="block w-full text-center py-2 rounded-xl bg-slate-800 hover:bg-amber-500 hover:text-slate-950 text-slate-200 text-xs font-semibold transition">
                                Chi tiết
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
    function changeImage(src) {
        document.getElementById('main-product-image').src = src;
    }

    function incrementQty() {
        const input = document.getElementById('purchase-qty');
        const max = parseInt(input.getAttribute('max') || '99');
        let val = parseInt(input.value || '1');
        if (val < max) input.value = val + 1;
    }

    function decrementQty() {
        const input = document.getElementById('purchase-qty');
        let val = parseInt(input.value || '1');
        if (val > 1) input.value = val - 1;
    }

    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('border-amber-500', 'text-amber-400', 'font-bold');
            btn.classList.add('border-transparent', 'text-slate-400');
        });

        document.getElementById('tab-' + tabId).classList.remove('hidden');
        const activeBtn = document.getElementById('tab-' + (tabId === 'description' ? 'desc' : tabId) + '-btn');
        if (activeBtn) {
            activeBtn.classList.add('border-amber-500', 'text-amber-400', 'font-bold');
            activeBtn.classList.remove('border-transparent', 'text-slate-400');
        }
    }
</script>
@endpush
