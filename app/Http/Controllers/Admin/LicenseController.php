<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function index()
    {
        $license = License::current();
        return view('admin.licenses.index', compact('license'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'license_key' => 'nullable|string|max:255',
            'domain' => 'nullable|string|max:255',
            'expires_at' => 'nullable|date',
        ]);

        $license = License::current();
        $key = $request->filled('license_key') ? $request->license_key : ($license ? $license->license_key : null);
        $domain = $request->filled('domain') ? $request->domain : ($license ? $license->domain : null);
        $expiresAt = $request->filled('expires_at') ? $request->expires_at : ($license && $license->expires_at ? $license->expires_at->toDateTimeString() : null);

        if ($license) {
            $license->update([
                'license_key' => $key,
                'domain' => $domain,
                'expires_at' => $expiresAt,
            ]);
        } else {
            License::create([
                'license_key' => $key,
                'domain' => $domain,
                'expires_at' => $expiresAt,
            ]);
        }

        return back()->with('success', 'اطلاعات لایسنس ذخیره شد.');
    }
}
