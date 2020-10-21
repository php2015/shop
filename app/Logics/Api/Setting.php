<?php

namespace App\Logics\Api;

use App\Models\Setting as SettingModel;

class Setting extends SettingModel
{
    /**
     * 处理热门搜索
     */
    public function fetchAppSearch()
    {
        $this->values->hot = explode("\n", $this->values->hot);
    }
}
