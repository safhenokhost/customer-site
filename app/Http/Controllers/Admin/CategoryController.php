<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['order'] = Category::max('order') + 1;
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی ذخیره شد.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی به‌روزرسانی شد.');
    }

    public function destroy(Category $category)
    {
        $category->posts()->update(['category_id' => null]);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی حذف شد.');
    }
}
