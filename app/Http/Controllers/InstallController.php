<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class InstallController extends Controller
{
    public function step1()
    {
        return view('install.step1');
    }

    public function saveDb(Request $request)
    {
        $request->validate([
            'db_host' => 'required',
            'db_name' => 'required',
            'db_user' => 'required',
        ]);

        $envPath = base_path('.env');
        $env = file_get_contents($envPath);

        $env = preg_replace('/DB_HOST=.*/', 'DB_HOST='.$request->db_host, $env);
        $env = preg_replace('/DB_DATABASE=.*/', 'DB_DATABASE='.$request->db_name, $env);
        $env = preg_replace('/DB_USERNAME=.*/', 'DB_USERNAME='.$request->db_user, $env);
        $env = preg_replace('/DB_PASSWORD=.*/', 'DB_PASSWORD='.$request->db_password, $env);

        file_put_contents($envPath, $env);

        config()->set('database.connections.mysql.host', $request->db_host);
        config()->set('database.connections.mysql.database', $request->db_name);
        config()->set('database.connections.mysql.username', $request->db_user);
        config()->set('database.connections.mysql.password', $request->db_password);

        DB::purge('mysql');

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            return back()->withErrors(['db' => 'اتصال به دیتابیس ناموفق بود']);
        }

        Artisan::call('migrate', ['--force' => true]);

        return redirect()->route('install.step2');
    }

    public function step2()
    {
        return view('install.step2');
    }

    public function finish(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
        ]);

file_put_contents(storage_path('installed.lock'), 'installed');

    return redirect('/')->with('success', 'نصب با موفقیت انجام شد');

}
}
