<?php

namespace App\Events;

use App\Models\Voto;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VotoEmitido implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $voto;
    public function __construct(Voto $voto)
    {
        Log::info("Evento VotoEmitido creado para el voto ID: " . $voto->id);
        $this->voto = $voto->load('opcion');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return new Channel('resultados');
    }

    public function broadcastAs()
    {
        return 'voto.emitido';
    }
    public function broadcastWith(): array
    {
            return [
            'voto' => $this->voto,
        ];
    }
}
