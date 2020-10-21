<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    public function __construct(String $message = '', Int $code=10000)
    {
        parent::__construct($message, $code);
    }

    public function render()
    {
        return response()->json([
            'msg' => $this->getMessage() ?: '很抱歉，服务器内部错误',
            'code' => $this->getCode()
        ]);
    }
}

