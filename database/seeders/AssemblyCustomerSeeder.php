<?php

namespace Database\Seeders;

use App\Models\AssemblyCustomer\AssemblyCustomer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssemblyCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $customers = [
            ['customer_name'=>'Alliance','certifications'=>null,'logo_path'=>'logos/Alliance.png'],
            ['customer_name'=>'Amazon','certifications'=>null,'logo_path'=>'logos/Amazon.png'],
            ['customer_name'=>'Astro','certifications'=>null,'logo_path'=>'logos/Astro.png'],
            ['customer_name'=>'BrainCorporation','certifications'=>null,'logo_path'=>'logos/BrainCorporation.png'],
            ['customer_name'=>'Cassida','certifications'=>null,'logo_path'=>'logos/Cassida.png'],
            ['customer_name'=>'Celestica','certifications'=>null,'logo_path'=>'logos/Celestica.png'],
            ['customer_name'=>'Cirrus','certifications'=>null,'logo_path'=>'logos/Cirrus.png'],
            ['customer_name'=>'EatonSabran','certifications'=>null,'logo_path'=>'logos/EatonSabran.png'],
            ['customer_name'=>'EnviroSystems','certifications'=>null,'logo_path'=>'logos/EnviroSystems.png'],
            ['customer_name'=>'Flex','certifications'=>null,'logo_path'=>'logos/Flex.png'],
            ['customer_name'=>'Gets','certifications'=>null,'logo_path'=>'logos/Gets.png'],
            ['customer_name'=>'Insitu','certifications'=>null,'logo_path'=>'logos/Insitu.png'],
            ['customer_name'=>'IPCA-610','certifications'=>1,'logo_path'=>'logos/IPCA-610.png'],
            ['customer_name'=>'IPCA-620','certifications'=>1,'logo_path'=>'logos/IPCA-620.png'],
            ['customer_name'=>'IPCAWHMA','certifications'=>1,'logo_path'=>'logos/IPCAWHMA.png'],
            ['customer_name'=>'Nadcap','certifications'=>1,'logo_path'=>'logos/Nadcap.png'],
            ['customer_name'=>'ISO9001','certifications'=>1,'logo_path'=>'logos/ISO9001.png'],
            ['customer_name'=>'TUV','certifications'=>1,'logo_path'=>'logos/TUV.png'],
            ['customer_name'=>'AS9100','certifications'=>1,'logo_path'=>'logos/AS9100.png'],
            ['customer_name'=>'AST','certifications'=>1,'logo_path'=>'logos/AST.png'],
            ['customer_name'=>'ParallelFliGht','certifications'=>1,'logo_path'=>'logos/ParallelFliGht.png'],
            ['customer_name'=>'Backbar','certifications'=>1,'logo_path'=>'logos/Backbar.png'],
            ['customer_name'=>'ITT','certifications'=>null,'logo_path'=>'logos/ITT.png'],
            ['customer_name'=>'Jayco','certifications'=>null,'logo_path'=>'logos/Jayco.png'],
            ['customer_name'=>'JCM','certifications'=>null,'logo_path'=>'logos/JCM.png'],
            ['customer_name'=>'L3Harris','certifications'=>null,'logo_path'=>'logos/L3Harris.png'],
            ['customer_name'=>'Meggitt','certifications'=>null,'logo_path'=>'logos/Meggitt.png'],
            ['customer_name'=>'Nordson','certifications'=>null,'logo_path'=>'logos/Nordson.png'],
            ['customer_name'=>'OneStop','certifications'=>null,'logo_path'=>'logos/OneStop.png'],
            ['customer_name'=>'P.L.Porter','certifications'=>null,'logo_path'=>'logos/P.L.Porter.png'],
            ['customer_name'=>'ParproTechnologies','certifications'=>null,'logo_path'=>'logos/ParproTechnologies.png'],
            ['customer_name'=>'PrintroniX','certifications'=>null,'logo_path'=>'logos/PrintroniX.png'],
            ['customer_name'=>'RainBird','certifications'=>null,'logo_path'=>'logos/RainBird.png'],
            ['customer_name'=>'Synaptive','certifications'=>null,'logo_path'=>'logos/Synaptive.png'],
            ['customer_name'=>'Telamco','certifications'=>null,'logo_path'=>'logos/Telamco.png'],
            ['customer_name'=>'Toshiba','certifications'=>null,'logo_path'=>'logos/Toshiba.png'],
            ['customer_name'=>'TTElectronics','certifications'=>null,'logo_path'=>'logos/TTElectronics.png'],
            ['customer_name'=>'Wescam','certifications'=>null,'logo_path'=>'logos/Wescam.png'],
        ];

        foreach ($customers as $customer) {
            AssemblyCustomer::create($customer);
        }
    }
}
