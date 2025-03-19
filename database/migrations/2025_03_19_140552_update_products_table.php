<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Add branch_id column only if it does not exist
            if (!Schema::hasColumn('products', 'branch_id')) {
                $table->unsignedBigInteger('branch_id')->nullable()->after('supplier_id');
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            }
        });

        // Drop unique constraints only if they exist
        $this->dropIndexIfExists('products', 'products_barcode_unique');
        $this->dropIndexIfExists('products', 'products_code_unique');

        Schema::table('products', function (Blueprint $table) {
            // Add composite unique constraints
            $table->unique(['barcode', 'branch_id'], 'barcode_branch_unique');
            $table->unique(['code', 'branch_id'], 'code_branch_unique');
        });
    }

    public function down()
    {
        // Drop composite unique constraints safely
        $this->dropIndexIfExists('products', 'barcode_branch_unique');
        $this->dropIndexIfExists('products', 'code_branch_unique');

        Schema::table('products', function (Blueprint $table) {
            // Drop branch_id column if it exists
            if (Schema::hasColumn('products', 'branch_id')) {
                $table->dropForeign(['branch_id']);
                $table->dropColumn('branch_id');
            }

            // Restore original unique constraints safely
            $table->unique('barcode');
            $table->unique('code');
        });
    }

    /**
     * Helper function to safely drop an index if it exists.
     */
    private function dropIndexIfExists(string $table, string $index)
    {
        $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$index]);
        if (!empty($indexes)) {
            Schema::table($table, function (Blueprint $table) use ($index) {
                $table->dropUnique($index);
            });
        }
    }
};
