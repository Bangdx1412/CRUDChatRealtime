<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


use App\Events\UserSesstionChange;
use Illuminate\Auth\Events\Logout;

class BroadcastUserLogoutNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        broadcast(new UserSesstionChange($event->user .'offline','danger'));
    }
}
