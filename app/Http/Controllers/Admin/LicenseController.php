<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PlatformUx;
use App\Http\Controllers\Controller;
use App\Models\License;
use App\Services\LicenseActivationService;
use App\Services\UpdateCheckService;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function index()
    {
        $license = License::current();
        return view('admin.licenses.index', compact('license'));
    }

    public function update(Request $request, LicenseActivationService $activationService)
    {
        $request->validate([
            'license_key' => 'required|string|max:255',
            'domain' => 'nullable|string|max:255',
        ]);

        $domain = $request->filled('domain') ? $request->domain : $request->getHost();

        $result = $activationService->validate($request->license_key, $domain);

        if (empty($result['valid'])) {
            return back()
                ->withInput($request->only('license_key', 'domain'))
                ->with('error', $result['message'] ?? 'لایسنس معتبر نیست.');
        }

        $license = License::current();
        $data = [
            'license_key' => $request->license_key,
            'domain' => $domain,
            'expires_at' => isset($result['expires_at']) ? $result['expires_at'] : null,
            'modules' => $result['modules'] ?? null,
            'support_expires_at' => $result['support_expires_at'] ?? null,
        ];

        if ($license) {
            $license->update($data);
        } else {
            License::create($data);
        }

        PlatformUx::clearCache();

        return back()->with('success', 'لایسنس با موفقیت فعال شد.');
    }

    /**
     * بررسی بروزرسانی از پلتفرم
     */
    public function checkUpdate(UpdateCheckService $updateCheck)
    {
        $currentVersion = config('app.version', '1.0.0');
        $result = $updateCheck->check($currentVersion);

        if (!$result['success']) {
            return back()->with('error', $result['message'] ?? 'بررسی بروزرسانی ناموفق بود.');
        }

        if (!empty($result['update_available'])) {
            return back()->with('update_available', [
                'latest_version' => $result['latest_version'],
                'changelog' => $result['changelog'],
            ]);
        }

        return back()->with('success', 'نسخهٔ نصب‌شده به‌روز است. (فعلی: ' . $currentVersion . ')');
    }
}
