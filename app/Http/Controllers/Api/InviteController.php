<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Setting;
use App\Logics\Api\Invite;

class InviteController extends Controller
{
    public function index()
    {
        $this->renderSuccess([
            'setting' => Setting::getInstance('app.invite')->fetch(),
            'count' => Invite::count()
        ]);
    }

    public function poster()
    {
        $this->validate([
            'url' => 'required|string',
        ]);

        $this->renderSuccess([
            'encode' => Invite::makePoster($this->request->post('url'))
        ]);
    }
}