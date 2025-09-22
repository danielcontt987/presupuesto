<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChangeEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function broadcastOn()
    {
        return new Channel('cook-items'); // canal público
    }

    public function broadcastAs()
    {
        return 'OrderStatusChangeEvent';
    }
}
