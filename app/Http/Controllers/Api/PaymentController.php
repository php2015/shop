<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Order;
use App\Logics\Api\Payment;
use Log;

class PaymentController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        $this->validate([
            'order_id' => 'required|int',
        ]);

        $order = Order::detail( $this->request->post('order_id') );
        if ($result = Payment::order( $order )) {
            $this->renderSuccess($result);
        }
        $this->renderError();
    }

    public function notify()
    {
        return Payment::notify();
    }
}