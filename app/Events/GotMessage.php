<?php
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GotMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $senderId;
    public $receiverId;
    public $message;

    public function __construct($senderId, $receiverId, $message)
    {
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->message = $message;
    }

    // Dinamik kanal nomi
    public function broadcastOn()
    {
        // Kanal nomini receiver_idga asoslab dinamik qilish
        return new PrivateChannel("chat.{$this->receiverId}");
    }

    public function broadcastWith()
    {
        // Xabar va boshqa ma'lumotlarni uzatish
        return [
            'message' => $this->message,
            'sender_id' => $this->senderId,
            'receiver_id' => $this->receiverId,
        ];
    }
}
