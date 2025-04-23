<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class ReceiveAnswer implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $to;
    public $from;
    public $answer;

    public function __construct($to, $from, $answer)
    {
        $this->to = $to;
        $this->from = $from;
        $this->answer = $answer;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("signal.{$this->to}");
    }

    public function broadcastAs(): string
    {
        return 'ReceiveAnswer';
    }

    public function broadcastWith()
    {
        return [
            'from' => $this->from,
            'answer' => $this->answer
        ];
    }
}
