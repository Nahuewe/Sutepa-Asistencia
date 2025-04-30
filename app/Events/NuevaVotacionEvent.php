<?php

namespace App\Events;

use App\Models\Votacion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NuevaVotacionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Votacion $votacion;

    public function __construct(Votacion $votacion)
    {
        $this->votacion = $votacion;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('votacions');
    }

    public function broadcastAs(): string
    {
        return 'nueva-votacion';
    }
}
