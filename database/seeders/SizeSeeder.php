<?php

namespace Database\Seeders;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    public function run()
    {
        $sizes = ['XS', 'S', 'M', 'L', 'XL'];

        foreach ($sizes as $size) {
            // DB::table('sizes')->insert([
            //     'name' => $size,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);
            Size::updateOrCreate(
                ['name' => $size],
            );
        }
    }
}
