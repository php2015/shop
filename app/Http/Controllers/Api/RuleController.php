<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Rule;

class RuleController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Rule::getAll()
        );
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|integer',
        ]);

        $this->renderSuccess(
            Rule::detail($this->request->get('id'))
        );
    }
}