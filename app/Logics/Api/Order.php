<?php

namespace App\Logics\Api;

use App\Models\Order as OrderModel;
use App\Services\Poster\Factory as PosterFactory;
use App\Services\Wechat\Factory as WechatFactory;
use App\Events\Order\SubmitEvent;
use App\Events\Order\ReceiveEvent;
use App\Events\Order\CloseEvent;
use App\Models\CouponReceive;
use App\Exceptions\AppException;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Jobs\OrderClose;
use Carbon\Carbon;
use Event;
use DB;
use Log;

class Order extends OrderModel
{
    const AMOUNT_IS_ZERO = '订单异常';

    const IS_NOT_EMPLOYEE = '无权核销';

    private $order;

    public static function getList()
    {
        $request = Request::capture();
        $user = User::model();
        $status = $request->get('status', 0);
        $filter = [];
        switch($status) {
            case 1:
            case 2:
            case 3:
                $filter['order_status'] = $status;
                break;
            case 4:
                $filter[] = ['order_status', '=', 0];
                $filter[] = ['comment_status', '=', 10];
        }

        return $user->order()
            ->with('goods')
            ->where($filter)
            ->orderBy('order_time', 'desc')
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with(['logistics', 'fetch.address', 'goods', 'user'])
            ->findOrFail($id);
    }

    public static function confirm(string $sku, int $address, int $method)
    {
        try {
            $order = new static;
            if ($sku = json_decode(html_entity_decode($sku))) {
                foreach ($sku as $item) {
                    $detail = GoodsSku::detail($item->id);
                    $detail->quantity = $item->quantity;
                    $order->goods[] = $detail;
                }
            }
            $order->logistics_method = $method;
            $order->logisticsTotal($address); // 运费合计

            $order->availableCoupon(); // 可用优惠卷
            $order->unavailableCoupon(); // 不可用优惠卷
            return $order;
        } catch(\Exception $e) {
            Log::error($e->getTraceAsString() . PHP_EOL);
        }
    }

