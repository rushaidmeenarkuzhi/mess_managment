<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

       User::insert([
            [
                'name' => 'admin',
                'username' => 'admin',
                'user_type' => '1',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin@123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
