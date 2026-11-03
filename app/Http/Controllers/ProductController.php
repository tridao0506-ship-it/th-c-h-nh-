<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search
        if ($request->filled('q')) {
            $q = trim($request->input('q'));
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('movement', 'like', "%{$q}%");
            });
        }

        // Category / Brand filter
        if ($request->filled('brand')) {
            $query->where('brand', $request->input('brand'));
        } elseif ($request->filled('category')) {
            $catSlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($catSlug) {
                $q->where('slug', $catSlug);
            });
        }

        // Gender filter
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        // Movement filter
        if ($request->filled('movement')) {
            $query->where('movement', 'like', '%' . $request->input('movement') . '%');
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        // Sorting
        $sort = $request->input('sort', 'featured');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'newest' => $query->latest(),
            'best_seller' => $query->orderBy('sold_count', 'desc'),
            'rating' => $query->orderBy('rating', 'desc'),
            default => $query->orderBy('is_featured', 'desc')->latest()
        };

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('products')->get();
        $brands = Product::select('brand')->distinct()->pluck('brand');

        return view('pages.products.index', compact('products', 'categories', 'brands'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['category', 'reviews'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('pages.products.show', compact('product', 'relatedProducts'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'movement' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|string|url',
            'image_url' => 'nullable|string|url',
        ]);

        // Cập nhật các trường thông tin cơ bản
        $product->name = $validated['name'];
        $product->brand = $validated['brand'];
        $product->movement = $validated['movement'] ?? $product->movement;
        $product->price = $validated['price'];
        $product->original_price = $validated['original_price'] ?? $product->original_price;
        $product->stock = $validated['stock'];

        // Ưu tiên lấy link ảnh từ trường image_url hoặc image gửi lên từ form modal
        $imageUrl = $request->input('image_url') ?? $request->input('image');
        if ($imageUrl) {
            // Kiểm tra xem cột trong DB của bạn là image hay image_url để gán
            if (\Schema::hasColumn('products', 'image_url')) {
                $product->image_url = $imageUrl;
            } else {
                $product->image = $imageUrl;
            }
        }

        $product->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thông tin đồng hồ thành công!',
                'product' => $product,
            ]);
        }

        return back()->with('success', 'Cập nhật thông tin đồng hồ thành công!');
    }

    public function storeReview(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        $product->reviews()->create([
            'customer_name' => $validated['customer_name'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'is_verified_buyer' => true,
        ]);

        // Recalculate average rating
        $avg = $product->reviews()->avg('rating') ?: 5.0;
        $count = $product->reviews()->count();

        $product->update([
            'rating' => round($avg, 1),
            'reviews_count' => $count,
        ]);

        return back()->with('success', 'Cảm ơn bạn đã gửi đánh giá! Nhận xét của bạn giúp ích rất nhiều cho cộng đồng yêu đồng hồ.');
    }
}
