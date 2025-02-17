<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE sales MODIFY COLUMN payment_method ENUM('Cash', 'Card', 'Online', 'Split') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE sales MODIFY COLUMN payment_method ENUM('Cash', 'Card', 'Online') NOT NULL");
    }
};
