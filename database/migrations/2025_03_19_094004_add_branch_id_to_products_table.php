<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable()->after('supplier_id'); // Adding the column after 'supplier_id'
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null'); // Adding foreign key constraint
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['branch_id']); // Drop foreign key
            $table->dropColumn('branch_id');   // Drop column
        });
    }
};
