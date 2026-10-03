<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'LGU Administrator',
            'email' => 'admin@ecotrack.test',
            'password' => 'password123',
            'role' => 'lgu_admin',
            'status' => 'approved',
        ]);
    }
}
