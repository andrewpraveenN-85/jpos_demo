<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReturnReason;

class ReturnReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $reasons = [
            ['reason' => 'Damaged Product'],
            ['reason' => 'Customer Changed Their Mind'],
            ['reason' => 'Returning a New Product'],
           ];

        ReturnReason::insert($reasons);
    }
}
