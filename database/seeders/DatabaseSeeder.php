<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'John Shuts',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => 'password'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Max Kostenko',
            'email' => 'koctenko525@gmail.com',
            'role' => 'client',
            'password' => 'password'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Duo Megan',
            'email' => 'duomegan@gmail.com',
            'role' => 'waiter',
            'password' => 'password'
        ]);
    }
}
