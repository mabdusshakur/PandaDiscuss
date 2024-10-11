<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $receiverId;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message, $receiverId)
    {
        $this->message = $message;
        $this->receiverId = $receiverId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return <int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notifications.' . $this->receiverId);
    }


    public function broadcastAs()
    {
        return 'MessageNotification';
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
            'sender_id' => $this->message->sender_id,
            'conversation_id' => $this->message->conversation_id,
        ];
    }
}