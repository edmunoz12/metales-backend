<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToolCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $codes = [];
        $letters = range('A', 'Z'); // Letras de A a Z
        $numbers = range(0, 9); // Números del 0 al 9

        // Generar códigos de 3 caracteres: dos letras + un número
        foreach ($letters as $first) {
            foreach ($letters as $second) {
                foreach ($numbers as $number) {
                    $codes[] = $first . $second . $number;
                }
            }
        }

        //  array 5000
        $codes = array_slice($codes, 0, 5000);

        // Insertar en la base de datos
        foreach ($codes as $code) {
            DB::table('tool_codes')->insert([
                'code' => $code,
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info(count($codes) . ' tool codes generated!');
    }
}
