<?php

namespace Database\Seeders;

use App\Models\Setting\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Setting::create([
        //     'name' => 'email',
        //     'value' => 'info@example.com',
        //     'status' => 1,
        // ]);

        DB::table('settings')->insert([
            'title' => 'عنوان سایت',
            'description' => 'توضیحات سایت',
            'keywords' => 'کلمات کلیدی سایت',
            'logo' => 'logo.png',
            'icon' => 'icon.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
