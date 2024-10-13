<?php

namespace App\Listeners;

use App\Events\CustomerRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Notification;

class SendAdminNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CustomerRegistered  $event
     * @return void
     */
    public function handle(CustomerRegistered $event)
    {
        $user = $event->user;

        Notification::create([
            'type' => 'info',
            'message' => 'New user registration: ' . $user->name,
        ]);
    }
 
}