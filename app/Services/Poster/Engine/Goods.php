<?php

namespace App\Services\Poster\Engine;

use App\Logics\Api\Goods as GoodsLogic;
use App\Exceptions\AppException;
use Intervention\Image\Facades\Image;
use Log;

class Goods extends Server
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function make(string $qrcode, GoodsLogic $goods)
    {
        try {
            // 海报图片
            $poster = $goods->images[0]['url'];
            $coverStream = Image::make($poster)->fit(1080, 1660);
            $qrcodeStream = Image::make($qrcode)->resize(220, 220);
            // 处理字符换行
            $goods_name = $this->wrap($goods->goods_name,40,  800);

            return $this->background
                ->insert($coverStream)
                ->insert($qrcodeStream, 'bottom-left', 30, 30)
                ->text($goods_name, 300, 1760, function($font) {
                    $font->file($this->fontFamily);
                    $font->size(40);
                    $font->color('#353535');
                })
                ->text("$goods->sales_price 元", 300, 1860, function($font) {
                    $font->file($this->fontFamily);
                    $font->size(40);
                    $font->color('#dd2c00');
                })
                ->text("长按图片，立即购买", 800, 1900, function($font) {
                    $font->file($this->fontFamily);
                    $font->size(28);
                    $font->color('#dd2c00');
                })
                ->encode('jpg')
                ->encode('data-url')
                ->encoded;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            throw new AppException('网络繁忙，请再次尝试');
        }
    }
}
