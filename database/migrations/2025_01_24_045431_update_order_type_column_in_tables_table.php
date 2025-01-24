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
        Schema::table('sales', function (Blueprint $table) {
            // Drop the existing enum column
            $table->dropColumn('order_type');
        });

        Schema::table('sales', function (Blueprint $table) {
            // Add the new string column
            $table->string('order_type')->nullable()->after('delivery_charge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Drop the string column
            $table->dropColumn('order_type');
        });

        Schema::table('sales', function (Blueprint $table) {
            // Recreate the enum column
            $table->enum('order_type', ['dine_in', 'takeaway', 'delivery'])
                  ->nullable()->after('delivery_charge');
        });
    }
};
