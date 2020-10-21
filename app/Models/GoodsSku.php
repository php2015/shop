<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;


class GoodsSku extends Model
{
    use SoftDeletes;

    protected $table = 'goods_sku';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'sku_id',
        'sku_no',
        'sku_name',
        'image',
        'sales_price',
        'cost_price',
        'stock',
        'weight',
        'points',
        'level_one',
        'level_two',
        'sales',
        'goods_id',
    ];

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

    public function setLevelOneAttribute(float $value)
    {
        $this->attributes['level_one'] = bcmul($value, 100);
    }

    public function getLevelOneAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setLevelTwoAttribute(float $value)
    {
        $this->attributes['level_two'] = bcmul($value, 100);
    }

    public function getLevelTwoAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    /**
     * 关联Sku Value
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function value()
    {
        return $this->hasMany(GoodsSkuValue::class);
    }

    /**
     * 反向关联到商品
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }
}
