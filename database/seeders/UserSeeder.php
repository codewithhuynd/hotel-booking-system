<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | HOST (chủ khách sạn — có thể tạo thêm host khác sau khi đăng nhập)
        |--------------------------------------------------------------------------
        */

        User::create([
            'full_name' => 'Hotel Host',
            'email' => 'host@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '0123456789',
            'birthday' => '1990-01-01',
            'role' => 'host',
        ]);

        /*
        |--------------------------------------------------------------------------
        | GUEST 1
        |--------------------------------------------------------------------------
        */

        User::create([
            'full_name' => 'Nguyen Van A',
            'email' => 'guest1@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '0988888888',
            'birthday' => '2004-05-10',
            'role' => 'guest',
        ]);

        /*
        |--------------------------------------------------------------------------
        | GUEST 2
        |--------------------------------------------------------------------------
        */

        User::create([
            'full_name' => 'Tran Thi B',
            'email' => 'guest2@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '0977777777',
            'birthday' => '2003-08-20',
            'role' => 'guest',
        ]);
    }
}