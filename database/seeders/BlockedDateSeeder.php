<?php

namespace Database\Seeders;

use App\Models\BlockedDate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlockedDateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BlockedDate::create([
            'date' => '2025-07-23 00:00:00'
        ]);

        BlockedDate::create([
            'date' => '2025-07-25 00:00:00'
        ]);

        BlockedDate::create([
            'date' => '2025-07-21 00:00:00'
        ]);
    }
}
