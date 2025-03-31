<?php

namespace App\Listeners;

use IlluminateAuthEventsLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Cart;


class HandleUserLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(IlluminateAuthEventsLogin $event): void
    {
        //
        $session = session()->getId();
        $request->authenticate();
        
        $sessionCart = Cart::where('session_id', $session)->first();
        $userCart = $request->user()->cart;

        $sessionCart->items->each(fn($item) => $userCart->items()->updateOrCreate([
            'product_variant_id' => $item->product_variant_id,
        ], [
            
        ])->increment('quantity', $item->quantity)
     );
        
        $sessionCart->items->each->delete();
        $sessionCart->delete();
        
    }
}
