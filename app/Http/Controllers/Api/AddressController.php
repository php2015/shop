<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Address;

class AddressController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Address::getList()
        );
    }

    public function detail()
    {
        $this->renderSuccess(
            Address::detail($this->request->get('id'))
        );
    }

    public function save()
    {
        $this->validate([
            'contact' => 'required|string',
            'phone' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'detail' => 'required|string',
        ]);

        if (Address::saveData( $this->request->all() )) {
            $this->renderSuccess([], '地址保存成功');
        }
        $this->renderError();
    }

    public function remove()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (Address::remove($this->request->post('id')) === true) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    public function default()
    {
        $this->renderSuccess(
            Address::default()
        );
    }
}