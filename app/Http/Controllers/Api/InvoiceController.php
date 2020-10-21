<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Invoice::info()
        );
    }

    public function save()
    {
        $this->validate([
            'category' => 'required|int',
            'title' => 'required|string',
            'phone' => 'regex:/^1[34578][0-9]{9}$/',
        ]);

        if ($order = Invoice::saveData($this->request->post())) {
            $this->renderSuccess();
        }
        $this->renderError();
    }
}