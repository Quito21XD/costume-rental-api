<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Costume;
use App\Models\Customer;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Quito User',
            'email' => 'quito@example.com',
            'password' => bcrypt('12345678'),
        ]);
        Category::factory(100)->create();
        Costume::factory(50)->create();
        Customer::factory(10)->create([
            'user_id' => 1,
        ]);
    }
}
