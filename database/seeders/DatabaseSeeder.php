<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'sadam',
            'password' => bcrypt('sadam123'),
            'email' => 'hehe@gmail.com',
            'role' => 'admin',
            'foto' => '1709185552.png',
            'nik' => 1029948,
            'jenis_kelamin' => 'Laki Laki'
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
