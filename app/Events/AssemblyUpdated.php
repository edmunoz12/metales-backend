<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssemblyUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $assembly;
    /**
     * Create a new event instance.
     */
    public function __construct($assembly)
    {
        $this->assembly = $assembly;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn(): array
    {
        return [new Channel('assemblies')];
    }

    public function broadcastAs(): string
    {
        return 'AssemblyUpdated';
    }
}
