<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Chat;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        chat::create([
             'room_id' => 1,
            'sender_id' => 1,
            'receiver_id' => 2,
            'message' => 'Hello World',
        ]);
        
        chat::create([
            'room_id' => 1,
            'sender_id' => 2,
            'receiver_id' => 1,
            'message' => 'Hello World',
        ]);
        
        chat::create([
            'room_id' => 2,
            'sender_id' => 1,
            'receiver_id' => 3,
            'message' => 'Hello World',
        ]);
        
        chat::create([
            'room_id' => 2,
            'sender_id' => 3,
            'receiver_id' => 1,
            'message' => 'Hello World',
        ]);
        
        chat::create([
            'room_id' => 3,
            'sender_id' => 2,
            'receiver_id' => 3,
            'message' => 'Hello World',
        ]);
        
        chat::create([
            'room_id' => 3,
            'sender_id' => 3,
            'receiver_id' => 2,
            'message' => 'Hello World',
        ]);
        
        chat::create([
            'room_id' => 4,
            'sender_id' => 1,
            'receiver_id' => 4,
            'message' => 'Hello World',
        ]);
        
        chat::create([
            'room_id' => 4,
            'sender_id' => 4,
            'receiver_id' => 1,
            'message' => 'Hello World',
        ]);
        
        chat::create([
            'room_id' => 5,
            'sender_id' => 2,
            'receiver_id' => 4,
            'message' => 'Hello World',
        ]);
        
        chat::create([
            'room_id' => 5,
            'sender_id' => 4,
            'receiver_id' => 2,
            'message' => 'Hello World',
        ]);
    }
}
