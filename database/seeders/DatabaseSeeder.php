<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        if (!\App\Models\User::where('email', 'admin@admin.com')->exists()) {
            \App\Models\User::factory()->create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'role_type' => 'Admin',
                'password' => Hash::make('Mn2#yx4'),
            ]);
        }

        if (!\App\Models\User::where('email', 'manager@manager.com')->exists()) {
            \App\Models\User::factory()->create([
                'name' => 'manager',
                'email' => 'manager@manager.com',
                'role_type' => 'Manager',
                'password' => Hash::make('JvP0sMgr'),
            ]);
        }

        if (!\App\Models\User::where('email', 't1@cashier.com')->exists()) {
            \App\Models\User::factory()->create([
                'name' => 't1',
                'email' => 't1@cashier.com',
                'role_type' => 'Cashier',
                'password' => Hash::make('JvP0sT1'),
            ]);
        }

        if (!\App\Models\User::where('email', 'demo@demo.com')->exists()) {
            \App\Models\User::factory()->create([
                'name' => 'demo',
                'email' => 'demo@demo.com',
                'role_type' => 'Admin',
                'password' => Hash::make('demo'),
            ]);
        }

        
        
        // $this->call([
        //     ColorSeeder::class,
        //     SizeSeeder::class,
        // ]);
    }
}
