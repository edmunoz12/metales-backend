<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ToolType\ToolType;

class ToolTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $toolTypes = [
            [
                'name' => 'Punzon',
                'description' => 'Tipo de herramienta Punzon.'
            ],
            [
                'name' => 'Matriz',
                'description' => 'Tipo de herramienta Matriz.'
            ],
        ];

        foreach ($toolTypes as $type) {
            ToolType::firstOrCreate(
                ['name' => $type['name']], // evita duplicados por name
                $type
            );
        }
    }
}
