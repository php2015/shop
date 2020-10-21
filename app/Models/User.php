<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'user';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'token',
        'session_key',
        'parent_id',
        'unionid',
        'nickname',
        'gender',
        'province',
        'city',
        'district',
        'avatar',
        'register_time',
        'last_login_time',
        'last_login_ip',
    ];

    protected $appends = ['avatar_url'];

    public function getAvatarUrlAttribute()
    {
        if ($file = $this->getAttribute('avatar')) {
            if (strpos($file, 'http') === false) {
                $path = config('filesystems.disks.artist.avatar.path');
                return config('app.url') . $path . $file;
            }
        }
        return $file;
    }

    public function getRegisterTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getBonusAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setBonusAttribute(float $value)
    {
        $this->attributes['bonus'] = bcmul($value, 100);
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * 关联公众号表
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wx()
    {
        return $this->hasOne(UserWechat::class);
    }
    /**
     * 关联小程序表
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wxapp()
    {
        return $this->hasOne(UserWechatApp::class);
    }

    /**
     * 关联商品收藏
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function like()
    {
        return $this->hasMany(GoodsLike::class);
    }

    /**
     * 关联购物车
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * 关联用户地址
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function address()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * 关联用户已领取的优惠卷
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coupon()
    {
        return $this->hasMany(CouponReceive::class);
    }

    /**
     * 关联用户订单
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * 关联发票信息
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * 关联用户签到
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checkin()
    {
        return $this->hasMany(Checkin::class);
    }

    /**
     * 关联用户积分明细
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function points()
    {
        return $this->hasMany(Points::class);
    }

    /**
     * 关联用户评论
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comment()
    {
        return $this->hasMany(OrderComment::class);
    }

    /**
     * 关联邀请记录
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invite()
    {
        return $this->hasMany(Invite::class);
    }

    /**
     * 关联分销申请表
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function distribution()
    {
        return $this->hasOne(Distribution::class);
    }

    /**
     * 关联分销订单表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bonus()
    {
        return $this->hasMany(DistributionBonus::class);
    }

    /**
     * 关联提现订单表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cash()
    {
        return $this->hasMany(DistributionCash::class);
    }

    /**
     * 关联支付表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * 关联标签表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tag()
    {
        return $this->belongsToMany(
            UserTag::class,
            'user_tag_pivot',
            'user_id',
            'tag_id'
        );
    }
}
