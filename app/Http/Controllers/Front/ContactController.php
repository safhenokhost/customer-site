<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Helpers\SiteHelper;
use App\Models\Page;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        $pages = Page::published()->menu()->get();
        return view(SiteHelper::view('contact'), compact('pages'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // In production you might send email or store in DB
        return back()->with('success', 'پیام شما با موفقیت ارسال شد.');
    }
}
