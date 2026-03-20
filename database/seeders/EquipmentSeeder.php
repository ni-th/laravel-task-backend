<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipment;
use Carbon\Carbon;

class EquipmentSeeder extends Seeder
{
    public function run()
    {
        $equipment = [
            [
                'name' => 'Laptop A',
                'expiry_date' => Carbon::now()->addDays(15),
                'last_maintenance_date' => Carbon::now()->subMonths(3),
            ],
            [
                'name' => 'Laptop B',
                'expiry_date' => Carbon::now()->subDays(5),
                'last_maintenance_date' => Carbon::now()->subMonths(2),
            ],
            [
                'name' => 'Printer A',
                'expiry_date' => Carbon::now()->addDays(45),
                'last_maintenance_date' => Carbon::now()->subMonths(7),
            ],
            [
                'name' => 'Printer B',
                'expiry_date' => Carbon::now()->addDays(20),
                'last_maintenance_date' => Carbon::now()->subMonths(8),
            ],
            [
                'name' => 'Printer C',
                'expiry_date' => Carbon::now()->addMonths(6),
                'last_maintenance_date' => Carbon::now()->subMonths(1),
            ],
        ];

        foreach ($equipment as $item) {
            Equipment::create($item);
        }
    }
}