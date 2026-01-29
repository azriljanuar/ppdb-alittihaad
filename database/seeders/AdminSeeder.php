<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@104.com'], // Kunci pencarian
            [
                'name' => 'Admin PPDB',
                'password' => Hash::make('password'),
                'role' => 'superadmin',
                'jenjang_access' => null,
            ]
        );

        // Create additional admin users
        $admins = [
            ['name' => 'Sopian Maulana', 'email' => 'sopian@gmail.com', 'role' => 'admin'],
            ['name' => 'Dede Nasrulloh', 'email' => 'dedenasrulloh@104.com', 'role' => 'admin'],
            ['name' => 'Hisnu Sahrul Mubarok, S.Pd.', 'email' => 'hisnu@104.com', 'role' => 'admin'],
            ['name' => 'Rifqi Abdurrahman, S.Pd.', 'email' => 'rifqi@104.com', 'role' => 'admin'],
            ['name' => 'Yulia Maryam', 'email' => 'yulia@104.com', 'role' => 'admin'],
            ['name' => 'Liesnawati', 'email' => 'liesnawati@104.com', 'role' => 'admin'],
            ['name' => 'Gita Wulan Purnama', 'email' => 'gita@104.com', 'role' => 'admin'],
        ];

        foreach ($admins as $admin) {
            User::firstOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make('password'),
                    'role' => $admin['role'],
                    'jenjang_access' => null,
                ]
            );
        }
    }
}
