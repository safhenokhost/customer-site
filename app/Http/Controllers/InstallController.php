<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InstallController extends Controller
{
    public function welcome()
    {
        $checks = [
            'php' => version_compare(PHP_VERSION, '8.2.0', '>='),
            'extensions' => [
                'pdo' => extension_loaded('pdo'),
                'mbstring' => extension_loaded('mbstring'),
                'openssl' => extension_loaded('openssl'),
                'tokenizer' => extension_loaded('tokenizer'),
                'json' => extension_loaded('json'),
                'ctype' => extension_loaded('ctype'),
                'fileinfo' => extension_loaded('fileinfo'),
            ],
            'writable' => [
                'storage' => is_writable(storage_path()),
                'bootstrap_cache' => is_writable(base_path('bootstrap/cache')),
                'env' => ! file_exists(base_path('.env')) || is_writable(base_path('.env')),
            ],
        ];
        $checks['extensions_ok'] = ! in_array(false, $checks['extensions'], true);
        $checks['writable_ok'] = ! in_array(false, $checks['writable'], true);
        $checks['passed'] = $checks['php'] && $checks['extensions_ok'] && $checks['writable_ok'];

        return view('install.welcome', compact('checks'));
    }

    public function database()
    {
        return view('install.database');
    }

    public function storeDatabase(Request $request)
    {
        $request->validate([
            'db_host' => 'required|string',
            'db_name' => 'required|string',
            'db_user' => 'required|string',
            'db_password' => 'nullable|string',
        ]);

        $envPath = base_path('.env');
        $env = file_exists($envPath) ? file_get_contents($envPath) : file_get_contents(base_path('.env.example'));

        $env = preg_replace('/DB_HOST=.*/', 'DB_HOST=' . $request->db_host, $env);
        $env = preg_replace('/DB_DATABASE=.*/', 'DB_DATABASE=' . $request->db_name, $env);
        $env = preg_replace('/DB_USERNAME=.*/', 'DB_USERNAME=' . $request->db_user, $env);
        $env = preg_replace('/DB_PASSWORD=.*/', 'DB_PASSWORD=' . ($request->db_password ?? ''), $env);

        if (! file_put_contents($envPath, $env)) {
            return back()->withErrors(['db' => 'امکان نوشتن فایل .env نیست.']);
        }

        config()->set('database.connections.mysql.host', $request->db_host);
        config()->set('database.connections.mysql.database', $request->db_name);
        config()->set('database.connections.mysql.username', $request->db_user);
        config()->set('database.connections.mysql.password', $request->db_password ?? '');
        DB::purge('mysql');

        try {
            DB::connection()->getPdo();
        } catch (\Throwable $e) {
            return back()->withErrors(['db' => 'اتصال به دیتابیس برقرار نشد: ' . $e->getMessage()]);
        }

        Artisan::call('migrate', ['--force' => true]);

        return redirect()->route('install.admin');
    }

    public function admin()
    {
        return view('install.admin');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
        ]);

        return redirect()->route('install.settings');
    }

    public function settings()
    {
        return view('install.settings');
    }

    public function storeSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'theme' => 'required|string|in:default',
        ]);

        Setting::set('site_name', $request->site_name);
        Setting::set('theme', $request->theme ?? 'default');

        file_put_contents(storage_path('installed.lock'), (string) now());

        return redirect()->route('install.done');
    }

    public function done()
    {
        return view('install.done');
    }
}
