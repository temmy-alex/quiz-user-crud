<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'User 1',
            'email' => 'user@mail.com',
            'password' => bcrypt('rahasia123'),
            'photo' => 'noimage.png',
            'document' => 'document.pdf',
            'occupation_id' => 1,
            'gender' => 'male'
        ]);
    }
}
