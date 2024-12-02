<?php
namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GotMessage implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message) {
        $this->message = $message;
    }

    public function broadcastOn() {
        return new PrivateChannel("room.1");
    }

    public function broadcastWith() {
        return [
            'message' => $this->message,
        ];
    }
}
