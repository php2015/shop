<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Goods extends Model
{
    use SoftDeletes;

    protected $table = 'goods';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'category_id',
        'goods_no',
        'goods_name',
        'subtitle',
        'unit',
        'image',
        'sales_init',
        'content',
        'sales_time',
        'status',
        'sort',
        'sku_type',
        'line_price',
        'min_quantity',
        'quota_quantity',
        'is_express',
        'is_local',
        'is_fetch',
        'express_template_id',
        'local_template_id',
        'distribution_status',
        'distribution_type',
    ];

    protected $appends = ['image_url'];

    // 状态(10：下架、20：上架)
    const STATUS_OFF = 10;
    const STATUS_ON = 20;

    // 规格类型(10：单规格、20：多规格)
    const SPEC_TYPE_SINGLE = 10;
    const SPEC_TYPE_MULTI = 20;

    // 是否支持快递发货(10：否、20：是)
    const IS_EXPRESS_OFF = 10;
    const IS_EXPRESS_ON = 20;

    // 是否支持同城配送(10：否、20：是)
    const IS_LOCAL_OFF = 10;
    const IS_LOCAL_ON = 20;

    // 是否支持上门自提(10：否、20：是)
    const IS_FETCH_OFF = 10;
    const IS_FETCH_ON = 20;

    // 是否开启分销(10:未开启, 20: 开启)
    const DISTRIBUTION_STATUS_OFF = 10;
    const DISTRIBUTION_STATUS_ON = 20;

    // 分销计算类型(10：按百分比、20：按固定金额)
    const DISTRIBUTION_TYPE_PERCENTAGE = 10; // 分佣类型,按百分比
    const DISTRIBUTION_TYPE_FIXED = 20; // 分佣类型,按固定金额

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

    public function getLinePriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setLinePriceAttribute(float $value)
    {
        $this->attributes['line_price'] = bcmul($value, 100);
    }

    public function setSalesTimeAttribute(string $value)
    {
        $this->attributes['sales_time'] = strtotime($value);
    }

    public function getSalesTimeAttribute($value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getContentAttribute(string $value)
    {
        return urldecode($value);
    }

    /**
     * 关联到分类
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 多对多关联分组表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function group()
    {
        return $this->belongsToMany(
            GoodsGroup::class,
            'goods_group_pivot',
            'goods_id',
            'group_id'
        );
    }

    /**
     * 关联到支持
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function support()
    {
        return $this->belongsToMany(
            GoodsSupport::class,
            'goods_support_pivot',
            'goods_id',
            'support_id'
        );
    }

    /**
     * 关联商品图片
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(GoodsImages::class);
    }

    /**
     * 关联Sku
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sku()
    {
        return $this->hasMany(GoodsSku::class);
    }

    /**
     * 关联SkuValue
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function skuValue()
    {
        return $this->hasMany(GoodsSkuValue::class);
    }

    /**
     * 多对多关联到规格表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function spec()
    {
        return $this->belongsToMany(
            Spec::class,
            'goods_sku_value',
            'goods_id',
            'spec_id'
        );
    }

    /**
     * 多对多关联到规格值表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function specValue()
    {
        return $this->belongsToMany(
            SpecValue::class,
            'goods_sku_value',
            'goods_id',
            'spec_value_id'
        );
    }

    /**
     * 关联商品的评论
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comment()
    {
        return $this->hasMany(OrderComment::class);
    }

    /**
     * 关联用户浏览历史
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history()
    {
        return $this->hasMany(GoodsHistory::class);
    }

    /**
     * 关联用户收藏
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function like()
    {
        return $this->hasMany(GoodsLike::class);
    }

    /**
     * 关联订单表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function order()
    {
        return $this->belongsToMany(Order::class, 'order_goods')
            ->where('order_status', '>', 0);
    }
}
