<?php

namespace App\Events;

use App\Models\Votacion;
use App\Models\Voto;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VotacionCerrada implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $votacion;

    public function __construct(Votacion $votacion)
    {
        $this->votacion = $votacion;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('votar');
    }

    public function broadcastAs()
    {
        return 'votacion.cerrada';
    }
    public function broadcastWith(): array
    {
            return [
                "votacion_id" => $this->votacion->id,
        ];
    }
}
