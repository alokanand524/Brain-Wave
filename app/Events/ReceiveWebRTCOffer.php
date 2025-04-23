<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ReceiveWebRTCOffer implements ShouldBroadcast
{
    use SerializesModels;

    public $from, $to, $offer;

    public function __construct($from, $to, $offer)
    {
        $this->from = $from;
        $this->to = $to;
        $this->offer = $offer;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel("signal.{$this->to}");
    }

    public function broadcastAs(): string
    {
        return "ReceiveOffer";
    }
}
