<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('stripe_checkout_session_id');
            $table->string('payment_id');
            $table->string('status')->default('pending'); // e.g., pending, paid, failed
            $table->integer('amount_shipping');
            $table->integer('amount_discount');
            $table->integer('amount_tax');
            $table->integer('amount_subtotal');
            $table->integer('amount_total');
            $table->json('billing_address');
            $table->json('shipping_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
