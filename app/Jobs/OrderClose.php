<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\Order\CloseEvent;
use App\Logics\Api\Order;
use App\Models\Setting;
use DB;
use Log;
use Event;

class OrderClose implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务可以尝试的最大次数。
     *
     * @var int
     */
    public $tries = 5;

    /**
     * 任务可以执行的最大秒数 (超时时间)。
     *
     * @var int
     */
    public $timeout = 30;

    protected $order;

    protected $setting;

    protected $close;

    /**
     * Create a new job instance.
     * Order序列化的是主键ID，模型会被重新获取
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->setting = Setting::getInstance('app.order')->fetch();
        $this->close = isset($this->setting['close']) ? $this->setting['close'] : 0;

        // 设置延迟的时间，delay() 方法的参数代表多少秒之后执行
        $this->delay($this->close * 60);
    }

    public function handle()
    {
        try {
            // 0的话不执行自动关闭
            if ($this->close > 0) {
                // 订单尚未支付
                if ($this->order->payment_status == Order::PAYMENT_STATUS_UN
                    && $this->order->payment_status != Order::CLOSED) {
                    DB::beginTransaction();
                    $this->order->close_time = time();
                    $this->order->order_status = Order::CLOSED;
                    $this->order->save();
                    Event::dispatch(new CloseEvent($this->order)); // 执行关闭订单事件
                    DB::commit();
                }
            }
        } catch(\Exception $e) {
            DB::rollback();
        	Log::error($e->getMessage() . PHP_EOL);
        }
    }

    /**
     * 任务失败的处理过程
     * @param \Exception $e
     */
    public function failed(\Exception $e)
    {
        Log::error($e->getMessage() . PHP_EOL);
    }
}
