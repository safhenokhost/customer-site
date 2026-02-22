<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('modules')->insert([
            ['name' => 'gallery', 'title' => 'گالری تصاویر'],
            ['name' => 'blog', 'title' => 'وبلاگ'],
            ['name' => 'video', 'title' => 'ویدیو (آپارات / یوتیوب)'],
        ]);
    }
}
