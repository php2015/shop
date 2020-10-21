<?php

namespace App\Services\Prints\Engine;

use App\Helper\Http;
use App\Logics\Admin\Printer;
use App\Logics\Api\Order;
use Log;

class Xpyun extends Server
{
    const ADD_API = 'https://platform.xpyun.net/api/openapi/xprinter/addPrinters';
    const EDIT_API = 'https://platform.xpyun.net/api/openapi/xprinter/updPrinter';
    const REMOVE_API = 'https://platform.xpyun.net/api/openapi/xprinter/delPrinters';
    const PRINTS_API = 'https://platform.xpyun.net/api/openapi/xprinter/print';

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function add(Printer $printer)
    {
        try {
            $timestamp = time();
            $user = $this->config['xpyun_user'];
            $secret = $this->config['xpyun_secret'];
            $sign = sha1($user . $secret . $timestamp);
            $params = [
                'name' => $printer->name,
                'sn' => $printer->sn,
            ];

            $body = [
                'user' => $user,
                'timestamp' => $timestamp,
                'sign' => $sign,
                'items' => [$params],
                'debug' => 0,
            ];
            $result = Http::post(self::ADD_API, $body);
            $result = json_decode($result);

            if ($result->code == 0) {
                return true;
            }
            return false;
        } catch(\Exception $e) {
        	Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public function edit(Printer $printer)
    {
        try {
            $timestamp = time();
            $user = $this->config['xpyun_user'];
            $secret = $this->config['xpyun_secret'];
            $sign = sha1($user . $secret . $timestamp);
            $name = $printer->name;
            $sn = $printer->sn;

            $body = [
                'user' => $user,
                'timestamp' => $timestamp,
                'sign' => $sign,
                'name' => $name,
                'sn' => $sn,
                'debug' => 0,
            ];
            $result = Http::post(self::EDIT_API, $body);
            $result = json_decode($result);

            if ($result->code == 0) {
                return true;
            }
            return false;
        } catch(\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public function remove(Printer $printer)
    {
        try {
            $timestamp = time();
            $user = $this->config['xpyun_user'];
            $secret = $this->config['xpyun_secret'];
            $sign = sha1($user . $secret . $timestamp);
            $params[] = $printer->sn;

            $body = [
                'user' => $user,
                'timestamp' => $timestamp,
                'sign' => $sign,
                'snlist' => $params,
                'debug' => 0,
            ];
            $result = Http::post(self::REMOVE_API, $body);
            $result = json_decode($result);

            if ($result->code == 0) {
                return true;
            }
            return false;
        } catch(\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public function prints(Order $order)
    {
        try {
            $header = urldecode($this->config['header']);
            $footer = urldecode($this->config['footer']);
            $goods = $this->goods($order->goods, 14, 6, 3, 6);
            $content = $header . $goods . $footer;
            $content = str_replace('{TIME}', date("Y-m-d H:i:s", time()), $content);
            $content = str_replace('{ORDER_NO}', $order->order_no, $content);
            $content = str_replace('{GOODS_PRICE}', $order->goods_price, $content);
            $content = str_replace('{DISCOUNT_PRICE}', $order->discount_price, $content);
            $content = str_replace('{LOGISTICS_FEE}', $order->logistics_fee, $content);
            $content = str_replace('{PAYMENT_PRICE}', $order->payment_price, $content);
            $content = str_replace('{REMARK}', $order->remark, $content);


            if ($order->logistics) {
                $content = str_replace('{CONTACT}', $order->logistics->contact, $content);
                $content = str_replace('{PHONE}', $order->logistics->phone, $content);
                $content = str_replace('{ADDRESS}',
                    $order->logistics->province
                    . $order->logistics->city
                    . $order->logistics->district
                    . $order->logistics->detail
                    . $order->logistics->num, $content);
            } else {
                $content = str_replace('{CONTACT}', $order->fetch->contact, $content);
                $content = str_replace('{PHONE}', $order->fetch->phone, $content);
                $content = str_replace('{ADDRESS}', '上门自提', $content);
            }

            $timestamp = time();
            $printer = Printer::where('status', Printer::STATUS_ON)->get();
            foreach ($printer as $item) {
                $body = [
                    'user' => $this->config['xpyun_user'],
                    'timestamp' => $timestamp,
                    'sign' => sha1($this->config['xpyun_user'] . $this->config['xpyun_secret'] . $timestamp),
                    'sn' => $item['sn'],
                    'copies' => $item['copies'],
                    'content' => $content,
                    'mode' => 0,
                    'debug' => 0,
                ];
                $result = Http::post(self::PRINTS_API, $body);
                Log::error($result . PHP_EOL);
            }
            return true;
        } catch(\Exception $e) {
        	Log::error($e->getMessage() . PHP_EOL);
        }
    }
}
