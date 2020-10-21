<?php

namespace App\Events\Distribution;

use App\Logics\Admin\Distribution;
use Illuminate\Queue\SerializesModels;

class AuthEvent
{
    use SerializesModels;

    public $distribution;

    public function __construct(Distribution $distribution)
    {
        $this->distribution = $distribution;
    }
}
