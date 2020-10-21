<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Points;
use App\Logics\Api\Setting;

class PointsController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Points::getList()
        );
    }

    public function setting()
    {
        $this->renderSuccess(
            Setting::getInstance('app.points')->fetch()
        );
    }
}