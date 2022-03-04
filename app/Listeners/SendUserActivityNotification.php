<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\UserActivityProcessed;
use App\Notifications\UserActivity;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendUserActivityNotification
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\UserActivityProcessed  $event
     * @return void
     */
    public function handle(UserActivityProcessed $event)
    {
        $admin = User::where('role_id', User::IS_ADMIN)->first();

        Notification::send($admin, new UserActivity($event->user, $event->modul, $event->data));
    }
}
