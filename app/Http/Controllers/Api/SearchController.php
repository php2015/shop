<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Search;

class SearchController extends Controller
{
    public function index()
    {
        Search::saveData();
    }

    public function clear()
    {
        Search::clearHistory();
    }

    public function history()
    {
        $this->renderSuccess(
            Search::getAll()
        );
    }
}