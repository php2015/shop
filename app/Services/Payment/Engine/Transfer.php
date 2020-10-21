<?php

namespace App\Services\Payment\Engine;

use App\Logics\Api\Setting;
use Yansongda\Pay\Pay;
use Yansongda\Pay\Log as PayLog;
use Log;
use URL;

class Transfer
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
                'app_id' => $setting['wxapp']['app_id'],
                'mch_id' => $setting['payment']['mch_id'],
                'key' => $setting['payment']['mch_key'],
                'cert_client' => base_path('cert/apiclient_cert.pem'),
                'cert_key' => base_path('cert/apiclient_key.pem'),
                'log' => [
                    'file' => storage_path('logs/transfer/transfer.log'),
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
            $order = [
                'partner_trade_no' => $this->config['cash_no'],
                'openid' => $this->config['openid'],
                'amount' => $this->config['amount'] * 100,
                'check_name' => 'NO_CHECK',            //NO_CHECK：不校验真实姓名\FORCE_CHECK：强校验真实姓名
//                're_user_name'=>'张三',              //check_name为 FORCE_CHECK 校验实名的时候必须提交
                'desc' => '账户提现',                  //付款说明
                'spbill_create_ip' => get_client_ip(),  //发起交易的IP地址
            ];
            $payment = Pay::wechat($this->config)->transfer($order);

            if ($payment->return_code == 'SUCCESS' && $payment->result_code == 'SUCCESS') {
                $this->response = $payment;
                return true;
            }
        } catch(\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            return false;
        }
    }

    public function getResponse()
    {
        return $this->response;
    }
}