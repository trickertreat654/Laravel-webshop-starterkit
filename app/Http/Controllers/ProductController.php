<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product; // Ensure to import the Product model

class ProductController extends Controller
{
    //

    public function index(){
         // Eager load images for each product.
         $products = Product::with('image')
         ->where('is_active', true)
         ->get();


    return Inertia::render('products/Index', [
        'products' => $products,
    ]);
    }
    public function show(Product $product)
    {
        $product->load(['images', 'variants']);

        return Inertia::render('products/Show', [
            'product' => $product,
        ]);
    }
}
