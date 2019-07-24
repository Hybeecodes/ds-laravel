<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserActivationEmail;
use App\Mail\ConfirmAccount;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendActivatioEmail
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
     * @param  UserActivationEmail  $event
     * @return void
     */
    public function handle(UserActivationEmail $event)
    {
        //
        Mail::to($event->user['email'])->send(new ConfirmAccount($event->user));
    }
}
