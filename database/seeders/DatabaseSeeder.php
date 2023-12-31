<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Dish;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'John Shuts',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => 'password'
        ]);

        User::factory()->create([
            'name' => 'Max Kostenko',
            'email' => 'koctenko525@gmail.com',
            'phone' => '+380660685608',
            'role' => 'customer',
            'password' => 'password'
        ]);

        User::factory()->create([
            'name' => 'Mic Kollish',
            'email' => 'just@gmail.com',
            'role' => 'customer',
            'password' => 'password'
        ]);

        Table::factory()->times(2)->create();

        Dish::factory()->count(10)->create();
    }
}
