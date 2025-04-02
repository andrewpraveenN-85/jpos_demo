<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        // Branch 1 - Nugegoda
        if (!\App\Models\User::where('email', 'manager1@branch.com')->exists()) {
            \App\Models\User::factory()->create([
                'name' => 'manager1',
                'email' => 'manager1@branch.com',
                'role_type' => 'Manager',
                'branch_id' => 1,
                'password' => Hash::make('JvP0sMgr'),
            ]);
        }
         // Branch 2 - Waththala
        if (!\App\Models\User::where('email', 'manager2@branch.com')->exists()) {
            \App\Models\User::factory()->create([
                'name' => 'manager2',
                'email' => 'manager2@branch.com',
                'role_type' => 'Manager',
                'branch_id' => 2,
                'password' => Hash::make('JvP1sMgr'),
            ]);
        }

        if (!\App\Models\User::where('email', 't1@cashier.com')->exists()) {
            \App\Models\User::factory()->create([
                'name' => 't1',
                'email' => 't1@cashier.com',
                'role_type' => 'Cashier',
                'branch_id' => 1,
                'password' => Hash::make('JvP0sT1'),
            ]);
        }

        if (!\App\Models\User::where('email', 't2@cashier.com')->exists()) {
            \App\Models\User::factory()->create([
                'name' => 't2',
                'email' => 't2@cashier.com',
                'role_type' => 'Cashier',
                'branch_id' => 2,
                'password' => Hash::make('JvP2sT1'),
            ]);
        }
       
       
    }
}
