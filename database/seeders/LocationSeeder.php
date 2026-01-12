<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locationsData = [
            'TURRET (Troqueladora)' => ['P1','P2','P3','PC4','P5','P6','P7','PC8','F1','F2','F3'],
            'Dobladoras' => ['BP1','PB2','PB3','PB4','PB5','PB6','PB7','PB8','PB9','PB10','PB11','PB12','PB13','PB14'],
            'Insertadora' => ['H01','H02','H03','H04','H05','H06','H07','H08'],
            'Toolcrip' => ['Rack 1','Rack 2','Rack 3'],
        ];

        $codeCounter = 1;

        foreach ($locationsData as $description => $names) {
            foreach ($names as $name) {
                Location::firstOrCreate(
                    ['name' => $name], // evita duplicados por nombre
                    [
                        'description' => $description,
                        'code' => 'LOC-' . str_pad($codeCounter, 3, '0', STR_PAD_LEFT),
                    ]
                );
                $codeCounter++;
            }
        }
    }
}
