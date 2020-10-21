<?php

namespace App\Listeners\Goods;

use App\Events\Goods\ViewEvent;
use App\Logics\Api\GoodsHistory;

class ViewEventHistory
{
    public function handle(ViewEvent $event)
    {
        GoodsHistory::saveData($event->goods->id);
    }
}
