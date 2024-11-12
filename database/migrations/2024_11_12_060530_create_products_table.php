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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->decimal('cost_price', 8, 2);
            $table->decimal('selling_price', 8, 2);
            $table->integer('stock_quantity');
            $table->string('barcode')->unique();
            $table->foreignId('supplier_id');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
