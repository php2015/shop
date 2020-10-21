<?php

namespace App\Logics\Api;

use App\Models\Payment as PaymentModel;
use App\Services\Payment\Factory;
use App\Events\Payment\SuccessEvent;
use DB;
use Event;
use Log;

class Payment extends PaymentModel
{
    /**
     * 普通订单支付
     * @param Order $order
     * @return mixed
     */
    public static function order(Order $order)
    {
        $model = new static;
        $model->payment_no = self::paymentNo();
        $model->payment_price = $order->payment_price;
        $model->payment_channel = $order->payment_channel;
        $model->payment_time = time();
        $model->order_type = self::ORDER_TYPE_DEFAULT;
        $model->client_ip = get_client_ip();
        $model->openid = self::getOpenId($order);
        $model->user_id = $order->user_id;
        $model->order_id = $order->id;
        $model->source = $order->source;
        $model->remark = '订单';
        $model->save();

        return Factory::getInstance(
            $model->toArray()
        )->payment();
    }

    /**
     * 根据订单来源返回用户openid(小程序的和公众号的)
     *
     * @param Order $order
     * @return mixed
     */
    private static function getOpenId(Order $order)
    {
        if ($order->source == $order::SOURCE_WECHAT) {
            return $order->user->wx->openid;
        } else if ($order->source == $order::SOURCE_WECHAT_APP) {
            return $order->user->wxapp->openid;
        }
    }

    /**
     * 微信回调
     * @return mixed
     */
    public static function notify()
    {
        $object = Factory::getInstance(
            ['payment_channel' => 20]
        );
        $result = $object->notify();
        $response = $object->getResponse();

        try {
            DB::beginTransaction();
            if ($payment = self::where('payment_no', $response->out_trade_no)->first()) {
                if ($payment->status == self::STATUS_OFF) {
                    $payment->transaction_id = $response->transaction_id;
                    $payment->status = self::STATUS_ON;
                    $payment->save();
                    Event::dispatch(new SuccessEvent($payment));
                }
            }
            DB::commit();
            return $result;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    /**
     * 支付编号
     * @return string
     */
    protected static function paymentNo()
    {
        return date('Ymd') .
            substr(
                implode(NULL,
                    array_map('ord',
                        str_split(
                            substr(uniqid(), 7, 13),
                            1)
                    )
                ), 0, 8
            );
    }
}
