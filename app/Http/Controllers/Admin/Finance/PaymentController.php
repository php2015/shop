<?php

namespace App\Http\Controllers\Admin\Finance;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $this->renderSuccess(Payment::getList());
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            Payment::detail($this->request->get('id'))
        );
    }
}