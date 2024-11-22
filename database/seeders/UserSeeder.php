<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin2022'),
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/149/149071.png',
        ]);
        
        User::create([
            'name' => 'Ali',
            'email' => 'ali@example.com',
            'password' => bcrypt('ali2024'),
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922510.png',
        ]);
        
        User::create([
            'name' => 'Aziz',
            'email' => 'aziz@example.com',
            'password' => bcrypt('aziz2023'),
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922565.png',
        ]);
        
        User::create([
            'name' => 'Bekzod',
            'email' => 'bekzod@example.com',
            'password' => bcrypt('bekzod123'),
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922506.png',
        ]);
        
        User::create([
            'name' => 'Dilshod',
            'email' => 'dilshod@example.com',
            'password' => bcrypt('dilshod123'),
            'avatar' => 'https://cdn-icons-png.flaticon.com/512/2922/2922570.png',
        ]);
        foreach(range(1, 15) as $i) {
            User::factory()->create();
            
        }
    }
}
