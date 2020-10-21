<?php

namespace App\Services\Prints;

use Log;

class Factory
{
    public static function getInstance (array $config)
    {
        $engine = $config['driver'] ?? 'xpyun';
        $class = __NAMESPACE__ . '\\Engine\\' . ucfirst($engine);
        return new $class($config);
    }
}
