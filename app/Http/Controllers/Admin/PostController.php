<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::orderBy('order')->get();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'nullable|boolean',
        ]);
        $data['user_id'] = $request->user()->id;
        $data['slug'] = ! empty($data['slug']) ? $data['slug'] : Str::slug($data['title']);
        $data['is_published'] = $request->boolean('is_published', false);
        $data['published_at'] = $request->boolean('is_published') ? now() : null;
        Post::create($data);
        return redirect()->route('admin.posts.index')->with('success', 'مطلب ذخیره شد.');
    }

    public function edit(Post $post)
    {
        $categories = Category::orderBy('order')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'nullable|boolean',
        ]);
        $data['slug'] = ! empty($data['slug']) ? $data['slug'] : Str::slug($data['title']);
        $data['is_published'] = $request->boolean('is_published');
        if ($data['is_published'] && ! $post->published_at) {
            $data['published_at'] = now();
        }
        $post->update($data);
        return redirect()->route('admin.posts.index')->with('success', 'مطلب به‌روزرسانی شد.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'مطلب حذف شد.');
    }
}
