<?php

namespace App\Services\Payment\Engine;

use App\Logics\Api\Setting;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log as PayLog;
use Log;
use URL;

class Wechat
{
    private $config;

    private $response;

    public function __construct(array $config)
    {
        $this->config = $config;

        $setting = Setting::getInstance('wechat')->fetchByCategory();

        $this->config = array_merge(
            $this->config,
            [
                'miniapp_id' => $setting['wxapp']['app_id'],
                'mch_id' => $setting['payment']['mch_id'],
                'key' => $setting['payment']['mch_key'],
                'notify_url' => dirname(dirname(URL::full())) . '/payment/notify',
                'cert_client' => base_path('cert/apiclient_cert.pem'),
                'cert_key' => base_path('cert/apiclient_key.pem'),
                'log' => [
                    'file' => storage_path('logs/wechat/wechat.log'),
                    'type' => 'daily',
                    'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
                    'max_file' => 100, // optional, 当 type 为 daily 时有效，默认 30 天
                ],
                'http' => [
                    'timeout' => 10.0,
                    'connect_timeout' => 10.0,
                ]
            ]
        );
    }

    public function payment()
    {
        try {
            $setting = Setting::getInstance('app.base')->fetch();

            $order = [
                'body' => $setting['app_name'],
                'out_trade_no' => $this->config['payment_no'],
                'total_fee' => $this->config['payment_price'] * 100,
                'openid' => $this->config['openid'],
            ];
            $payment = Pay::wechat($this->config)->miniapp($order);

            return [
                'timeStamp' => $payment->timeStamp,
                'nonceStr' => $payment->nonceStr,
                'package' => $payment->package,
                'signType' => $payment->signType,
                'paySign' => $payment->paySign,
            ];
        } catch(\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            return false;
        }
    }

    public function notify()
    {
        try{
            $pay = Pay::wechat($this->config);
            $this->response = $pay->verify();
            return $pay->success();
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public function getResponse()
    {
        return $this->response;
    }
}