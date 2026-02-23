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
        $domainNormalized = $this->normalizeDomain($domain);
        try {
            $response = Http::timeout(10)
                ->acceptJson()
                ->post($url, [
                    'license_key' => $licenseKey,
                    'domain' => $domainNormalized,
                ]);

            if (!$response->successful()) {
                $status = $response->status();
                $rawBody = $response->body();
                $body = $response->json();
                Log::warning('License API HTTP error', [
                    'status' => $status,
                    'url' => $url,
                    'body' => $rawBody,
                ]);
                $apiMessage = is_array($body) && isset($body['message']) && (string) $body['message'] !== '' ? (string) $body['message'] : null;
                if ($apiMessage !== null) {
                    $message = $apiMessage;
                } elseif (config('app.debug')) {
                    $message = 'خطا در ارتباط با سرور لایسنس (HTTP ' . $status . '). اگر بالا پیام خطا نیست، در customer-site فایل storage/logs/laravel.log را باز کنید و آخرین خط «License API HTTP error» را ببینید.';
                } else {
                    $message = 'خطا در ارتباط با سرور لایسنس. بعداً تلاش کنید.';
                }
                return [
                    'valid' => false,
                    'error' => 'api_error',
                    'message' => $message,
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
                'server_error' => 'خطای سرور لایسنس. بعداً تلاش کنید.',
            ];
            $message = !empty($data['message'])
                ? $data['message']
                : ($messages[$data['error'] ?? ''] ?? 'لایسنس معتبر نیست.');
            return [
                'valid' => false,
                'error' => $data['error'] ?? 'unknown',
                'message' => $message,
            ];
        } catch (\Throwable $e) {
            Log::error('License validation exception', [
                'message' => $e->getMessage(),
                'url' => $url,
                'exception' => get_class($e),
            ]);
            return [
                'valid' => false,
                'error' => 'connection_error',
                'message' => 'امکان ارتباط با سرور لایسنس وجود ندارد. اتصال اینترنت و آدرس پلتفرم (PLATFORM_URL در .env) را بررسی کنید.',
            ];
        }
    }

    /**
     * استخراج فقط host از دامنه (اگر کاربر آدرس کامل وارد کرده باشد).
     */
    private function normalizeDomain(string $domain): string
    {
        $domain = trim($domain);
        if (str_contains($domain, '://')) {
            $parsed = parse_url($domain);
            $domain = $parsed['host'] ?? $domain;
        }
        $domain = rtrim($domain, '/');
        return strtolower($domain);
    }
}
