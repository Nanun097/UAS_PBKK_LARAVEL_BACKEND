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
        Schema::create('categories', function (Blueprint $table) {
        $table->id('category_id'); // PRIMARY KEY kategori
        $table->string('product_id'); // FOREIGN KEY ke products.product_id
        $table->string('name');
        $table->text('description')->nullable();
        $table->timestamps();

        // FOREIGN KEY → ke products.product_id
        $table->foreign('product_id')->references('product_id')->on('product')->onDelete('cascade');

    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
