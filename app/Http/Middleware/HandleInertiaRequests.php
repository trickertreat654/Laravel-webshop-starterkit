<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use App\Models\Cart;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        // [$message, $author] = str(Inspiring::quotes()->random())->explode('-');

        $user = $request->user();

        if ($user) {
            $cart = $user->cart;
        } else {
            // the cart has a seesion_id column
            $cart = Cart::where('session_id', session()->getId())->first();

        }




        return [
            ...parent::share($request),
            'name' => config('app.name'),
            // 'quote' => ['message' => trim($message), 'author' => trim($author)],
            'auth' => [
                'user' => $user ? $user->only('id', 'name', 'email', 'avatar') : null, // Only share the user's id, name, and email
            ],
            'cartCount' => $cart ? $cart->items->sum('quantity') : 0,
            'ziggy' => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
