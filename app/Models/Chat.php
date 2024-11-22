<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
        'is_deleted',
        'is_edited',
        'deletet_from_sender',
        'deletet_from_receiver',
    ];
}
