<?php

namespace App\Events\Printer;

use App\Logics\Admin\Printer;
use Illuminate\Queue\SerializesModels;

class RemoveEvent
{
    use SerializesModels;

    public $printer;

    public function __construct(Printer $printer)
    {
        $this->printer = $printer;
    }
}
