<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    protected $signature = 'user:make-admin 
                            {--email= : ایمیل کاربر}
                            {--id= : شناسه کاربر}
                            {--mobile= : موبایل کاربر}';

    protected $description = 'تبدیل یک کاربر به ادمین (دسترسی به پنل مدیریت)';

    public function handle(): int
    {
        $email = $this->option('email');
        $id = $this->option('id');
        $mobile = $this->option('mobile');

        $user = null;
        if ($id) {
            $user = User::find($id);
        } elseif ($email) {
            $user = User::where('email', $email)->first();
        } elseif ($mobile) {
            $user = User::where('mobile', $mobile)->first();
        }

        if (!$user) {
            $this->error('کاربری یافت نشد. از --email= یا --id= یا --mobile= استفاده کنید.');
            return self::FAILURE;
        }

        if ($user->is_admin) {
            $this->info("کاربر «{$user->name}» از قبل ادمین است.");
            return self::SUCCESS;
        }

        $user->is_admin = true;
        $user->save();

        $this->info("کاربر «{$user->name}» ({$user->email}) به ادمین تبدیل شد. اکنون می‌تواند به پنل مدیریت وارد شود.");
        return self::SUCCESS;
    }
}
