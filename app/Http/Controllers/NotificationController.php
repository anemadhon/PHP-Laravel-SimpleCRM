<?php

namespace App\Http\Controllers;

class NotificationController extends Controller
{
    public function lists()
    {
        return view('notification', [
            'notifications' => auth()->user()->unreadNotifications
        ]);
    }

    public function markAsRead($notificationId)
    {
        auth()->user()->unreadNotifications->where('id', $notificationId)->markAsRead();

        return back();
    }
}
