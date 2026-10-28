<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends BaseController
{
    // Hàm phụ trợ dùng chung: Lọc theo danh mục, từ khóa, kiểu dáng (Bó/Hộp/Giỏ), giá và đánh giá
    private function filterProducts(Request $request, $categoryName)
    {
        // 1. Tìm Category theo name hoặc slug với nhóm điều kiện chuẩn
        $category = Category::where(function ($q) use ($categoryName) {
            $q->where('name', 'like', '%' . $categoryName . '%')
                ->orWhere('slug', 'like', '%' . Str::slug($categoryName) . '%');
        })->first();

        $query = Product::query()->with(['reviews', 'category']);

        // 2. Lọc sản phẩm theo danh mục (nếu không thấy danh mục thì tìm theo tên hoa)
        if ($category) {
            $query->where('category_id', $category->id);
        } else {
            $query->where('name', 'like', '%' . $categoryName . '%');
        }

        // 3. Lọc theo từ khóa tìm kiếm (chỉ chạy khi thực sự nhập ký tự)
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . trim($request->keyword) . '%');
        }

        // 4. Lọc theo kiểu dáng (Bó, Hộp, Giỏ)
        if ($request->filled('style')) {
            $query->where('style', $request->style);
        }

        // 5. Lọc theo mức giá
        if ($request->filled('price_range')) {
            if ($request->price_range == 'under_500') {
                $query->where('price', '<', 500000);
            } elseif ($request->price_range == '500_1000') {
                $query->whereBetween('price', [500000, 1000000]);
            } elseif ($request->price_range == 'over_1000') {
                $query->where('price', '>', 1000000);
            }
        }

        // 6. Lọc theo sao đánh giá
        if ($request->filled('rating')) {
            $query->where('rating', '>=', (float) $request->rating);
        }

        // 7. Phân trang 12 sản phẩm và giữ nguyên các tham số lọc trên URL
        return $query->paginate(12)->withQueryString();
    }
    // Hàm hiển thị trang Tất cả sản phẩm kèm bộ lọc
    public function allProducts(Request $request)
    {
        $query = Product::with(['category', 'reviews']);

        // 1. Lọc theo từ khóa tìm kiếm
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('name', 'like', "%{$keyword}%");
        }

        // 2. Lọc theo danh mục (chọn nhiều hoặc một danh mục)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 3. Lọc theo kiểu dáng (Bó, Hộp, Giỏ)
        if ($request->filled('style')) {
            $query->where('style', $request->style);
        }

        // 4. Lọc theo mức giá
        if ($request->filled('price_range')) {
            switch ($request->price_range) {
                case 'under_500':
                    $query->where('price', '<', 500000);
                    break;
                case '500_1000':
                    $query->whereBetween('price', [500000, 1000000]);
                    break;
                case '1000_1500':
                    $query->whereBetween('price', [1000000, 1500000]);
                    break;
                case 'above_1500':
                    $query->where('price', '>', 1500000);
                    break;
            }
        }

        // 5. Sắp xếp (Sort)
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'rating_desc':
                    $query->orderBy('rating', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        // Phân trang 12 sản phẩm mỗi trang, giữ nguyên các tham số lọc khi chuyển trang
        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('shop.all-products', compact('products', 'categories'));
    }

    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::with(['category', 'reviews']);

        // Tìm kiếm theo tên sản phẩm, kiểu dáng và danh mục
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('style', 'like', '%' . $keyword . '%')
                    ->orWhereHas('category', function ($categoryQuery) use ($keyword) {
                        $categoryQuery->where(
                            'name',
                            'like',
                            '%' . $keyword . '%'
                        );
                    });
            });
        }


        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where(
                'category_id',
                $request->category_id
            );
        }

        // Lọc theo kiểu dáng
        if ($request->filled('style')) {
            $query->where(
                'style',
                $request->style
            );
        }

        // Lọc theo mức giá
        if ($request->filled('price_range')) {
            if ($request->price_range == 'under_500') {
                $query->where('price', '<', 500000);
            } elseif ($request->price_range == '500_1000') {
                $query->whereBetween(
                    'price',
                    [500000, 1000000]
                );
            } elseif ($request->price_range == 'over_1000') {
                $query->where('price', '>', 1000000);
            }
        }

        // Lọc theo đánh giá
        if ($request->filled('rating')) {
            $query->where(
                'rating',
                '>=',
                (float) $request->rating
            );
        }

        // Phân trang 12 sản phẩm
        $products = $query
            ->paginate(12)
            ->withQueryString();

        return view(
            'shop.index',
            compact('products', 'categories')
        );
    }

    // 1. Hoa Tình Yêu
    public function hoaTinhYeu(Request $request)
    {
        $products = $this->filterProducts($request, 'tình yêu');
        return view('shop.hoa-tinh-yeu', compact('products'));
    }

    // 2. Hoa Sinh Nhật
    public function hoaSinhNhat(Request $request)
    {
        $products = $this->filterProducts($request, 'sinh nhật');
        return view('shop.hoa-sinh-nhat', compact('products'));
    }

    // 3. Hoa Chúc Mừng
    public function hoaChucMung(Request $request)
    {
        $products = $this->filterProducts($request, 'chúc mừng');
        return view('shop.hoa-chuc-mung', compact('products'));
    }

    // 4. Hoa Khai Trương
    public function hoaKhaiTruong(Request $request)
    {
        $products = $this->filterProducts($request, 'khai trương');
        return view('shop.hoa-khai-truong', compact('products'));
    }

    // 5. Hoa Cưới
    public function hoaCuoi(Request $request)
    {
        $products = $this->filterProducts($request, 'cưới');
        return view('shop.hoa-cuoi', compact('products'));
    }

    // 6. Hoa Theo Mùa
    public function hoaTheoMua(Request $request)
    {
        $products = $this->filterProducts($request, 'mùa');
        return view('shop.hoa-theo-mua', compact('products'));
    }


    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        // Lấy toàn bộ bình luận của tất cả hoa
        $reviews = \App\Models\Review::with('user')
            ->latest()
            ->get();

        // Điểm trung bình của toàn bộ bình luận
        $averageRating = $reviews->count() > 0
            ? $reviews->avg('rating')
            : 0;

        return view('shop.detail', compact(
            'product',
            'reviews',
            'averageRating'
        ));
    }


    public function getProductJson($id)
    {
        $product = Product::with(['category', 'reviews'])->findOrFail($id);

        $imageUrl = Str::startsWith($product->image, 'http')
            ? $product->image
            : asset($product->image);

        // Tính giá sau giảm
        $discountPercent = (int) ($product->discount_percent ?? 0);
        $finalPrice = $discountPercent > 0
            ? $product->price * (1 - ($discountPercent / 100))
            : $product->price;


        $reviews = Review::with('user')->latest()->get();

        $reviewsData = $reviews->map(function ($rev) {
            return [
                'user_name' => $rev->user->name ?? 'Tài khoản đã xóa',
                'rating' => $rev->rating,
                'content' => $rev->content,
                'created_at' => $rev->created_at
                    ? $rev->created_at->format('d/m/Y H:i')
                    : ''
            ];
        });

        $averageRating = $reviews->count() > 0
            ? $reviews->avg('rating')
            : 0;


        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            // Cần có 3 trường này để Modal không bị lỗi undefined:
            'price' => number_format($finalPrice, 0, ',', '.') . 'đ',
            'final_price' => number_format($finalPrice, 0, ',', '.') . 'đ',
            'original_price' => number_format($product->price, 0, ',', '.') . 'đ',
            'discount_percent' => $discountPercent,
            'rating' => number_format($averageRating, 1),
            'image' => $imageUrl,
            'description' => $product->description,
            'category' => $product->category->name ?? 'Hoa tươi',
            'reviews' => $reviewsData,
            'reviews_count' => $reviews->count()
        ]);
    }
}