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

   if (!\App\Models\User::where('email', 'rishan@admin.com')->exists()) {
    \App\Models\User::factory()->create([
        'name' => 'Rishan',
        'email' => 'rishan@admin.com',
        'role_type' => 'Admin',
        'password' => Hash::make('nR^v36z6?Dec'),
    ]);
}

if (!\App\Models\User::where('email', 'ushan@manager.com')->exists()) {
    \App\Models\User::factory()->create([
        'name' => 'Ushan',
        'email' => 'ushan@manager.com',
        'role_type' => 'Manager',
        'password' => Hash::make('74!302PGbkN'),
    ]);
}



if (!\App\Models\User::where('email', 'minusha@manager.com')->exists()) {
    \App\Models\User::factory()->create([
        'name' => 'Minusha',
        'email' => 'minusha@manager.com',
        'role_type' => 'Manager',
        'password' => Hash::make('nNP(0$441f8C'),
    ]);
}

if (!\App\Models\User::where('email', 'dharshana@manager.com')->exists()) {
    \App\Models\User::factory()->create([
        'name' => 'Dharshana',
        'email' => 'dharshana@manager.com',
        'role_type' => 'Manager',
        'password' => Hash::make('f{7(3xv8K37A'),
    ]);
}
if (!\App\Models\User::where('email', 'sasini@manager.com')->exists()) {
    \App\Models\User::factory()->create([
        'name' => 'Sasini',
        'email' => 'sasini@manager.com',
        'role_type' => 'Manager',
        'password' => Hash::make('b479+4N]xStm'),
    ]);
}
if (!\App\Models\User::where('email', 'dilrukshi@manager.com')->exists()) {
    \App\Models\User::factory()->create([
        'name' => 'Dilrukshi',
        'email' => 'dilrukshi@manager.com',
        'role_type' => 'Manager',
        'password' => Hash::make('Vty5y9;a=OO7'),
    ]);
}






if (!\App\Models\User::where('email', 'sadeepa@cashier.com')->exists()) {
    \App\Models\User::factory()->create([
        'name' => 'Sadeepa',
        'email' => 'sadeepa@cashier.com',
        'role_type' => 'Cashier',
        'password' => Hash::make('CR0-i,9r2\g}'),
    ]);
}


if (!\App\Models\User::where('email', 'thisandi@cashier.com')->exists()) {
    \App\Models\User::factory()->create([
        'name' => 'Thisandi',
        'email' => 'thisandi@cashier.com',
        'role_type' => 'Cashier',
        'password' => Hash::make('06!Hj1a?5jn$'),
    ]);
}





if (!\App\Models\User::where('email', 'lakshitha@cashier.com')->exists()) {
    \App\Models\User::factory()->create([
        'name' => 'Lakshitha',
        'email' => 'lakshitha@cashier.com',
        'role_type' => 'Cashier',
        'password' => Hash::make('5ro7DI5|6ZMu'),
    ]);
}

    }
}
