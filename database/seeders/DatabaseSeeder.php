<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin Account (admin@gmail.com / 123)
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Quản Trị Viên ChronoLux',
                'password' => Hash::make('123'),
                'role' => 'admin',
                'phone' => '19008888',
                'address' => 'Trụ sở chính ChronoLux, 68 Tràng Tiền, Hà Nội',
                'email_verified_at' => now(),
            ]
        );

        // 2. Customer Account (khachhang@gmail.com / 123)
        User::updateOrCreate(
            ['email' => 'khachhang@gmail.com'],
            [
                'name' => 'Nguyễn Hoàng Long',
                'password' => Hash::make('123'),
                'role' => 'customer',
                'phone' => '0988888999',
                'address' => 'Số 88 Phố Lý Thường Kiệt, Hoàn Kiếm, Hà Nội',
                'email_verified_at' => now(),
            ]
        );
    }
}
