<?php

use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Order; // Assuming you have an Order model
use Laravel\WorkOS\Http\Middleware\ValidateSessionWithWorkOS;

Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('appearance');
});



Route::middleware([
    'auth',
    ValidateSessionWithWorkOS::class,
])->group(function () {
    Route::get('orders/orders', function () {
        // You can add logic here to fetch orders from the database if needed.
        $user = auth()->user();
        // Get the orders in descending order of creation date.
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return Inertia::render('orders/Orders', [
            'orders' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'amount_total' => $order->amount_total,
                    'created_at' => $order->created_at->format('Y-m-d H:i:s'),
                    'status' => $order->status, // Assuming you have a status field
                ];
            }),
        ]);
    })->name('orders.index');

    Route::get('/orders/help', function () {
        return Inertia::render('orders/Help');
    })->name('orders.help');
});
