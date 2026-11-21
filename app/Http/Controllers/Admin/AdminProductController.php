<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Danh sách sản phẩm hoa kèm tìm kiếm & phân trang (Eloquent ORM)
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Tìm kiếm theo tên sản phẩm
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo kiểu dáng (giỏ, bó, hộp)
        if ($request->filled('style')) {
            $query->where('style', $request->style);
        }

        $products = $query->latest('id')->paginate(10)->withQueryString();
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Form thêm hoa mới
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Lưu hoa mới vào CSDL
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'price'            => 'required|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'style'            => 'nullable|in:gio,bo,hop',
            'description'      => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'name.required'        => 'Vui lòng nhập tên sản phẩm hoa.',
            'category_id.required' => 'Vui lòng chọn danh mục hoa.',
            'category_id.exists'   => 'Danh mục không tồn tại.',
            'price.required'       => 'Vui lòng nhập giá bán.',
            'price.numeric'        => 'Giá bán phải là số hợp lệ.',
            'discount_percent.max' => 'Phần trăm giảm giá tối đa là 100%.',
            'image.image'          => 'Tệp tải lên phải là hình ảnh hợp lệ.',
            'image.max'            => 'Kích thước ảnh tối đa là 5MB.',
        ]);

        // Tạo Slug duy nhất
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        // Xử lý upload ảnh
        $imagePath = 'images/about-flower.jpg';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        Product::create([
            'category_id'      => $validated['category_id'],
            'name'             => $validated['name'],
            'slug'             => $slug,
            'price'            => $validated['price'],
            'discount_percent' => $validated['discount_percent'] ?? 0,
            'style'            => $validated['style'] ?? null,
            'image'            => $imagePath,
            'description'      => isset($validated['description']) ? trim(strip_tags($validated['description'])) : null,
            'rating'           => 5.0,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Thêm mới sản phẩm hoa thành công!');
    }

    /**
     * Form chỉnh sửa hoa
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Cập nhật thông tin hoa
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'category_id'      => 'required|exists:categories,id',
            'price'            => 'required|numeric|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'style'            => 'nullable|in:gio,bo,hop',
            'description'      => 'nullable|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'name.required'        => 'Vui lòng nhập tên sản phẩm hoa.',
            'category_id.required' => 'Vui lòng chọn danh mục hoa.',
            'price.required'       => 'Vui lòng nhập giá bán.',
            'price.numeric'        => 'Giá bán phải là số hợp lệ.',
            'discount_percent.max' => 'Phần trăm giảm giá tối đa là 100%.',
            'image.image'          => 'Tệp tải lên phải là hình ảnh hợp lệ.',
        ]);

        // Cập nhật Slug nếu tên thay đổi
        if ($validated['name'] !== $product->name) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            $product->slug = $slug;
        }

        // Xử lý upload ảnh mới
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
            $product->image = 'images/' . $imageName;
        }

        $product->category_id      = $validated['category_id'];
        $product->name             = $validated['name'];
        $product->price            = $validated['price'];
        $product->discount_percent = $validated['discount_percent'] ?? 0;
        $product->style            = $validated['style'] ?? null;
        $product->description      = isset($validated['description']) ? trim(strip_tags($validated['description'])) : null;
        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', "Cập nhật sản phẩm '{$product->name}' thành công!");
    }

    /**
     * Xóa sản phẩm hoa
     */
    public function destroy($id)
    {
        $product = Product::withCount('orderDetails')->findOrFail($id);

        if ($product->order_details_count > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', "Không thể xóa hoa '{$product->name}' vì đã có {$product->order_details_count} đơn hàng chứa sản phẩm này! Hãy chuyển về hết hàng hoặc ẩn sản phẩm.");
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', "Đã xóa sản phẩm '{$product->name}' thành công!");
    }
}
