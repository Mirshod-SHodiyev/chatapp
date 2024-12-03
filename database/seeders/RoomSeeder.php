<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
       
        Room::create([
            'type' => 'private',
        ]);
        
        Room::create([
            'type' => 'group',
        ]);
    }
}
