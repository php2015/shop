<?php

namespace App\Http\Controllers\Web;

use Illuminate\Routing\Controller as BaseController;
use DB;

class IndexController extends BaseController
{
    public function index()
    {
        return view('welcome');
    }

    public function test()
    {

    }
}