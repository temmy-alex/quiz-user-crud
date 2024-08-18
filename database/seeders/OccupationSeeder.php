<?php

namespace Database\Seeders;

use App\Models\Occupation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Occupation::create([
            'name' => 'Programmer'
        ]);

        Occupation::create([
            'name' => 'Network Engineer'
        ]);

        Occupation::create([
            'name' => 'DevOps Engineer'
        ]);

        Occupation::create([
            'name' => 'Site Reliability Engineer'
        ]);
    }
}
