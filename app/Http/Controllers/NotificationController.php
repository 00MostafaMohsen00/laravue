<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(10)->withQueryString();
        return inertia('Notifications/Index', [
            'notifications' => $notifications
        ]);
    }


    public function edit(string $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->route('notifications.index')->with('success', __('lang.marked_as_read'));
    }
}
