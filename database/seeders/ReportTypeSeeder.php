<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReportTypes\ReportTypes;
class ReportTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reportTypes = [
            [
                'name' => 'Ponchado',
                'code' => 'ponchado',
                'description' => 'Reporte de procesos de ponchado.'
            ],
            [
                'name' => 'Doblado',
                'code' => 'doblado',
                'description' => 'Reporte de procesos de doblado.'
            ],
            [
                'name' => 'Insercion',
                'code' => 'insercion',
                'description' => 'Reporte de procesos de inserción.'
            ],
        ];

        foreach ($reportTypes as $type) {
            ReportTypes::firstOrCreate(
                ['code' => $type['code']], // evita duplicados usando el código
                $type
            );
        }
    }
}
