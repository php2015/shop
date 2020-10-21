<?php

namespace App\Events\Cash;

use App\Logics\Admin\DistributionCash;
use Illuminate\Queue\SerializesModels;

class SuccessEvent
{
    use SerializesModels;

    public $cash;

    public function __construct(DistributionCash $cash)
    {
        $this->cash = $cash;
    }
}
