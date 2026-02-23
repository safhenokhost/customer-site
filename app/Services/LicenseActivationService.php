<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * اعتبارسنجی لایسنس از طریق API پلتفرم.
 */
class LicenseActivationService
{
    public function validate(string $licenseKey, string $domain): array
    {
        $baseUrl = config('site.platform_url');
        if (empty($baseUrl)) {
            return [
                'valid' => false,
                'error' => 'config_missing',
                'message' => 'آدرس پلتفرم (PLATFORM_URL) در تنظیمات تنظیم نشده است.',
            ];
        }

        $url = $baseUrl . '/api/license/validate';
        try {
            $response = Http::timeout(10)
                ->post($url, [
                    'license_key' => $licenseKey,
                    'domain' => $domain,
                ]);

            if (!$response->successful()) {
                Log::warning('License API HTTP error', [
                    'status' => $response->status(),
                    'url' => $url,
                ]);
                return [
                    'valid' => false,
                    'error' => 'api_error',
                    'message' => 'خطا در ارتباط با سرور لایسنس. بعداً تلاش کنید.',
                ];
            }

            $data = $response->json();
            if (!is_array($data)) {
                return ['valid' => false, 'error' => 'invalid_response', 'message' => 'پاسخ سرور نامعتبر است.'];
            }

            if (!empty($data['valid'])) {
                return $data;
            }

            $messages = [
                'invalid_key' => 'کلید لایسنس نامعتبر است.',
                'revoked' => 'این لایسنس لغو شده است.',
                'expired' => 'تاریخ انقضای لایسنس گذشته است.',
                'domain_mismatch' => 'دامنهٔ این سایت با لایسنس مطابقت ندارد.',
                'site_inactive' => 'سایت در پلتفرم غیرفعال است.',
            ];
            return [
                'valid' => false,
                'error' => $data['error'] ?? 'unknown',
                'message' => $messages[$data['error'] ?? ''] ?? 'لایسنس معتبر نیست.',
            ];
        } catch (\Throwable $e) {
            Log::error('License validation exception', ['message' => $e->getMessage(), 'url' => $url]);
            return [
                'valid' => false,
                'error' => 'connection_error',
                'message' => 'امکان ارتباط با سرور لایسنس وجود ندارد. اتصال اینترنت و آدرس پلتفرم را بررسی کنید.',
            ];
        }
    }
}
