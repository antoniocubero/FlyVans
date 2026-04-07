<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Caravana;

class CaravanaSeeder extends Seeder
{
    public function run(): void
    {
        Caravana::factory()
            ->count(50)
            ->create();
    }
}
