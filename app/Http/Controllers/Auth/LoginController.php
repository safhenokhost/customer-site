<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\IranianMobile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'mobile' => ['required', new IranianMobile],
            'password' => 'required',
        ]);

        $mobile = self::normalizeMobile($request->input('mobile'));

        $user = User::where('mobile', $mobile)->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            Auth::login($user, (bool) $request->remember);
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['mobile' => 'موبایل یا رمز عبور اشتباه است.'])->onlyInput('mobile');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * نرمال‌سازی شماره موبایل (ارقام فارسی به انگلیسی، ۱۰ رقمی به ۰۹...).
     */
    public static function normalizeMobile(string $value): string
    {
        $persianDigits = ['۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4','۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9'];
        $clean = strtr($value, $persianDigits);
        $clean = preg_replace('/[^0-9]/', '', $clean);
        if (strlen($clean) === 10 && str_starts_with($clean, '9')) {
            $clean = '0' . $clean;
        }
        return $clean;
    }
}
