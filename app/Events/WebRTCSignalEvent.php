<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebRTCSignalEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $from, $to, $type, $sdp, $candidate;

    public function __construct($from, $to, $type, $sdp = null, $candidate = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->type = $type;
        $this->sdp = $sdp;
        $this->candidate = $candidate;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('live-signal.' . $this->to);
    }

    public function broadcastWith(): array
    {
        return [
            'from' => $this->from,
            'type' => $this->type,
            'sdp' => $this->sdp,
            'candidate' => $this->candidate,
        ];
    }
    
}

