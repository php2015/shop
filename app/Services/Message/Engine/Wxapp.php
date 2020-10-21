<?php

namespace App\Services\Message\Engine;

use App\Services\Wechat\Factory;
use Log;

class Wxapp extends Server
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function send(string $openid, array $content)
    {
        try {
            if (empty($openid)) {
                return false;
            }
            if (empty($this->template)) {
                return false;
            }

            $data = [
                'template_id' => $this->template,
                'touser' => $openid,
                'page' => 'pages/index/index', // 支持带参数,（示例index?foo=bar）。
                'data' => $content
            ];
            $wechat = Factory::getInstance('wxapp');
            $wechat->app->subscribe_message->send($data);
            return true;
        } catch(\Exception $e) {
        	Log::error($e->getMessage() . PHP_EOL);
        }
    }
}