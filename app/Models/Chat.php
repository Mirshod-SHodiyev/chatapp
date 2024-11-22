<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function getTimeAttribute(): string
    {
        return date(
            'H:i',
            strtotime($this->attributes['created_at'])
        );
    }
}
