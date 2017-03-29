<?php

namespace App\Listeners;

use Request;
use App\Events;
use Input;
use App\Models\User;
use App\Models\UserHistory;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuthLoginListener
{

    /**
     * Create the event handler.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param User $user
     * @param $remember
     *
     * @return User
     */
    public function handle(User $user, $remember)
    {
      // dd($user);
        UserHistory::create(array(
            'user_id' => $user->id,
            'name' => $user->name,
            'ip' => Request::getClientIp(),
            'user_agent' => Request::server('HTTP_USER_AGENT'),
        ));

        return $user;
    }
}
