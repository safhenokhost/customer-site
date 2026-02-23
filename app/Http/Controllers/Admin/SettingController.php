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
        $aboutUsTitle = Setting::get('about_us_title', '');
        $aboutUsText = Setting::get('about_us_text', '');
        $aboutUsEnabled = (bool) Setting::get('about_us_enabled', false);
        $modules = Module::all();
        return view('admin.settings.index', compact('siteName', 'theme', 'aboutUsTitle', 'aboutUsText', 'aboutUsEnabled', 'modules'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'theme' => 'required|string|in:default,minimal,dark',
            'about_us_title' => 'nullable|string|max:255',
            'about_us_text' => 'nullable|string|max:2000',
        ]);
        Setting::set('site_name', $request->site_name);
        Setting::set('theme', $request->theme);
        Setting::set('about_us_enabled', $request->boolean('about_us_enabled') ? '1' : '0');
        Setting::set('about_us_title', $request->about_us_title ?? '');
        Setting::set('about_us_text', $request->about_us_text ?? '');
        return back()->with('success', 'تنظیمات ذخیره شد.');
    }
}
