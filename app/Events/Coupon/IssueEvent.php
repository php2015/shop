<?php

namespace App\Events\Coupon;

use Illuminate\Queue\SerializesModels;

class IssueEvent
{
    use SerializesModels;

    public function __construct()
    {
        //
    }
}
