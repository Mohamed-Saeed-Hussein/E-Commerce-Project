<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $basePath = storage_path('app/public/products');
        
        if (!File::exists($basePath)) {
            $this->command->error('Products directory not found at: ' . $basePath);
            return;
        }

        // Map directory names to category names
        $categoryMapping = [
            'accessories' => 'Accessories',
            'bag' => 'Bags', 
            'pantalon' => 'Pants',
            'shoes' => 'Shoes',
            'socks' => 'Socks',
            't-shirt' => 'T-shirts',
            'watch' => 'Watchs'
        ];

        $totalProducts = 0;

        // Process each category directory
        foreach ($categoryMapping as $dirName => $categoryName) {
            $categoryPath = $basePath . '/' . $dirName;
            
            if (!File::exists($categoryPath)) {
                $this->command->warn("Directory not found: {$categoryPath}");
                continue;
            }

            $category = Category::where('name', $categoryName)->first();
            if (!$category) {
                $this->command->warn("Category not found: {$categoryName}");
                continue;
            }

            $imageFiles = File::files($categoryPath);
            $this->command->info("Processing {$categoryName} category with " . count($imageFiles) . " images");

            foreach ($imageFiles as $imageFile) {
                $fileName = $imageFile->getFilename();
                $imageName = pathinfo($fileName, PATHINFO_FILENAME);
                
                // Create product name from filename (remove Amazon-style codes)
                $productName = $this->generateProductName($imageName, $categoryName);
                
                // Generate product data
                $product = Product::create([
                    'name' => $productName,
                    'price' => rand(1999, 9999) / 100, // Random price between $19.99 and $99.99
                    'description' => $this->generateDescription($productName, $categoryName),
                    'quantity' => rand(10, 100),
                    'is_available' => true,
                    'image' => 'storage/products/' . $dirName . '/' . $fileName,
                    'category_id' => $category->id,
                ]);

                $totalProducts++;
            }
        }

        // Process "all" directory for additional products
        $allPath = $basePath . '/all';
        if (File::exists($allPath)) {
            $allImages = File::files($allPath);
            $this->command->info("Processing 'all' directory with " . count($allImages) . " images");

            foreach ($allImages as $imageFile) {
                $fileName = $imageFile->getFilename();
                $imageName = pathinfo($fileName, PATHINFO_FILENAME);
                
                // Check if this image is already used in a specific category
                $alreadyUsed = Product::where('image', 'like', '%' . $fileName)->exists();
                if ($alreadyUsed) {
                    continue;
                }

                // Randomly assign to a category
                $randomCategory = Category::inRandomOrder()->first();
                
                $productName = $this->generateProductName($imageName, $randomCategory->name);
                
                $product = Product::create([
                    'name' => $productName,
                    'price' => rand(1999, 9999) / 100,
                    'description' => $this->generateDescription($productName, $randomCategory->name),
                    'quantity' => rand(10, 100),
                    'is_available' => true,
                    'image' => 'storage/products/all/' . $fileName,
                    'category_id' => $randomCategory->id,
                ]);

                $totalProducts++;
            }
        }

        $this->command->info("Successfully created {$totalProducts} products with images!");
    }

    private function generateProductName($imageName, $categoryName)
    {
        // Clean up the image name and create a product name
        $cleanName = str_replace(['_', '-'], ' ', $imageName);
        
        // Remove Amazon-style product codes (patterns like 315m8qE2PjL, _AC_UL480_FMwebp_QL65_)
        $cleanName = preg_replace('/\d+[A-Za-z]+\d+[A-Za-z]*/', '', $cleanName);
        $cleanName = preg_replace('/_AC_UL\d+_FMwebp_QL\d+_/', '', $cleanName);
        $cleanName = preg_replace('/\.webp$/', '', $cleanName);
        $cleanName = preg_replace('/\.avif$/', '', $cleanName);
        $cleanName = preg_replace('/\.jpg$/', '', $cleanName);
        $cleanName = preg_replace('/\.png$/', '', $cleanName);
        
        $cleanName = trim($cleanName);
        
        if (empty($cleanName) || strlen($cleanName) < 3) {
            $cleanName = 'Premium ' . $categoryName;
        }

        // Capitalize words and limit length
        $cleanName = ucwords($cleanName);
        if (strlen($cleanName) > 50) {
            $cleanName = substr($cleanName, 0, 47) . '...';
        }
        
        return $cleanName;
    }

    private function generateDescription($productName, $categoryName)
    {
        $descriptions = [
            "High-quality {$categoryName} designed for comfort and style. Perfect for everyday wear.",
            "Premium {$categoryName} crafted with attention to detail. A must-have addition to your wardrobe.",
            "Stylish {$categoryName} that combines fashion and functionality. Made with quality materials.",
            "Elegant {$categoryName} perfect for any occasion. Comfortable and durable design.",
            "Modern {$categoryName} featuring contemporary design elements. Great value for money.",
        ];

        return $descriptions[array_rand($descriptions)];
    }
}
