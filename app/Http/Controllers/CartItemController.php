<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Log;

class CartItemController extends Controller
{
    /**
     * Store a new cart item or increment its quantity.
     */
    public function store(Request $request)
    {

        $request->validate([
            'variant' => ['required', 'exists:product_variants,id'],
        ]);

        $cart = auth()->guest()
            ? Cart::firstOrCreate(['session_id' => session()->getId()])
            : (auth()->user()->cart ?: auth()->user()->cart()->create());

        $item = $cart->items()->where('product_variant_id', $request->variant)->first();

        if ($item) {
            // Item exists: simply increment its quantity.
            $item->increment('quantity');
        } else {
            // Item does not exist: create it with quantity 1.
            $cart->items()->create([
                'product_variant_id' => $request->variant,
                'quantity'           => 1,
            ]);
        }

        return back()->with('success', 'Product added to cart!')
                      ->with('cartCount', $cart->items->sum('quantity'));
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, CartItem $item)
    {
        // $request->validate([
        //     'quantity' => 'required|integer|min:0',
        // ]);

        // if ($request->quantity == 0) {
        //     $cartItem->delete();
        // } else {
        //     $cartItem->update(['quantity' => $request->quantity]);
        // }

        // return back()->with('success', 'Cart updated.');
        $request->validate([
            'quantity' => 'required|integer|min:0',
        ]);
    
        // If quantity is set to 0, remove the item from the cart.
        if ($request->quantity == 0) {
            $item->delete();
        } else {
            $item->update(['quantity' => $request->quantity]);
        }
    
        return back()->with('success', 'Cart updated.');
    }

    /**
     * Remove a cart item.
     */
    public function destroy(CartItem $item)
    {
        $item->delete();

        return back()->with('success', 'Item removed from cart.');
    }
}
