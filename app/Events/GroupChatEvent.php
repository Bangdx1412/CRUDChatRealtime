<?php

namespace App\Events;

use App\Models\GroupChat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;


class GroupChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

   public $group;
   public $user;
   public $message;
    public function __construct(GroupChat $group, User $user, $message)
    {
        $this->group = $group;
        $this->user = $user;
        $this->message = $message;
    }

    
    public function broadcastOn()
    {
        return 
            new PrivateChannel('chatGroup.' . $this->group->id);
      
    }
}
