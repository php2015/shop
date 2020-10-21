<?php

namespace App\Models;

class OrderGoods extends Model
{
    protected $table = 'order_goods';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'goods_id',
        'goods_sku_id',
        'goods_name',
        'sku_name',
        'image',
        'sales_price',
        'cost_price',
        'weight',
        'quantity',
        'total',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if ($image = $this->getAttribute('image')) {
            if (strpos($image, 'http') === false) {
                $path = config('filesystems.disks.goods.image.path');
                return config('app.url') . $path . $image;
            }
        }
        return $image;
    }

    public function getSalesPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setSalesPriceAttribute(float $value)
    {
        $this->attributes['sales_price'] = bcmul($value, 100);
    }

    public function getCostPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setCostPriceAttribute(float $value)
    {
        $this->attributes['cost_price'] = bcmul($value, 100);
    }

    public function getTotalAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setTotalAttribute(float $value)
    {
        $this->attributes['total'] = bcmul($value, 100);
    }

    /**
     * 反向关联到商品
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }

    /**
     * 反向关联到Sku
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sku()
    {
        return $this->belongsTo(GoodsSku::class, 'goods_sku_id');
    }

    /**
     * 反向关联到订单
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
