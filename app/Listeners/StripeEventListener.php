<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Cashier;
use Laravel\Cashier\Events\WebhookReceived;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
// use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\OrderItem;

class StripeEventListener
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
    public function handle(WebhookReceived $event): void
    {
        //
        DB::transaction(function() use ($event) {

            if ($event->payload['type'] === 'checkout.session.completed') {
                // Handle the incoming event...
                $session = Cashier::stripe()->checkout->sessions->retrieve(
                    $event->payload['data']['object']['id'],
                    []
                );
                $user = User::find($session->metadata->user_id);
                $cart = Cart::find($session->metadata->cart_id);

              
                $order = $user->orders()->create([
                        'stripe_checkout_session_id' => $session->id,
                        'amount_shipping' => $session->total_details->amount_shipping,
                        'amount_discount' => $session->total_details->amount_discount,
                        'amount_tax' => $session->total_details->amount_tax,
                        'amount_subtotal' => $session->amount_subtotal,
                        'amount_total' => $session->amount_total,
                        'payment_id' => $session->payment_intent, // Assuming payment_id is the payment intent ID
                        'billing_address' => [
                            'name' => $session->customer_details->name,
                            'line1' => $session->customer_details->address->line1,
                            'line2' => $session->customer_details->address->line2,
                            'city' => $session->customer_details->address->city,
                            'postal_code' => $session->customer_details->address->postal_code,
                            'state' => $session->customer_details->address->state,
                            'country' => $session->customer_details->address->country,
                        
                        ],
                        'shipping_address' => [
                            'name' => $session->shipping_details->name,
                            'line1' => $session->shipping_details->address->line1,
                            'line2' => $session->shipping_details->address->line2,
                            'city' => $session->shipping_details->address->city,
                            'postal_code' => $session->shipping_details->address->postal_code,
                            'state' => $session->shipping_details->address->state,
                            'country' => $session->shipping_details->address->country,
                        ],
                    ]);
                    $lineItems = Cashier::stripe()->checkout->sessions->allLineItems(
                        $session->id);
    
                    $orderItems = collect($lineItems->all())->map(function ($lineItem) {
                        $product = Cashier::stripe()->products->retrieve(
                            $lineItem->price->product,
                            []
                        );
                        return new OrderItem([
                            'product_id' => $product->metadata->product_id,
                            'product_variant_id' => $product->metadata->product_id_variant, // Assuming the variant ID is the price ID
                            'name' => $lineItem->description,
                            'description' => $product->description,
                            'price' => $lineItem->price->unit_amount,
                            'quantity' => $lineItem->quantity,
                            'amount_discount' => $lineItem->amount_discount,
                            'amount_tax' => $lineItem->amount_tax,
                            'amount_subtotal' => $lineItem->amount_subtotal,
                            'amount_total' => $lineItem->amount_total,
                        ]);
                    });
    
                    $order->items()->saveMany($orderItems);
                    $cart->items()->delete();
                    $cart->delete();

                    // Mail::to($user)->send(new OrderConfirmation($order));
                
            }

        });
    }
}