    public static function create(array $data)
    {
        if ($data['payment'] <= 0) {
            throw new AppException(self::AMOUNT_IS_ZERO);
        }

        $sku = $data['order'];
        $method = $data['method'];
        $coupon = $data['coupon'];
        $discount = $data['discount'];
        $logistics = $data['logistics'];
        $price = $data['price'];
        $payment = $data['payment'];
        $invoice = $data['invoice'];
        $address = $data['address'];
        $contact = $data['contact'];
        $phone = $data['phone'];
        $day = $data['day'];
        $time = $data['time'];
        $location = $data['location'];
        $remark = $data['remark'];
        $source = $data['source'];

        try {
            DB::beginTransaction();
            $user = User::model();
            $order = new static;
            $order->user_id = $user->id;
            $order->order_no = self::No();
            $order->goods_price = $price;
            $order->discount_price = $discount;
            $order->payment_price = $payment;
            $order->logistics_method = $method;
            $order->logistics_fee = $logistics;
            $order->payment_channel = self::PAYMENT_CHANNEL_WECHAT;
            $order->order_time = time();
            $order->invoice_status = $invoice;
            $order->remark = $remark;
            $order->coupon_receive_id = $coupon;
            $order->source = $source;
            $order->save();

            // 保存商品
            $goods = [];
            $sku = json_decode(html_entity_decode($sku));
            foreach ($sku as $item) {
                $detail = GoodsSku::detail($item->id);
                $goods[] = [
                    'goods_id' => $detail->goods_id,
                    'goods_sku_id' => $detail->id,
                    'goods_name' => $detail->goods->goods_name,
                    'sku_name' => $detail->sku_name,
                    'image' => $detail->goods->image,
                    'sales_price' => $detail->sales_price,
                    'cost_price' => $detail->cost_price,
                    'weight' => $detail->weight,
                    'quantity' => $item->quantity,
                    'total' => (float) bcmul($detail->sales_price, $item->quantity),
                ];
            }
            $order->goods()->createMany($goods);

            // 保存发票
            if ($order->invoice_status == self::INVOICE_STATUS_NEED && $user->invoice) {
                $order->invoice()->create(
                    $user->invoice->toArray()
                );
            }

            // 根据配送方式保存物流信息
            if ($method == 10 || $method == 20) { // 快递发货或同城配送
                $address = Address::detail($address);
                $order->logistics()->create(
                    $address->toArray()
                );
            } else { // 上门自提
                $array = explode('-', $time);
                $begin_hours = (int) $array[0];
                $end_hours = (int) $array[1];
                $begin_time = Carbon::today()->addHours($day == 0 ? $begin_hours : 24 + $begin_hours)->timestamp;
                $end_time = Carbon::today()->addHours($day == 0 ? $end_hours : 24 + $end_hours)->timestamp;
                $address = StoreAddress::detail($location);

                $order->fetch()->create([
                    'store_address_id' => $location,
                    'contact' => $contact,
                    'phone' => $phone,
                    'begin_time' => $begin_time,
                    'end_time' => $end_time,
                    'address_name' => $address->address_name,
                    'address' => $address->address
                ]);
            }
            Event::dispatch(new SubmitEvent($order));
            DB::commit();
            OrderClose::dispatch($order);
            return $order;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getTraceAsString() . PHP_EOL);
        }
    }

    /**
     * 取消订单
     * @param int $id
     * @return bool
     */
    public static function close(int $id)
    {
        try {
            $order = self::detail($id);
            if ($order->order_status['value'] == self::UN_PAY
                && $order->order_status['value'] != self::CLOSED) {
                DB::beginTransaction();
                $order->close_time = time();
                $order->order_status = self::CLOSED;
                $order->save();
                Event::dispatch(new CloseEvent($order)); // 执行关闭订单事件
                DB::commit();
                return true;
            }
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getTraceAsString() . PHP_EOL);
        }
    }

    /**
     * 订单签收
     * @param int $id
     * @return bool
     */
    public static function receive(int $id)
    {
        try {
            DB::beginTransaction();
            $order = self::detail($id);
            if ($order->order_status['value'] == self::UN_RECEIVE) {
                $order->order_status = self::FINISHED;
                $order->receive_status = self::RECEIVE_STATUS_END;
                $order->receive_time = time();
                $order->finish_time = time();
                $order->save();
                Event::dispatch(new ReceiveEvent($order));
                DB::commit();
                return true;
            }
            return false;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getTraceAsString() . PHP_EOL);
        }
    }

    /**
     * 评论
     * @param array $data
     * @return bool
     */
    public static function commenting(array $data)
    {
        try {
            DB::beginTransaction();
            $params = json_decode($data['data']);
            $order = self::findOrFail($data['id']);
            if ($order->comment_status == self::COMMENT_STATUS_UN) {
                $order->comment_status = self::COMMENT_STATUS_END;
                $order->save();

                foreach($params as $item) {
                    // 保存评论
                    $comment = new OrderComment;
                    $comment->rate = $item->rate;
                    $comment->content = $item->content;
                    $comment->comment_time = time();
                    $comment->user_id = User::getId();
                    $comment->goods_id = $item->goods_id;
                    $comment->order_id = $order->id;
                    $comment->save();

                    // 保存评论图片
                    if (isset($item->upload)) {
                        foreach($item->upload as $image) {
                            $commentImages = new OrderCommentImages;
                            $commentImages->image = $image;
                            $comment->images()->save($commentImages);
                        }
                    }
                }
            }
            DB::commit();
            return true;
        } catch (\Exctption $e) {
            DB::rollback();
            Log::error($e->getTraceAsString() . PHP_EOL);
        }
    }

    /**
     * 根据规则计算运费
     * @param int $address
     */
    private function logisticsTotal(int $address)
    {

        $this->logistics = $address ? Address::detail($address) : Address::default();
        if ($this->logistics) {
            $baseSetting = Setting::getInstance('logistics.base')->fetch();
            $freeSetting = Setting::getInstance('logistics.free')->fetch();

            switch($this->logistics_method) {
                case Setting::LOGISTICS_METHOD_EXPRESS: // 快递运费
                    $this->expressFee();
                    break;
                case Setting::LOGISTICS_METHOD_LOCAL: // 同城运费
                    $this->localFee();
                    break;
                case Setting::LOGISTICS_METHOD_PICKUP: // 自提无运费
                    $this->fetchCheck();
                    break;
            }

            $this->total(); // 根据可配送商品合计价格

            $quantity = 0; // 总件数
            $logistics_fee = [];
            foreach ($this->goods as $key => $item) {
                $quantity += $item->quantity;
                $logistics_fee[] = $item->logistics_fee;
            }

            if ($baseSetting['freight'] == Setting::LOGISTICS_FEE_TOTAL) { // 叠加
                $this->logistics_fee = (float) array_sum($logistics_fee);
            } else if ($baseSetting['freight'] == Setting::LOGISTICS_FEE_MIN) { // 最低
                $this->logistics_fee = (float) min($logistics_fee);
            } else if ($baseSetting['freight'] == Setting::LOGISTICS_FEE_MAX) { // 最高
                $this->logistics_fee = (float) max($logistics_fee);
            }

            // 是否开启免邮活动
            if ($freeSetting['status'] == Setting::LOGISTICS_FREE) {
                // 满额免邮
                if ($freeSetting['type'] == Setting::LOGISTICS_FREE_MONEY) {
                    // 大于等于免邮金额
                    if ($this->goods_price >= $freeSetting['limit']) {
                        $this->logistics_fee = 0;
                    }
                }
                // 满件免邮
                else if ($freeSetting['type'] == Setting::LOGISTICS_FREE_QUANTITY) {
                    // 大于等于免邮件数
                    if ($quantity >= $freeSetting['limit']) {
                        $this->logistics_fee = 0;
                    }
                }
            }
        } else {
            $this->logistics_fee = 0;
        }
    }

    /**
     * 快递发货运费
     */
    private function expressFee()
    {
        $submit = [];
        $this->method_error = 0;
        $this->logistics_error = 0;

        foreach($this->goods as $item) {
            $weight = bcmul($item->weight, $item->quantity); // 计算总重
            // 商品错误提示
            $item->method_error = 1;
            $item->logistics_error = 1;

            // 商品支持快递发货才继续计算
            if ($item->goods->is_express == 20) {
                $result = ExpressTemplate::getFee(
                    $item->goods->express_template_id,
                    $this->logistics->city,
                    $item->quantity,
                    $weight
                );

                if ($result === null) {
                    $item->logistics_fee = 0; // 不在配送范围，配送费返回 0
                    $this->logistics_error = 1; // 全局错误提示
                } else {
                    $item->logistics_fee = $result;
                    $item->logistics_error = 0;
                    $submit[] = [
                        'id' => $item->id,
                        'quantity' => $item->quantity
                    ];
                }
                $item->method_error = 0;
            } else {
                $this->method_error = 1;
            }
        }
        $this->submit_order = $submit;
    }

    /**
     * 同城配送运费
     */
    private function localFee()
    {
        $submit = [];
        $this->method_error = 0;
        $this->logistics_error = 0;

        foreach($this->goods as $item) {
            $weight = bcmul($item->weight, $item->quantity); // 计算总重
            // 商品错误提示
            $item->method_error = 1;
            $item->logistics_error = 1;

            // 商品支持快递发货才继续计算
            if ($item->goods->is_local == 20) {
                $result = LocalTemplate::getFee(
                    $item->goods->local_template_id,
                    $this->logistics->lon,
                    $this->logistics->lat,
                    $weight
                );

                if ($result === null) {
                    $item->logistics_fee = 0; // 返回null商品超过配送距离或重量阈值
                    $this->logistics_error = 1; // 全局错误提示
                } else {
                    $item->logistics_fee = $result;
                    $item->logistics_error = 0;
                    $submit[] = [
                        'id' => $item->id,
                        'quantity' => $item->quantity
                    ];
                }
                $item->method_error = 0;
            } else {
                $this->method_error = 1;
            }
        }
        $this->submit_order = $submit;
    }

    /**
     * 自提无运费
     */
    private function fetchCheck()
    {
        $submit = [];
        $this->method_error = 0;
        $this->logistics_error = 0;

        foreach($this->goods as $item) {
            // 商品错误提示
            $item->method_error = 1;
            $item->logistics_error = 0;
            $item->logistics_fee = 0;

            // 商品是否支持自提
            if ($item->goods->is_fetch == 20) {
                $item->method_error = 0;
                $submit[] = [
                    'id' => $item->id,
                    'quantity' => $item->quantity
                ];
            } else {
                $this->method_error = 1;
            }
        }
        $this->submit_order = $submit;
    }

    /**
     * 计算商品总价
     */
    private function total()
    {
        $total = 0;
        foreach ($this->goods as $key => $item) {
            // 问题商品不计入总价
            if (!($item->logistics_error == 1 || $item->method_error == 1)) {
                $total += ($item->sales_price * 100) * $item->quantity;
            }
        }
        $this->goods_price = bcdiv($total, 100, 2);
    }

    /**
     * 可用优惠卷
     * @param float $total
     * @return mixed
     */
    private function availableCoupon()
    {
        $this->available = User::model()
            ->coupon()
            ->where('condition', '<=', $this->goods_price * 100)
            ->where('expire_at', '>', time())
            ->where('status', '=', CouponReceive::STATUS_OFF)
            ->orderBy('amount', 'desc')
            ->orderBy('discount', 'desc')
            ->get();
    }

    /**
     * 不可用优惠卷
     * @param float $total
     * @return mixed
     */
    private function unavailableCoupon()
    {
        $this->unavailable = User::model()
            ->coupon()
            ->where('condition', '>', $this->goods_price * 100)
            ->where('expire_at', '>', time())
            ->where('status', '=', CouponReceive::STATUS_OFF)
            ->orderBy('amount', 'desc')
            ->orderBy('discount', 'desc')
            ->get();
    }

    public static function remove(int $id)
    {
        return self::detail($id)
            ->delete();
    }

    public static function label()
    {
        $user = User::model();
        $list = $user->order;
        $pay = 0;
        $shipment = 0;
        $receive = 0;
        $comment = 0;
        foreach ($list as $item) {
            if ($item->order_status['value'] == 1) $pay += 1;
            if ($item->order_status['value'] == 2) $shipment += 1;
            if ($item->order_status['value'] == 3) $receive += 1;
            if ($item->order_status['value'] == 0 && $item->comment_status == 10) $comment += 1;
        }
        return [
            'pay' => $pay,
            'shipment' => $shipment,
            'receive' => $receive,
            'comment' => $comment,
        ];
    }

    public static function makeCode(int $id)
    {
        $scene = "t=99&id=$id";
        $arcode = WechatFactory::getInstance('wxapp')->getUnlimit($scene);
        $poster = PosterFactory::getInstance([
            'width' => 1080,
            'height' => 1080,
            'driver' => 'code'
        ]);
        return $poster->make($arcode);
    }

    public static function userFetch(int $id)
    {
        if (!$emp = StoreEmployee::where([
            'user_id' => User::getId(),
            'verify' => StoreEmployee::VERIFY_ON,
            'status' => StoreEmployee::STATUS_ON
        ])->first()) {
            throw new AppException(self::IS_NOT_EMPLOYEE);
        }

        try {
            DB::beginTransaction();
            $order = self::detail($id);
            if ($order->order_status['value'] != self::FINISHED) {
                $order->order_status = self::FINISHED;
                $order->shipment_status = self::LOGISTICS_STATUS_END;
                $order->shipment_time = time();
                $order->receive_status = self::RECEIVE_STATUS_END;
                $order->receive_time = time();
                $order->finish_time = time();
                $order->save();
                Event::dispatch(new ReceiveEvent($order));
                DB::commit();
                return $order;
            }
            return false;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getTraceAsString() . PHP_EOL);
            return false;
        }
    }

    /**
     * 获取订单编号
     * @return string
     */
    protected static function No()
    {
        return date('Ymd') .
            substr(
                implode(NULL,
                    array_map('ord',
                        str_split(
                            substr(uniqid(), 7, 13),
                            1)
                    )
                ), 0, 8
            );
    }
}
