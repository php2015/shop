<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;

    protected $table = 'cart';

    protected $hidden = ['user_id', 'created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [
        'user_id'
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

    /**
     * 关联到商品
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class)
            ->where(['status' => Goods::STATUS_ON]);
    }

    /**
     * 关联到Sku
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sku()
    {
        return $this->belongsTo(GoodsSku::class, 'goods_sku_id');
    }
}
