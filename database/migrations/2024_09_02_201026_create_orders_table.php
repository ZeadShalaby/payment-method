<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {

            $table->id(); // order ID
            $table->integer('order_num');
            $table->decimal('total_amount', 10, 2);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('offer_id')->nullable();
            $table->bigInteger('payment_id')->unsigned()->nullOnDelete()->onDelete('cascade');
            $table->index('payment_id');
            $table->integer('price');
            $table->timestamps();

        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
