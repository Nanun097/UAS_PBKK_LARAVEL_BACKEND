<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->string('order_id'); // FK ke orders.order_id
            $table->string('product_id'); // FK ke products.product_id
            $table->integer('quantity');
            $table->integer('price');
            $table->timestamps();

            // Foreign key ke order_id
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');

            // Foreign key ke product_id
            $table->foreign('product_id')->references('product_id')->on('product')->onDelete('cascade');
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
