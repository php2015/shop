<?php

namespace App\Events\Admin;

use App\Logics\Admin\Admin;
use Illuminate\Queue\SerializesModels;

class LoginSuccessEvent
{
    use SerializesModels;

    public $admin;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }
}
