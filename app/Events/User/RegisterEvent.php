<?php

namespace App\Events\User;

use Illuminate\Queue\SerializesModels;
use App\Logics\Api\User;
use Event;

class RegisterEvent
{
    use SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;

        if ($this->user->parent_id > 0) {
            Event::dispatch(new InviteEvent($this->user));
        }
    }
}
