<?php

namespace App\Services\Wechat\Engine;

use App\Exceptions\AppException;
use Log;

abstract class Server
{
    protected $config;
    public $app;

    protected function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function getPhone(string $sessionKey, string $iv, string $encryptedData)
    {
        try {
            $result = $this->app->encryptor
                ->decryptData($sessionKey, $iv, urldecode($encryptedData));
            return $result['phoneNumber'];
        } catch(\Exception $e) {
        	Log::error($e->getMessage() . PHP_EOL);
            throw new AppException('获取手机号码失败');
        }
    }
}
