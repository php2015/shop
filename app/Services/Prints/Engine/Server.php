<?php

namespace App\Services\Prints\Engine;

use App\Logics\Admin\Printer;
use App\Logics\Api\Order;

abstract class Server
{
    protected $config;

    protected function __construct(array $config = [])
    {
        $this->config = $config;
    }

    abstract public function add(Printer $printer);

    abstract public function edit(Printer $printer);

    abstract public function remove(Printer $printer);

    abstract public function prints(Order $order);

    public function goods($list, $name_len, $B, $C, $D)
    {
        $nums = 0;
        $content = '名称           单价  数量 小计<BR>';
        $content .= '--------------------------------<BR>';

        foreach ($list as $item) {
            $name = $item->goods_name . $item->sku_name;
            $price = $item->sales_price;
            $num = $item->quantity;
            $prices = $item->total;
            $kw1 = '';
            $kw2 = '';
            $kw3 = '';
            $kw4 = '';
            $str = $name;
            $blankNum = $name_len;//名称控制为14个字节
            $lan = mb_strlen($str,'utf-8');
            $m = 0;
            $j=1;
            $blankNum++;
            $result = [];
            if(strlen($price) < $B) {
                $k1 = $B - strlen($price);
                for($q=0; $q<$k1; $q++) {
                    $kw1 .= ' ';
                }
                $price = $price . $kw1;
            }
            if(strlen($num) < $C) {
                $k2 = $C - strlen($num);
                for($q=0; $q<$k2; $q++) {
                    $kw2 .= ' ';
                }
                $num = $num . $kw2;
            }
            if(strlen($prices) < $D) {
                $k3 = $D - strlen($prices);
                for($q=0; $q<$k3; $q++) {
                    $kw4 .= ' ';
                }
                $prices = $prices.$kw4;
            }
            for ($i=0; $i<$lan; $i++) {
                $new = mb_substr($str, $m, $j, 'utf-8');
                $j++;
                if(mb_strwidth($new,'utf-8') < $blankNum) {
                    if($m + $j > $lan) {
                        $m = $m+$j;
                        $tail = $new;
                        $len = iconv("UTF-8", "GBK//IGNORE", $new);
                        $k = $name_len - strlen($len);
                        for($q=0; $q<$k; $q++) {
                            $kw3 .= ' ';
                        }
                        if($m == $j) {
                            $tail .= $kw3.' '.$price.' '.$num.' '.$prices;
                        }else{
                            $tail .= $kw3.'<BR>';
                        }
                        break;
                    }else{
                        $next_new = mb_substr($str,$m,$j,'utf-8');
                        if(mb_strwidth($next_new,'utf-8')<$blankNum) continue;
                        else{
                            $m = $i+1;
                            $result[] = $new;
                            $j=1;
                        }
                    }
                }
            }
            $head = '';
            foreach ($result as $key => $value) {
                if($key < 1) {
                    $v_lenght = iconv("UTF-8", "GBK//IGNORE", $value);
                    $v_lenght = strlen($v_lenght);
                    if($v_lenght == 13) $value = $value . " ";
                    $head .= $value .' '. $price .' '. $num .' '. $prices;
                }else{
                    $head .= $value.'<BR>';
                }
            }
            $content .= $head . $tail;
            @$nums += $prices;
        }
        $content .= '--------------------------------<BR>';
        return $content;
    }
}
