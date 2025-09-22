<?php
// app/Events/CommandStatusUpdated.php
namespace App\Events;

use App\Models\Command;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CommandStatusUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public $command;

    public function __construct(Command $command)
    {
        $this->command = $command->load('details.product');
    }

    public function broadcastOn()
    {
        return new Channel('commands');
    }
}
