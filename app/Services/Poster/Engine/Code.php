<?php

namespace App\Services\Poster\Engine;

use App\Exceptions\AppException;
use Intervention\Image\Facades\Image;
use Log;

class Code extends Server
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function make(string $qrcode)
    {
        try {
            $qrcodeStream = Image::make($qrcode)->resize(800, 800);

            return $this->background
                ->insert($qrcodeStream, 'center')
                ->encode('jpg')
                ->encode('data-url')
                ->encoded;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            throw new AppException('网络繁忙，请再次尝试生成核销码');
        }
    }
}