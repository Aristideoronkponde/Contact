<?php

namespace App\Listeners;

use App\Events\ContactDeletedEvent;
use App\Notifications\ContactDeletedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class ContactDeletedListener
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
    
    public function handle(ContactDeletedEvent $event): void
    {
        $user = Auth::user();
        if ($user) {
            $user->notify(new ContactDeletedNotification($event->contact));
        }
    }
}
