<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Checkin;

class CheckinController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Checkin::calendar()
        );
    }

    public function save()
    {
        $this->renderSuccess(
            Checkin::saveData()
        );
    }
}