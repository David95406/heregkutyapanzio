<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        DB::table('settings')->insert([
            'key' => 'graphApiKey',
            'value' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('settings')->insert([
            'key' => 'numberOfPosts',
            'value' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);*/

        DB::table('settings')->insert([
            'key' => 'about1',
            'value' => "Koss Krisztina Zsuzsanna vagyok, világéletemben voltak állataim. 30 éves kutya nevelői és kiképzői tapasztalattal vállalom kutyák illetve kisállatok (macskák, rágcsálók, madarak akár haszonállatok) gondozását saját valamint az állatok otthonában egyaránt.",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('settings')->insert([
            'key' => 'about2',
            'value' => "Második bekezdés tartalma...",
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
