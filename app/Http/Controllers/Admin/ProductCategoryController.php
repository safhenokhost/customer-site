<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::orderBy('order')->get();
        return view('admin.product-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.product-categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['order'] = $data['order'] ?? ProductCategory::max('order') + 1;
        ProductCategory::create($data);
        return redirect()->route('admin.product-categories.index')->with('success', 'دسته‌بندی ذخیره شد.');
    }

    public function edit(ProductCategory $productCategory)
    {
        return view('admin.product-categories.edit', compact('productCategory'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $productCategory->update($data);
        return redirect()->route('admin.product-categories.index')->with('success', 'دسته‌بندی به‌روزرسانی شد.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->products()->update(['category_id' => null]);
        $productCategory->delete();
        return redirect()->route('admin.product-categories.index')->with('success', 'دسته‌بندی حذف شد.');
    }
}
