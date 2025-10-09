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

        // Create test user
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password123'),
                'role' => 'user'
            ]
        );

        // Seed default categories if not present
        $defaultCategories = [
            'Accessories', 'Bags', 'Pants', 'Shoes', 'Socks', 'T-shirts', 'Watches'
        ];

        foreach ($defaultCategories as $categoryName) {
            $slug = strtolower(str_replace(' ', '-', $categoryName));
            Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => $slug]
            );
            // Debug: Log category creation
            \Log::info('Category created/updated', [
                'name' => $categoryName,
                'slug' => $slug
            ]);
        }

        // Ensure only one admin user exists (admin@gmail.com / password: admin123!)
        // First, remove any existing admins
        User::where('role', 'admin')->delete();
        
        // Create the single admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@gmail.com'),
            'role' => 'admin'
        ]);
        
        \Log::info('Admin user created', [
            'email' => 'admin@gmail.com',
            'name' => 'Admin'
        ]);
        
        // Seed products with images
        $this->call(ProductImageSeeder::class);
    }
}
