<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Loop to create 10 products.
        for ($i = 1; $i <= 10; $i++) {
            // Mark the first 4 products as featured.
            $isFeatured = ($i <= 4);
            
            // Insert a product and retrieve its ID.
            $productId = DB::table('products')->insertGetId([
                'name'        => 'Product ' . $i,
                'description' => 'This is the description for product ' . $i,
                'price'       => rand(1000, 5000), // Price in cents (example)
                'is_featured' => $isFeatured,
                'is_active'   => true,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
    
            // Insert 4 images for the product.
            // Mark the first image as featured.
            for ($k = 0; $k < 4; $k++) {
                $featured = ($k === 0);
                $num = $i * 10 + $k; // Unique number for each image.
                DB::table('images')->insert([
                    'product_id' => $productId,
                    'featured'   => $featured,
                    // Using a seed value to generate a unique image per product.
                    'path'       => "https://picsum.photos/seed/product{$num}/300/300",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    
            // Define sample colors and sizes for the variants.
            $colors = ['Red', 'Blue', 'Green'];
            $sizes  = ['S', 'M', 'L'];
    
            // Insert 3 product variants.
            for ($j = 0; $j < 3; $j++) {
                DB::table('product_variants')->insert([
                    'product_id' => $productId,
                    'color'      => $colors[$j],
                    'size'       => $sizes[$j],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
