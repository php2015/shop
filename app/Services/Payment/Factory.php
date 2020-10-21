<?php

namespace App\Services\Payment;

class Factory
{
    public static function getInstance (array $config)
    {
        $engine = [
            '10' => 'wallet',
            '20' => 'wechat',
            '30' => 'transfer',
        ];
        $class = __NAMESPACE__ . '\\Engine\\' . ucfirst($engine[ $config['payment_channel'] ]);
        return new $class($config);
    }
}
