<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    /**
     * Danh sách danh mục hoa kèm số lượng sản phẩm (Eloquent ORM)
     */
    public function index()
    {
        $categories = Category::withCount('products')
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Thêm mới danh mục hoa
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:kieu_dang,theo_dip,theo_mua',
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'type.required' => 'Vui lòng chọn loại phân loại.',
            'type.in' => 'Loại phân loại không hợp lệ.',
        ]);

        $slug = Str::slug($validated['name']);
        // Tránh trùng slug
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'type' => $validated['type'],
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Thêm mới danh mục hoa thành công!');
    }

    /**
     * Cập nhật danh mục hoa
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:kieu_dang,theo_dip,theo_mua',
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'type.required' => 'Vui lòng chọn loại phân loại.',
            'type.in' => 'Loại phân loại không hợp lệ.',
        ]);

        $slug = Str::slug($validated['name']);
        if ($slug !== $category->slug) {
            $originalSlug = $slug;
            $counter = 1;
            while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            $category->slug = $slug;
        }

        $category->name = $validated['name'];
        $category->type = $validated['type'];
        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công!');
    }

    /**
     * Xóa danh mục hoa
     */
    public function destroy($id)
    {
        $category = Category::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', "Không thể xóa danh mục '{$category->name}' vì đang có {$category->products_count} sản phẩm hoa liên kết!");
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', "Đã xóa danh mục '{$category->name}' thành công!");
    }
}
