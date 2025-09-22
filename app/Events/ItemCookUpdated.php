<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\Command;

class ItemCookUpdated implements ShouldBroadcast
{
    use SerializesModels;

    // public $items;

    public function __construct()
    {
        // siempre mandamos TODAS las comandas actuales
    }

    public function broadcastOn()
    {
        return new Channel('cook-items'); // 👈 mismo canal que usas en Vue
    }
}
