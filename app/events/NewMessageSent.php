<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\MessageContent;

class NewMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The message instance.
     *
     * @var \App\Models\MessageContent
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MessageContent $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Broadcast on a private channel for the specific message group.
        // This ensures only participants in the conversation receive the message.
        return new PrivateChannel('chat.' . $this->message->group_id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'group_id' => $this->message->group_id,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->message->senderDispName, // Using your existing accessor
            'message' => $this->message->message,
            'datetime' => $this->message->created_at,
        ];
    }
}