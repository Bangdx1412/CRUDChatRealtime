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

class ChatRieng implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $nguoiGui;
    public $nguoiNhan;
    public $noiDung;
    public function __construct(User $nguoiGui, User $nguoiNhan, $noiDung )
    {
        $this->nguoiGui = $nguoiGui;
        $this->nguoiNhan = $nguoiNhan;
        $this->noiDung = $noiDung;
    }
    public function broadcastOn()
    {
        return new PrivateChannel('chatPrivate.' . $this->nguoiGui->id. "." . $this->nguoiNhan->id );
    }
}
