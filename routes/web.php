<?php


use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ProductController; 
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Email; 
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CheckoutController;



Route::get('/', function () {
    // Eager load images for each product that is both featured and active.
    $products = Product::with('image')
                       ->where('is_featured', true)
                       ->where('is_active', true)
                       ->get();
    return Inertia::render('Welcome', [
        'products' => $products,
    ]);
})->name('home');


Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');
Route::resource('products', ProductController::class)->only([
    'index', 'show'
]);

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::resource('cart/items', CartItemController::class)->only(['store', 'update', 'destroy']);

Route::post('newsletter', function (Request $request) {
    // Validate the email address
    $request->validate([ 
        'email' => ['required', 'email', 'unique:emails,email'],
    ]);
    Email::create(['email' => $request->email]);
    return to_route('home');
})->name('newsletter.subscribe');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'createSession'])
         ->name('checkout.create');
    Route::get('/checkout-success', [CheckoutController::class, 'success'])
         ->name('checkout.success');
});

Route::middleware([
   'auth',
   ValidateSessionWithWorkOS::class,
])->group(function () {
   Route::get('dashboard', function () {
       return Inertia::render('Dashboard');
   })->name('dashboard');
});
Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
