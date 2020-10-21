<?php

namespace App\Services\Poster\Engine;

use App\Exceptions\AppException;
use Intervention\Image\Facades\Image;
use Log;

class Invite extends Server
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function make(string $bgImage, string $qrcode, string $avatar, string $title, string $subtitle)
    {
        try {
            // 海报图片
            $coverStream = Image::make($bgImage)->fit(1080, 1660);

            $avatarStream = Image::make($avatar)->resize(140, 140);
            $avatarStream = $this->round($avatarStream, 140);
            $qrcodeStream = Image::make($qrcode)->resize(210, 210);

            return $this->background
                ->insert($coverStream)
                ->insert($qrcodeStream, 'bottom-left', 30, 30)
                ->insert($avatarStream, 'bottom-right', 30, 60)
                ->text($title, 280, 1760, function($font) {
                    $font->file($this->fontFamily);
                    $font->size(48);
                    $font->color('#353535');
                })
                ->text($subtitle, 280, 1820, function($font) {
                    $font->file($this->fontFamily);
                    $font->size(36);
                    $font->color('#666666');
                })
                ->encode('jpg')
                ->encode('data-url')
                ->encoded;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            throw new AppException('网络繁忙，请再次尝试生成海报');
        }
    }
}