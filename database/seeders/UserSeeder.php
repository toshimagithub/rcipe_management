<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;  // 追加
use Illuminate\Support\Facades\Hash;  // 追加

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => '管理者',
            'role' => '管理者',
            'email' => 'admin@admin',
            'password' => Hash::make('admin@admin')  // Hash クラスも使用するので追加
        ]);
    }
}
