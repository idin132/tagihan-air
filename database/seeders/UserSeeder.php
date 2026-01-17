<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PharIo\Manifest\Email;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Administrator',
            'username' => 'admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('12345678'), // Password yang dienkripsi
        ]);
        User::create([
            'name'     => 'Bu Gentisya Tri Mardiani',
            'username' => 'gentisya',
            'email'    => 'gentisya@gmail.com',
            'password' => Hash::make('12345678'), // Password yang dienkripsi
        ]);
    }
}