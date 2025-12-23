<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier\Supplier;
class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Amada',
                'description' => 'Proveedor Amada'
            ],
            [
                'name' => 'Wilson',
                'description' => 'Proveedor Wilson'
            ],
            [
                'name' => 'Mate',
                'description' => 'Proveedor Mate'
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate(
                ['name' => $supplier['name']], // evita duplicados por nombre
                $supplier
            );
        }
    }
}
