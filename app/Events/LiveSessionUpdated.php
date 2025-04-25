<?php

namespace App\Events;

use App\Models\LiveSession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class LiveSessionUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $session;

    public function __construct(LiveSession $session)
    {
        $this->session = $session->load('user');
    }

    public function broadcastOn()
    {
        return new Channel('study-room');
    }

    public function broadcastAs()
    {
        return 'LiveSessionUpdated';
    }
}
