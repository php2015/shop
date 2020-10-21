<?php

namespace App\Events\User;

use Illuminate\Queue\SerializesModels;
use App\Logics\Api\User;

class InviteEvent
{
    use SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
