<?php

namespace App\Services\Message\Engine;

use Log;

abstract class Server
{
    protected $config;

    protected $template;

    protected $status;

    protected function __construct(array $config = [])
    {
        $this->config = $config;
    }

    abstract public function send(string $to, array $content);

    public function template(string $key)
    {
        try {
            foreach ($this->config['template'] as $item) {
                if ($item->key == strtoupper($key)) {
                    $this->template = $item->value;
                }
            }
            return $this;
        } catch(\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
        }
    }
}
