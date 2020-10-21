<?php

namespace App\Services\Poster\Engine;

use Intervention\Image\Facades\Image;

abstract class Server
{
    protected $config;

    protected $background;

    protected $fontFamily;

    protected function __construct(array $config = [])
    {
        $this->config = $config;
        $this->fontFamily = public_path() . '/fonts/simhei.ttf';
        $this->background();
    }

    private function background()
    {
        $this->background = Image::canvas($this->config['width'], $this->config['height'], '#fff');
    }

    /**
     * @param string $content 内容
     * @param int $fontSize 字体大小
     * @param $width 宽度
     * @return string
     */
    protected function wrap(string $content, int $fontSize, $width)
    {
        $result = "";
        // 将字符串拆分成一个个单字 保存到数组 letter 中
        preg_match_all("/./u", $content, $array);
        $letter = $array[0];

        foreach($letter as $char) {
            $string = $result . $char;
            $box = imagettfbbox($fontSize, 0, $this->fontFamily, $string);
            if (($box[2] > $width) && ($content !== "")) {
                $result .= PHP_EOL;
            }
            $result .= $char;
        }
        return $result;
    }

    protected function round($image, int $size)
    {
        $result = Image::canvas($size, $size);
        $width = $image->width() / 2;

        for ($x = 0; $x < $image->width(); $x++) {
            for ($y = 0; $y < $image->height(); $y++) {
                $c = $image->pickColor($x, $y, 'array');
                if (((($x - $width) * ($x - $width) + ($y - $width) * ($y - $width)) < ($width * $width))) {
                    $result->pixel($c, $x, $y);
                }
            }
        }
        return $result;
    }

//    private function wrap1(string $str, $fontSize, $width)
//    {
//        $_string = '';
//        $return = '';
//        $charset = 'UTF-8';
//
//        for ($i = 0; $i < mb_strlen($str, $charset); $i++) {
//            // 查询已有字符串长度
//            $box = imagettfbbox($fontSize, 0, $this->fontFamily, $_string);
//            $_string_length = max($box[2], $box[4]) - min($box[0], $box[6]);
//
//            // 查询接下来这个字符的宽度
//            $nextString = mb_substr($str, $i, 1, $charset);
//            $box = imagettfbbox($fontSize, 0, $this->fontFamily, $nextString);
//            $nextStringLen = max($box[2], $box[4]) - min($box[0], $box[6]);
//
//            if ($_string_length + $nextStringLen < $width) {
//                $_string .= $nextString;
//            } else {
//                $return .= $_string . "\n";
//                $_string = $nextString;
//            }
//        }
//        $return .= $return;
//        return $return;
//    }
}