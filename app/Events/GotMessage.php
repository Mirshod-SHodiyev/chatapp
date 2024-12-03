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

    public $message;
    public $roomId;  

    public function __construct($message, $roomId)
    {
        $this->message = $message;
        $this->roomId = $roomId;
    }

    public function broadcastOn()
    {
        
        return new PrivateChannel("room.{$this->roomId}");
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
    }
}
