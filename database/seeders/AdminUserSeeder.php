<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'first_name' => 'Admin',
            'last_name'  => 'Root',
            'email'      => 'admin@example.com',
            'phone'      => '0160828908',
            'ifu'        => '23456789122',
            'password'   => Hash::make('motdepasseadmin'), // Choisissez un mot de passe sécurisé
            'user_type'  => 'admin',
        ]);
    }
}
