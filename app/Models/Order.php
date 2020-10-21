<?php

namespace App\Models;

use App\Helper\Date;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'order';

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = [
        'user_id'
    ];

    // 订单状态(-1：已关闭、0：已完成、1:待支付、2：待发货、3：待收货)
    const UN_PAY = 1;
    const UN_SHIPMENT = 2;
    const UN_RECEIVE = 3;
    const FINISHED = 0;
    const CLOSED = -1;

    // 物流方式
    const LOGISTICS_METHOD_EXPRESS = 10;
    const LOGISTICS_METHOD_LOCAL = 20;
    const LOGISTICS_METHOD_FETCH = 30;

    // 支付状态(10：未支付、20：已支付)
    const PAYMENT_STATUS_UN = 10;
    const PAYMENT_STATUS_END = 20;

    // 发货状态(10：未发货、20：已发货)
    const LOGISTICS_STATUS_UN = 10;
    const LOGISTICS_STATUS_END = 20;

    // 签收状态(10：未签收、20：已签收)
    const RECEIVE_STATUS_UN = 10;
    const RECEIVE_STATUS_END = 20;

    // 评论(10：未评论、20：已评论)
    const COMMENT_STATUS_UN = 10;
    const COMMENT_STATUS_END = 20;

    // 发票(10：不开票、20：开票)
    const INVOICE_STATUS_NOT = 10;
    const INVOICE_STATUS_NEED = 20;

    // 支付渠道(10：钱包、20：微信)
    const PAYMENT_CHANNEL_ACCOUNT = 10;
    const PAYMENT_CHANNEL_WECHAT = 20;

    // 来源(10：公众号、20：小程序)
    const SOURCE_WECHAT = 10;
    const SOURCE_WECHAT_APP = 20;

    public function getGoodsPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setGoodsPriceAttribute(float $value)
    {
        $this->attributes['goods_price'] = bcmul($value, 100);
    }

    public function getDiscountPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setDiscountPriceAttribute(float $value)
    {
        $this->attributes['discount_price'] = bcmul($value, 100);
    }

    public function getPaymentPriceAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setPaymentPriceAttribute(float $value)
    {
        $this->attributes['payment_price'] = bcmul($value, 100);
    }

    public function getLogisticsFeeAttribute(int $value)
    {
        return bcdiv($value, 100, 2);
    }

    public function setLogisticsFeeAttribute(float $value)
    {
        $this->attributes['logistics_fee'] = bcmul($value, 100);
    }

    public function getOrderTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getPaymentTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getShipmentTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getReceiveTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getFinishTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getCloseTimeAttribute(int $value)
    {
        return $value ? date("Y-m-d H:i:s", $value) : '';
    }

    public function getOrderStatusAttribute(int $value)
    {
        $status = [
            self::UN_PAY => '待付款',
            self::UN_SHIPMENT => '待发货',
            self::UN_RECEIVE => '待收货',
            self::FINISHED => '交易成功',
            self::CLOSED => '交易关闭',
        ];
        return ['value' => $value, 'text' => $status[$value]];
    }

    /**
     * 关联订单商品
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function goods()
    {
        return $this->hasMany(OrderGoods::class);
    }

    /**
     * 关联订单物流
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function logistics()
    {
        return $this->hasOne(OrderLogistics::class);
    }

    /**
     * 关联评论表
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comment()
    {
        return $this->hasMany(OrderComment::class);
    }

    /**
     * 关联订单发票
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function invoice()
    {
        return $this->hasOne(OrderInvoice::class);
    }

    /**
     * 关联上门自提表
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fetch()
    {
        return $this->hasOne(OrderFetch::class);
    }

    /**
     * 反向关联到用户表
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 查询函数
     */
    protected function query_status($status)
    {
        isset($status) && $this->filter[] = ['order_status', '=', $status];
    }

    protected function query_date($type)
    {
        if (isset($type)) {
            switch ($type) {
                case 0:
                    $date = Date::today();
                    $this->filter[] = ['order_time', '>=', $date['start']];
                    $this->filter[] = ['order_time', '<=', $date['end']];
                    break;
                case 1:
                    $date = Date::yesterday();
                    $this->filter[] = ['order_time', '>=', $date['start']];
                    $this->filter[] = ['order_time', '<=', $date['end']];
                    break;
                case 2:
                    $date = Date::week();
                    $this->filter[] = ['order_time', '>=', $date['start']];
                    $this->filter[] = ['order_time', '<=', $date['end']];
                    break;
                case 3:
                    $date = Date::month();
                    $this->filter[] = ['order_time', '>=', $date['start']];
                    $this->filter[] = ['order_time', '<=', $date['end']];
                    break;
                case 4:
                    $date = Date::year();
                    $this->filter[] = ['order_time', '>=', $date['start']];
                    $this->filter[] = ['order_time', '<=', $date['end']];
                    break;
            }
        }
    }

    protected function query_between($between)
    {
        if (is_array($between)) {
            $this->filter[] = ['order_time', '>=', ($between[0] / 1000)];
            $this->filter[] = ['order_time', '<=', ($between[1] / 1000)];
        }
    }

    protected function query_order_no($no)
    {
        if (!empty($no)) {
            $this->filter[] = ['order_no', 'like', "%$no%"];
        }
    }

    protected function query_logistics_method($method)
    {
        if (!empty($method)) {
            $this->filter[] = ['logistics_method', '=', $method];
        }
    }
}
