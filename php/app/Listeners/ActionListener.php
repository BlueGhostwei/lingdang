<?php

namespace App\Listeners;

use App\Events\Action;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActionListener
{
    public $mailer;

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Action  $event
     * @return void
     */
    public function handle(Action $event)
    {
        dd($event);
    }
}
