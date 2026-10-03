<?php

namespace Database\Seeders;

use App\Models\Barangay;
use Illuminate\Database\Seeder;

class BarangaySeeder extends Seeder
{
    public function run(): void
    {
        $barangays = [
            'Can-Uguib',
            'Buntay',
            'Sta. Fe',
            'Loyonsawang',
            'Victory',
        ];

        foreach ($barangays as $name) {
            Barangay::create([
                'name' => $name,
            ]);
        }
    }
}