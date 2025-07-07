<?php

namespace Database\Seeders;

use App\Models\AccommodationType;
use App\Models\AnimalType;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        AnimalType::insert([
            ['name' => 'Kutya'],
            ['name' => 'Macska'],
        ]);

        AccommodationType::insert([
            ['name' => 'Kenel', 'capacity' => 10],
            ['name' => 'Házon belüli', 'capacity' => 5],
        ]);

        Setting::create([
            'key' => 'graph_api_key',
            'value' => 'ide_kerul_a_valos_kulcs',
        ]);

        Service::insert([
            ['name' => 'Napközi', 'price' => 5000],
            ['name' => 'Panzió', 'price' => 9000],
        ]);
    }
}
