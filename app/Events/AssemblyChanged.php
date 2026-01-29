<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssemblyChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public string $action;
    public array $assembly;
    /**
     * @param string $action create|update|delete
     * @param array $assembly
     */
    public function __construct(string $action, array $assembly)
    {
        $this->action = $action;
        $this->assembly = $assembly;
    }

    /**
     * Canal público
     */
    public function broadcastOn(): Channel
    {
        return new Channel('assemblies');
    }

    /**
     * Nombre del evento en el frontend
     */
    public function broadcastAs(): string
    {
        return 'assembly.changed';
    }

}
