<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Module;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $siteName = Setting::get('site_name', '');
        $theme = Setting::get('theme', 'default');
        $modules = Module::all();
        return view('admin.settings.index', compact('siteName', 'theme', 'modules'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'theme' => 'required|string|in:default',
        ]);
        Setting::set('site_name', $request->site_name);
        Setting::set('theme', $request->theme);
        return back()->with('success', 'تنظیمات ذخیره شد.');
    }
}
