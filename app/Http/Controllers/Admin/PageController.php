<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('order')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_published' => 'nullable|boolean',
            'show_in_menu' => 'nullable|boolean',
        ]);
        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['is_published'] = $request->boolean('is_published', true);
        $data['show_in_menu'] = $request->boolean('show_in_menu', true);
        $data['order'] = Page::max('order') + 1;
        Page::create($data);
        return redirect()->route('admin.pages.index')->with('success', 'صفحه ذخیره شد.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'body' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'nullable|boolean',
            'show_in_menu' => 'nullable|boolean',
        ]);
        $data['is_published'] = $request->boolean('is_published');
        $data['show_in_menu'] = $request->boolean('show_in_menu');
        $page->update($data);
        return redirect()->route('admin.pages.index')->with('success', 'صفحه به‌روزرسانی شد.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'صفحه حذف شد.');
    }
}
