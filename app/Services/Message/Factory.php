<?php

namespace App\Services\Message;

use Log;

class Factory
{
    public static function getInstance (array $config)
    {
        $engine = $config['driver'] ?? 'sms';
        $class = __NAMESPACE__ . '\\Engine\\' . ucfirst($engine);
        return new $class($config);
    }
}