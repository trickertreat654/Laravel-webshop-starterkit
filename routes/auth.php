<?php

use Illuminate\Support\Facades\Route;
use Laravel\WorkOS\Http\Requests\AuthKitAuthenticationRequest;
use Laravel\WorkOS\Http\Requests\AuthKitLoginRequest;
use Laravel\WorkOS\Http\Requests\AuthKitLogoutRequest;
use App\Models\Cart;
 


Route::get('login', function (AuthKitLoginRequest $request) {
    return $request->redirect();
})->middleware(['guest'])->name('login');

Route::get('authenticate', function (AuthKitAuthenticationRequest $request) {
  
    $session = session()->getId();
    $request->authenticate();
    $sessionCart = Cart::where('session_id', $session)->first();
    $userCart = $request->user()->cart;

    if (!$sessionCart ) {
        return to_route('home');
    }

    if (!$userCart) {
        // If the user doesn't have a cart, assign the session cart to the user
        $userCart = $request->user()->cart()->create([
            'session_id' => $session,
            'user_id' => $request->user()->id,
        ]);
    } else {
        // If the user already has a cart, merge items from session cart
        // to user cart
        
    }
    $sessionCart->items->each(fn($item) => $userCart->items()->updateOrCreate([
        'product_variant_id' => $item->product_variant_id,
        'quantity' => 0,
    ], [
        
        ])->increment('quantity', $item->quantity)
    );
    
    $sessionCart->items->each->delete();
    $sessionCart->delete();
    // return tap(to_route('dashboard'), fn () => $request->authenticate());
    // if user cart is empty, it will return to home, otherwise it will return to cart
    if ($userCart && $userCart->items->isEmpty()) {
        return to_route('home');
    } else {
        return to_route('cart.index');
    }
})->middleware(['guest']);

Route::post('logout', function (AuthKitLogoutRequest $request) {
    return $request->logout();
})->middleware(['auth'])->name('logout');
