@extends('layouts.app')

@section('title', 'Bộ Sưu Tập Đồng Hồ Chính Hãng Cao Cấp | ChronoLux')

@section('content')

<!-- Header Banner -->
<div class="bg-slate-900 border-b border-slate-800 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs text-slate-400 mb-3 space-x-2">
            <a href="{{ route('home') }}" class="hover:text-amber-400 transition">Trang chủ</a>
            <span>/</span>
            <span class="text-amber-400 font-medium">Bộ sưu tập đồng hồ</span>
        </nav>
        <h1 class="text-3xl font-bold font-cinzel text-white">
            Bộ Sưu Tập Đồng Hồ Chính Hãng
        </h1>
        <p class="text-xs text-slate-400 mt-1">
            Tuyển chọn các mẫu đồng hồ Thụy Sĩ & Nhật Bản cao cấp được kiểm định nghiêm ngặt, bảo hành 5 năm toàn quốc.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar Filters -->
        <div class="lg:col-span-1">
            <form action="{{ route('products.index') }}" method="GET" class="bg-slate-900/90 border border-slate-800 rounded-2xl p-6 space-y-6 sticky top-28">
                
                @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif

                <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                    <h3 class="font-cinzel text-sm font-bold text-amber-400 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-filter text-xs"></i> Bộ Lọc Tìm Kiếm
                    </h3>
                    <a href="{{ route('products.index') }}" class="text-[11px] text-slate-400 hover:text-amber-400 transition">Xóa lọc</a>
                </div>

                <!-- Brand Filter -->
                <div>
                    <h4 class="text-xs font-semibold text-slate-200 uppercase tracking-wider mb-3">Thương hiệu</h4>
                    <div class="space-y-2 text-xs">
                        @foreach($brands as $b)
                            <label class="flex items-center gap-2.5 cursor-pointer text-slate-400 hover:text-slate-200">
                                <input type="radio" name="brand" value="{{ $b }}" {{ request('brand') == $b ? 'checked' : '' }} onchange="this.form.submit()"
                                    class="text-amber-500 focus:ring-amber-500 rounded bg-slate-950 border-slate-700">
                                <span>{{ $b }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Gender Filter -->
                <div class="pt-4 border-t border-slate-800">
                    <h4 class="text-xs font-semibold text-slate-200 uppercase tracking-wider mb-3">Đối tượng</h4>
                    <div class="space-y-2 text-xs">
                        <label class="flex items-center gap-2.5 cursor-pointer text-slate-400 hover:text-slate-200">
                            <input type="radio" name="gender" value="" {{ !request('gender') ? 'checked' : '' }} onchange="this.form.submit()" class="text-amber-500">
                            <span>Tất cả</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer text-slate-400 hover:text-slate-200">
                            <input type="radio" name="gender" value="men" {{ request('gender') == 'men' ? 'checked' : '' }} onchange="this.form.submit()" class="text-amber-500">
                            <span>Đồng hồ Nam</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer text-slate-400 hover:text-slate-200">
                            <input type="radio" name="gender" value="women" {{ request('gender') == 'women' ? 'checked' : '' }} onchange="this.form.submit()" class="text-amber-500">
                            <span>Đồng hồ Nữ</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer text-slate-400 hover:text-slate-200">
                            <input type="radio" name="gender" value="unisex" {{ request('gender') == 'unisex' ? 'checked' : '' }} onchange="this.form.submit()" class="text-amber-500">
                            <span>Unisex</span>
                        </label>
                    </div>
                </div>

                <!-- Movement Filter -->
                <div class="pt-4 border-t border-slate-800">
                    <h4 class="text-xs font-semibold text-slate-200 uppercase tracking-wider mb-3">Loại bộ máy</h4>
                    <div class="space-y-2 text-xs">
                        <label class="flex items-center gap-2.5 cursor-pointer text-slate-400 hover:text-slate-200">
                            <input type="radio" name="movement" value="" {{ !request('movement') ? 'checked' : '' }} onchange="this.form.submit()" class="text-amber-500">
                            <span>Tất cả máy</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer text-slate-400 hover:text-slate-200">
                            <input type="radio" name="movement" value="Automatic" {{ request('movement') == 'Automatic' ? 'checked' : '' }} onchange="this.form.submit()" class="text-amber-500">
                            <span>Cơ tự động (Automatic)</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer text-slate-400 hover:text-slate-200">
                            <input type="radio" name="movement" value="Quartz" {{ request('movement') == 'Quartz' ? 'checked' : '' }} onchange="this.form.submit()" class="text-amber-500">
                            <span>Máy Pin (Quartz)</span>
                        </label>
                        <label class="flex items-center gap-2.5 cursor-pointer text-slate-400 hover:text-slate-200">
                            <input type="radio" name="movement" value="Eco-Drive" {{ request('movement') == 'Eco-Drive' ? 'checked' : '' }} onchange="this.form.submit()" class="text-amber-500">
                            <span>Năng lượng ánh sáng (Solar)</span>
                        </label>
                    </div>
                </div>

                <!-- Price Range Quick Filters -->
                <div class="pt-4 border-t border-slate-800">
                    <h4 class="text-xs font-semibold text-slate-200 uppercase tracking-wider mb-3">Khoảng giá</h4>
                    <div class="space-y-2 text-xs">
                        <label class="flex items-center gap-2.5 cursor-pointer text-slate-400 hover:text-slate-200">
                            <input type="radio" name="price_range" value="" {{ !request('min_price') && !request('max_price') ? 'checked' : '' }} 
                                onclick="window.location.href='{{ route('products.index', array_merge(request()->except(['min_price', 'max_price']))) }}'" class="text-amber-500">
                            <span>Tất cả mức giá</span>
                        </label>
                        <a href="{{ route('products.index', array_merge(request()->except(['min_price', 'max_price']), ['max_price' => 15000000])) }}" 
                           class="block py-1 hover:text-amber-400 {{ request('max_price') == 15000000 ? 'text-amber-400 font-semibold' : 'text-slate-400' }}">
                            Dưới 15 triệu
                        </a>
                        <a href="{{ route('products.index', array_merge(request()->except(['min_price', 'max_price']), ['min_price' => 15000000, 'max_price' => 100000000])) }}" 
                           class="block py-1 hover:text-amber-400 {{ request('min_price') == 15000000 ? 'text-amber-400 font-semibold' : 'text-slate-400' }}">
                            15 triệu - 100 triệu
                        </a>
                        <a href="{{ route('products.index', array_merge(request()->except(['min_price', 'max_price']), ['min_price' => 100000000, 'max_price' => 300000000])) }}" 
                           class="block py-1 hover:text-amber-400 {{ request('min_price') == 100000000 ? 'text-amber-400 font-semibold' : 'text-slate-400' }}">
                            100 triệu - 300 triệu
                        </a>
                        <a href="{{ route('products.index', array_merge(request()->except(['min_price', 'max_price']), ['min_price' => 300000000])) }}" 
                           class="block py-1 hover:text-amber-400 {{ request('min_price') == 300000000 ? 'text-amber-400 font-semibold' : 'text-slate-400' }}">
                            Trên 300 triệu (Xa xỉ)
                        </a>
                    </div>
                </div>

            </form>
        </div>

        <!-- Product Grid Main Area -->
        <div class="lg:col-span-3 space-y-6">
            
            <!-- Top Controls -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-900/60 border border-slate-800 p-4 rounded-2xl">
                <div class="text-xs text-slate-400">
                    Tìm thấy <span class="text-amber-400 font-bold">{{ $products->total() }}</span> mẫu đồng hồ phù hợp
                    @if(request('q'))
                        với từ khóa "<span class="text-white font-semibold">{{ request('q') }}</span>"
                    @endif
                </div>

                <!-- Sort dropdown -->
                <form action="{{ route('products.index') }}" method="GET" class="flex items-center gap-2 text-xs">
                    @foreach(request()->except('sort') as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <label class="text-slate-400 whitespace-nowrap">Sắp xếp theo:</label>
                    <select name="sort" onchange="this.form.submit()" 
                        class="bg-slate-950 border border-slate-700 rounded-lg px-3 py-1.5 text-slate-200 focus:outline-none focus:border-amber-500 text-xs">
                        <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Nổi bật nhất</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                        <option value="best_seller" {{ request('sort') == 'best_seller' ? 'selected' : '' }}>Bán chạy nhất</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới nhất</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Đánh giá cao</option>
                    </select>
                </form>
            </div>

            <!-- Products Grid -->
            @if($products->isEmpty())
                <div class="bg-slate-900/40 border border-slate-800 rounded-2xl p-12 text-center space-y-4">
                    <div class="w-16 h-16 rounded-full bg-slate-800 text-slate-400 flex items-center justify-center mx-auto text-2xl">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-200">Không tìm thấy mẫu đồng hồ phù hợp</h3>
                    <p class="text-xs text-slate-400 max-w-sm mx-auto">Vui lòng thử thay đổi các tiêu chí lọc hoặc tìm kiếm bằng từ khóa khác.</p>
                    <div>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-amber-500 text-slate-950 font-bold text-xs uppercase">
                            Xem tất cả đồng hồ
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="bg-slate-900 rounded-2xl border border-slate-800 hover:border-amber-500/50 p-4 transition duration-300 flex flex-col justify-between group shadow-xl hover:-translate-y-1">
                            <div>
                                <!-- Image Box -->
                                <div class="relative overflow-hidden rounded-xl bg-slate-950 p-3 mb-4">
                                    <span class="absolute top-2 right-2 bg-slate-900/90 text-slate-300 text-[10px] px-2 py-0.5 rounded border border-slate-700">
                                        {{ $product->dial_size }}
                                    </span>
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}" 
                                            class="w-full h-56 object-cover rounded-lg group-hover:scale-108 transition duration-500">
                                    </a>
                                </div>

                                <!-- Brand & SKU -->
                                <div class="flex items-center justify-between text-xs mb-1">
                                    <span class="font-cinzel text-amber-400 font-bold uppercase tracking-wider">{{ $product->brand }}</span>
                                    <span class="text-slate-400 text-[10px]">{{ $product->sku }}</span>
                                </div>

                                <!-- Product Title -->
                                <h3 class="font-semibold text-sm text-slate-100 hover:text-amber-400 transition line-clamp-2">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>

                                <!-- Specs tags -->
                                <div class="flex flex-wrap items-center gap-1.5 my-2 text-[10px] text-slate-400">
                                    <span class="bg-slate-950 px-2 py-0.5 rounded border border-slate-800"><i class="fa-solid fa-gears text-amber-400 mr-1"></i>{{ $product->movement }}</span>
                                    <span class="bg-slate-950 px-2 py-0.5 rounded border border-slate-800"><i class="fa-solid fa-shield text-amber-400 mr-1"></i>{{ $product->glass_type }}</span>
                                </div>

                                <!-- Price -->
                                <div class="mt-3">
                                    <div class="text-lg font-bold text-amber-400">{{ $product->formatted_price }}</div>
                                    @if($product->formatted_original_price)
                                        <div class="text-xs text-slate-400 line-through">{{ $product->formatted_original_price }}</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Buttons: Khách hàng (Thêm giỏ bé lại + Mua + Xem) | Admin (Quản lý kho) -->
                            <div class="mt-4 pt-3 border-t border-slate-800 flex items-center gap-1.5">
                                @if(Auth::check() && Auth::user()->isAdmin())
                                    <div class="flex-1 px-3 py-2 rounded-xl bg-slate-900 border border-slate-800 text-amber-400 font-bold text-xs flex items-center justify-between">
                                        <span><i class="fa-solid fa-boxes-stacked mr-1"></i> Kho:</span>
                                        <span class="text-white">{{ $product->stock }}</span>
                                    </div>
                                    <a href="{{ route('products.show', $product->slug) }}" class="w-10 h-10 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold flex items-center justify-center text-sm transition" title="Xem chi tiết & quản lý">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                @else
                                    <!-- Nút Thêm vào giỏ (Thu bé lại) -->
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="px-2.5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-amber-400 hover:text-white border border-slate-700 font-semibold text-xs transition flex items-center justify-center gap-1 cursor-pointer" title="Thêm vào giỏ hàng">
                                            <i class="fa-solid fa-cart-plus text-xs"></i>
                                            <span class="text-[11px]">Giỏ</span>
                                        </button>
                                    </form>

                                    <!-- Nút Mua (Mua ngay bên cạnh) -->
                                    <a href="{{ route('buy.now', $product->id) }}" class="flex-1 py-2.5 px-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-bold text-xs uppercase tracking-wider transition text-center flex items-center justify-center gap-1 shadow cursor-pointer">
                                        <i class="fa-solid fa-bolt text-xs"></i>
                                        <span>Mua</span>
                                    </a>

                                    <!-- Nút Xem chi tiết -->
                                    <a href="{{ route('products.show', $product->slug) }}" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white flex items-center justify-center text-xs transition border border-slate-700 cursor-pointer" title="Xem chi tiết">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="pt-8">
                    {{ $products->links() }}
                </div>
            @endif

        </div>

    </div>
</div>

@endsection
