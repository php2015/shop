<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\Controller;
use App\Logics\Admin\User;
use App\Logics\Admin\UserTag;

class UserController extends Controller
{
    public function index()
    {
        $this->renderSuccess(User::getList());
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $detail = User::detail($this->request->get('id'));
        $this->renderSuccess( $detail );
    }

    public function detailOrder()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            User::getOrderList( $this->request->get('id') )
        );
    }

    public function detailCoupon()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            User::getCouponList( $this->request->get('id') )
        );
    }

    public function detailPoints()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess( User::getPointsList( $this->request->get('id') ) );
    }

    public function detailBonus()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            User::getBonusList( $this->request->get('id') )
        );
    }

    public function detailCart()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            User::getCartList( $this->request->get('id') )
        );
    }

    public function detailLike()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            User::getLikeList( $this->request->get('id') )
        );
    }

    public function editTag()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess([
            'list' => UserTag::getAll(),
            'detail' => User::detail($this->request->get('id'))
        ]);
    }

    public function doEditTag()
    {
        $this->validate([
            'id' => 'required|int',
            'tag' => 'array',
        ]);

        if (User::editTag( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }

    public function editPoints()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        $this->renderSuccess(
            User::detail($this->request->get('id'))
        );
    }

    public function doEditPoints()
    {
        $this->validate([
            'id' => 'required|int',
            'points' => 'required|int',
            'intro' => 'required|string',
        ]);

        if (User::editPoints( $this->request->all() )) {
            $this->renderSuccess([], '操作成功');
        }
        $this->renderError([], '操作失败');
    }
}
