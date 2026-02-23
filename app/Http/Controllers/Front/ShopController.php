<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Helpers\SiteHelper;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Page;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        if (! SiteHelper::shopEnabled()) {
            abort(404);
        }
        $query = Product::active()->with('category')->orderBy('order');
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($qb) => $qb->where('slug', $request->category));
        }
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($qb) use ($search) {
                $qb->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }
        $products = $query->paginate(12)->withQueryString();
        $categories = \App\Models\ProductCategory::orderBy('order')->get();
        $pages = Page::published()->menu()->get();
        return view(SiteHelper::view('shop.index'), compact('products', 'categories', 'pages'));
    }

    public function show(string $slug)
    {
        if (! SiteHelper::shopEnabled()) {
            abort(404);
        }
        $product = Product::active()->where('slug', $slug)->firstOrFail();
        $pages = Page::published()->menu()->get();
        return view(SiteHelper::view('shop.show'), compact('product', 'pages'));
    }

    public function addToCart(Request $request)
    {
        if (! SiteHelper::shopEnabled()) {
            abort(404);
        }
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'nullable|integer|min:1']);
        $product = Product::active()->findOrFail($request->product_id);
        $qty = (int) ($request->quantity ?? 1);
        $cart = session()->get('cart', []);
        $id = $product->id;
        $cart[$id] = [
            'id' => $product->id,
            'title' => $product->title,
            'price' => $product->effective_price,
            'quantity' => ($cart[$id]['quantity'] ?? 0) + $qty,
            'image' => $product->image,
        ];
        session()->put('cart', $cart);
        return back()->with('success', 'به سبد اضافه شد.');
    }

    public function cart()
    {
        if (! SiteHelper::shopEnabled()) {
            abort(404);
        }
        $cart = session()->get('cart', []);
        $pages = Page::published()->menu()->get();
        return view(SiteHelper::view('shop.cart'), compact('cart', 'pages'));
    }

    public function updateCart(Request $request)
    {
        if (! SiteHelper::shopEnabled()) {
            abort(404);
        }
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'required|integer|min:0']);
        $cart = session()->get('cart', []);
        $id = (int) $request->product_id;
        $qty = (int) $request->quantity;
        if ($qty <= 0) {
            unset($cart[$id]);
        } elseif (isset($cart[$id])) {
            $cart[$id]['quantity'] = $qty;
        }
        session()->put('cart', $cart);
        return back()->with('success', 'سبد به‌روزرسانی شد.');
    }

    public function removeFromCart(int $productId)
    {
        if (! SiteHelper::shopEnabled()) {
            abort(404);
        }
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);
        return back()->with('success', 'محصول از سبد حذف شد.');
    }

    public function checkout(Request $request)
    {
        if (! SiteHelper::shopEnabled()) {
            abort(404);
        }
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('shop.cart')->with('error', 'سبد خرید خالی است.');
        }
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string|max:50',
            'customer_address' => 'required|string',
            'note' => 'nullable|string|max:1000',
        ]);
        $subtotal = 0;
        $items = [];
        foreach ($cart as $item) {
            $total = $item['price'] * $item['quantity'];
            $subtotal += $total;
            $items[] = [
                'product_id' => $item['id'],
                'product_title' => $item['title'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'total' => $total,
            ];
        }
        $order = Order::create([
            'number' => Order::generateNumber(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'note' => $request->note,
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'status' => 'pending',
        ]);
        foreach ($items as $i) {
            $order->items()->create($i);
        }
        session()->forget('cart');
        return redirect()->route('shop.index')->with('success', 'سفارش شما ثبت شد. شماره: ' . $order->number);
    }
}
