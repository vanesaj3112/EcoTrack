<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GarbageCollectorSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'collector@ecotrack.test',
            ],
            [
                'name' => 'EcoTrack Garbage Collector',
                'mobile_number' => '09170000000',
                'password' => Hash::make('collector123'),
                'role' => 'garbage_collector',
                'status' => 'approved',
            ]
        );
    }
}
