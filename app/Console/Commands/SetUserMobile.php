<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SetUserMobile extends Command
{
    protected $signature = 'user:set-mobile 
                            {--email= : ایمیل کاربر}
                            {--mobile= : شماره موبایل (مثال: 09123456789)}
                            {--id= : شناسه کاربر (جایگزین ایمیل)}';

    protected $description = 'تنظیم موبایل برای کاربر (ورود با موبایل)';

    public function handle(): int
    {
        $email = $this->option('email');
        $mobile = $this->option('mobile');
        $id = $this->option('id');

        if (!$mobile || !preg_match('/^09[0-9]{9}$/', $mobile)) {
            $this->error('لطفاً موبایل معتبر وارد کنید (مثال: 09123456789).');
            return self::FAILURE;
        }

        $user = null;
        if ($id) {
            $user = User::find($id);
        } elseif ($email) {
            $user = User::where('email', $email)->first();
        }

        if (!$user) {
            $this->error('کاربری یافت نشد. از --email= یا --id= استفاده کنید.');
            return self::FAILURE;
        }

        if (User::where('mobile', $mobile)->where('id', '!=', $user->id)->exists()) {
            $this->error('این موبایل قبلاً برای کاربر دیگری ثبت شده است.');
            return self::FAILURE;
        }

        $user->mobile = $mobile;
        $user->save();

        $this->info("موبایل برای کاربر «{$user->name}» ({$user->email}) تنظیم شد.");
        return self::SUCCESS;
    }
}
