<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Cedeño Zepeda Alberto',
                'email' => 'czalberto',
                'user_type_id' => 5,
                'password' => Hash::make('operadorPE1'),
            ],
            [
                'name' => 'Castillo Ramirez Carlos Alberto',
                'email' => 'crcarlos',
                'user_type_id' => 5,
                'password' => Hash::make('operadorPE2'),
            ],
            [
                'name' => 'Garcia Rivera Benjamin',
                'email' => 'grbenjamin',
                'user_type_id' => 5,
                'password' => Hash::make('operadorPE3'),
            ],
            [
                'name' => 'Ochoa Quiñones Claudia',
                'email' => 'oqclaudia',
                'user_type_id' => 5,
                'password' => Hash::make('operadorPE4'),
            ],
            [
                'name' => 'Felix Gonzalez Ricardo',
                'email' => 'fgricardo',
                'user_type_id' => 5,
                'password' => Hash::make('operadorPE5'),
            ],
            [
                'name' => 'Algandar Juventino',
                'email' => 'ajuventino',
                'user_type_id' => 5,
                'password' => Hash::make('operadorPE7'),
            ],
            [
                'name' => 'Casandra Vega',
                'email' => 'cvega',
                'user_type_id' => 5,
                'password' => Hash::make('operadorPE8'),
            ],
            [
                'name' => 'Jimenez Uriel',
                'email' => 'juriel',
                'user_type_id' => 5,
                'password' => Hash::make('operadorPE9'),
            ],
            [
                'name' => 'Daniel Reyes',
                'email' => 'dreyes',
                'user_type_id' => 5,
                'password' => Hash::make('operadorPE10'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
