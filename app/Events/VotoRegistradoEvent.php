<?php

namespace App\Events;

use App\Models\Votacion;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class VotoRegistradoEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Votacion $votacion;
    public array $conteo;

    public function __construct(Votacion $votacion, array $conteo)
    {
        $this->votacion = $votacion;
        $this->conteo = $conteo;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('votacions');
    }

    public function broadcastAs(): string
    {
        return 'voto-registrado';
    }
}
