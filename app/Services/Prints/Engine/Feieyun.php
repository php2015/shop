<?php

namespace App\Services\Prints\Engine;

use App\Helper\Http;
use App\Logics\Admin\Printer;
use App\Logics\Api\Order;
use Log;

class Feieyun extends Server
{
    const API = 'http://api.feieyun.cn/Api/Open/';

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function add(Printer $printer)
    {
        try {
            $timestamp = time();
            $user = $this->config['feieyun_user'];
            $secret = $this->config['feieyun_secret'];
            $apiName = 'Open_printerAddlist';
            $sign = sha1($user . $secret . $timestamp);
            $printerContent = "$printer->sn#$printer->key#$printer->name#";

            $body = [
                'user' => $user,
                'stime' => $timestamp,
                'sig' => $sign,
                'apiname' => $apiName,
                'printerContent' => $printerContent,
//                'debug' => 1
            ];
            $result = Http::postForm(self::API, $body);
            $result = json_decode($result);

            if ($result->ret == 0) {
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
            $user = $this->config['feieyun_user'];
            $secret = $this->config['feieyun_secret'];
            $apiName = 'Open_printerEdit';
            $sign = sha1($user . $secret . $timestamp);

            $body = [
                'user' => $user,
                'stime' => $timestamp,
                'sig' => $sign,
                'apiname' => $apiName,
                'sn' => $printer->sn,
                'name' => $printer->name,
//                'debug' => 1
            ];
            $result = Http::postForm(self::API, $body);
            $result = json_decode($result);

            if ($result->ret == 0) {
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
            $user = $this->config['feieyun_user'];
            $secret = $this->config['feieyun_secret'];
            $apiName = 'Open_printerDelList';
            $sign = sha1($user . $secret . $timestamp);

            $body = [
                'user' => $user,
                'stime' => $timestamp,
                'sig' => $sign,
                'apiname' => $apiName,
                'snlist' => $printer->sn,
//                'debug' => 1
            ];
            $result = Http::postForm(self::API, $body);
            $result = json_decode($result);

            if ($result->ret == 0) {
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
            $content = str_replace('{TIME}', $order->order_time, $content);
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
                    . $order->logistics->num,
                    $content);
            } else {
                $content = str_replace('{CONTACT}', $order->fetch->contact, $content);
                $content = str_replace('{PHONE}', $order->fetch->phone, $content);
                $content = str_replace('{ADDRESS}', '上门自提', $content);
            }

            $printer = Printer::where('status', Printer::STATUS_ON)->get();
            foreach ($printer as $item) {
                $timestamp = time();
                $user = $this->config['feieyun_user'];
                $secret = $this->config['feieyun_secret'];
                $apiName = 'Open_printMsg';
                $sign = sha1($user . $secret . $timestamp);

                $body = [
                    'user' => $user,
                    'stime' => $timestamp,
                    'sig' => $sign,
                    'apiname' => $apiName,
                    'sn' => $item->sn,
                    'content' => $content,
                    'times' => $item->copies
//                'debug' => 1
                ];
                $result = Http::postForm(self::API, $body);
                Log::error($result . PHP_EOL);
            }
            return true;
        } catch(\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
        }
    }
}
