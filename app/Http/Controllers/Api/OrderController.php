<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Order;
use App\Logics\Api\Payment;
use App\Logics\Api\StoreAddress;
use App\Logics\Api\Setting;

class OrderController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            Order::getList()
        );
    }

    public function confirm()
    {
        $this->validate([
            'sku' => 'required|string',
            'address' => 'required|int',
            'method' => 'required|int',
            'lon' => 'required|string',
            'lat' => 'required|string',
        ]);

        // 系统支持的配送方式
        $setting = Setting::getInstance('logistics.base')->fetch();
        $methods = isset($setting['method']) && count($setting['method']) > 0 ? $setting['method'] : [10];

        $sku = $this->request->post('sku');
        $address = $this->request->post('address'); // 用户地址ID
        $method = $this->request->post('method'); // 选择的配送方式
        $method = empty($method) ? $methods[0] : $method;
        $order = Order::confirm($sku, $address, $method);
        $fetch = StoreAddress::getFetchDistance(
            $this->request->post('lon'),
            $this->request->post('lat')
        );

        // 订阅消息模板
        $messageSetting = Setting::getInstance('message.wxapp')->fetch();
        $template = Setting::getTemplateByKeys($messageSetting, ['ORDER_SHIPMENT']);

        $this->renderSuccess([
            'methods' => $methods,
            'order' => $order,
            'location' => $fetch,
            'template' => $template
        ]);
    }

    public function create()
    {
        $this->validate([
            'method' => 'required|int', // sku
            'order' => 'required|string', // sku
            'coupon' => 'required|int', // 优惠劵ID
            'discount' => 'required|numeric', // 优惠金额合计
            'logistics' => 'required|numeric', // 物流费
            'price' => 'required|numeric', // 商品总价
            'payment' => 'required|numeric', // 实际支付价格
            'invoice' => 'required|numeric', // 是否开具发票
            'address' => 'int', // 用户地址ID
            'contact' => 'string',// 自提联系人
            'phone' => 'string', // 自提联系人手机号
            'day' => 'int', // 自提天
            'time' => 'string', // 自提时间
            'location' => 'int', // 自提点ID
            'remark' => 'string', // 备注信息
            'source' => 'int', // 来自那个客户端提交的订单
        ]);

        if ($order = Order::create($this->request->post())) {
            if ($result = Payment::order($order)) {
                $result['id'] = $order->id;
                $this->renderSuccess($result);
            }
        }
        $this->renderError();
    }

    public function detail()
    {
        $this->validate([
            'id' => 'required|integer',
        ]);

        $detail = Order::detail($this->request->get('id'));
        $setting = Setting::getInstance('app.order')->fetch();
        $close = isset($setting['close']) ? $setting['close'] : 0;
        $order_time = strtotime($detail->order_time) + $close * 60;
        $detail->close = $order_time - time();

        $this->renderSuccess( $detail );
    }

    public function close()
    {
        $this->validate([
            'id' => 'required|integer',
        ]);

        if (Order::close($this->request->post('id'))) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    public function receive()
    {
        $this->validate([
            'id' => 'required|integer',
        ]);

        if (Order::receive($this->request->post('id'))) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    public function remove()
    {
        $this->validate([
            'id' => 'required|integer',
        ]);

        if ($order = Order::remove($this->request->post('id'))) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    public function comment()
    {
        $this->validate([
            'id' => 'required|integer',
            'data' => 'required|string',
        ]);

        if ($order = Order::commenting($this->request->all())) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    /**
     * 核销码
     */
    public function code()
    {
        $this->validate([
            'id' => 'required|integer',
        ]);

        $this->renderSuccess([
            'encode' => Order::makeCode($this->request->get('id'))
        ]);
    }

    /**
     * 核销
     */
    public function fetch()
    {
        $this->validate([
            'id' => 'required|integer',
        ]);

        $this->renderSuccess(
            Order::userFetch($this->request->get('id'))
        );
    }
}
