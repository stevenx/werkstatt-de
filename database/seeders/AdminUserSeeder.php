<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@werkstatt.de',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@werkstatt.de');
        $this->command->info('Password: password');
    }
}
