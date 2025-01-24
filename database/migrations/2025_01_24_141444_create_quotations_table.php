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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();

            $table->string('quotation_number')->unique();
            $table->string('customer_id')->unique();
            $table->string('product_name');
            $table->decimal('product_unit_price', 15, 2);
            $table->integer('product_quantity');
            $table->date('issue_date');
            $table->decimal('product_total', 15, 2);
            $table->decimal('discount', 15, 2);
            $table->text('additional_notes')->nullable();
            $table->decimal('grand_total', 15, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
