<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BelakangLogging
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $dataof;
    public $tipe;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($dataof, $tipe, $data = null)
    {
        $this->dataof = $dataof;
        $this->tipe = $tipe;
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [];
        // return new PrivateChannel('channel-name');
    }
}
