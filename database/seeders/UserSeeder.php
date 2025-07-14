<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Philocalist',
            'email' => 'admin@philocalist.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'User Demo',
            'email' => 'user@philocalist.com',
            'password' => Hash::make('password123'),
            'role' => 'user'
        ]);
    }
}
