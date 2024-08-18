<?php

namespace Database\Seeders;

use App\Models\Hobby;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Hobby::create([
            'name' => 'Badminton'
        ]);

        Hobby::create([
            'name' => 'Ngoding'
        ]);

        Hobby::create([
            'name' => 'Futsal'
        ]);

        Hobby::create([
            'name' => 'Kopdar'
        ]);
    }
}
