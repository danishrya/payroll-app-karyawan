<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'fulan@gmail.com',
            'password' => Hash::make('123'), // Ganti dengan password yang aman
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
    }
}