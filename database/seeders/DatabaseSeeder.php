<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
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
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed default categories if not present
        $defaultCategories = [
            'Accessories', 'Bags', 'Pants', 'Shoes', 'Socks', 'T-shirts', 'Watchs'
        ];

        foreach ($defaultCategories as $categoryName) {
            Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => strtolower(str_replace(' ', '-', $categoryName))]
            );
        }

        // Ensure admin user exists
        User::updateOrCreate(
            ['email' => 'msaidg54@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('msaidg54@gmail.com'),
                'role' => 'admin',
            ]
        );
    }
}
