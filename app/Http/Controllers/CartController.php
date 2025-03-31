<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Cart;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = auth()->guest()
            ? Cart::where('session_id', session()->getId())->first()
            : auth()->user()->cart;
        
        return Inertia::render('Cart', [
            'cart' => [
                'id'    => $cart ? $cart->id : null,
                'items' => $cart ? $cart->items->map(function ($item) {
                    return [
                        'id'       => $item->id,
                        'quantity' => $item->quantity,
                        'variant'  => $item->variant,
                        'product'  => $item->variant->product,
                        'image'    => $item->variant->product->image,
                    ];
                }) : [],
            ],
        ]);
    }
}
