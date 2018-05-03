<?php

namespace App\Policies;

use App\Event;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Event $event)
    {
        return $user->id == $event->user_id;
    }

    public function destroy(User $user, Event $event)
    {
        return $user->id == $event->user_id;
    }
}
