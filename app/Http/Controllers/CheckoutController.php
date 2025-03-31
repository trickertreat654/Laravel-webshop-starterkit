<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\Product;

class CheckoutController extends Controller
{
    /**
     * Create a checkout session.
     */
    public function createSession()
    {
        $user = auth()->user();
        $cart = $user->cart;
        if (!$cart) {
            return redirect()->route('cart.index');
        }

        // Load missing relationships to ensure they're available.
        $items = $cart->items->loadMissing('product', 'variant');

        // Map the cart items to Stripe line items.
        $lineItems = $items->map(function (CartItem $item) {
            return [
                'price_data' => [
                    'currency'     => 'usd',
                    'unit_amount'  => $item->product->price, // assuming price is already in cents
                    'product_data' => [
                        'name'        => $item->product->name,
                        'description' => 'Size: ' . $item->variant->size . ', Color: ' . $item->variant->color,
                        'metadata'    => [
                            'product_id'         => $item->product->id,
                            'product_variant_id' => $item->product_variant_id,
                        ],
                    ],
                ],
                'quantity' => $item->quantity,
            ];
        })->toArray();

        // Create the checkout session using your user model's method.
        $session = $user->allowPromotionCodes()->checkout($lineItems, [
            'customer_update' => [
                'shipping' => 'auto',
            ],
            'shipping_address_collection' => [
                'allowed_countries' => ['US', 'CA'],
            ],
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => route('cart.index'),
            'metadata'    => [
                'user_id' => $user->id,
                'cart_id' => $cart->id,
            ],
        ]);

        // Redirect the user to the Stripe Checkout page.
        return redirect($session->url);
    }

    /**
     * Display the checkout success page.
     */
    public function success(Request $request)
    {
        $request->validate([
            'session_id' => ['required'],
        ]);

        $order = Order::where('stripe_checkout_session_id', $request->session_id)->first();

        return Inertia::render('CheckoutSuccess', [
            'sessionId' => $request->session_id,
            'order'     => $order ? [
                'id'                => $order->id,
                'amount_total'      => $order->amount_total,
                'amount_subtotal'   => $order->amount_subtotal,
                'amount_shipping'   => $order->amount_shipping,
                'amount_tax'        => $order->amount_tax,
                'amount_discount'   => $order->amount_discount,
                'created_at'        => $order->created_at->format('Y-m-d H:i:s'),
                'billing_address'   => $order->billing_address,
                'shipping_address'  => $order->shipping_address,
                'items'             => $order->items->map(function ($item) {
                    return [
                        'name'        => $item->name,
                        'description' => $item->description,
                        'quantity'    => $item->quantity,
                        'product_id'  => $item->product_id,
                        'image'       => Product::find($item->product_id)->image,
                        'price'       => $item->price,
                        'amount_total'=> $item->amount_total,
                    ];
                }),
            ] : null,
        ]);
    }
}
