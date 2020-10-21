<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\Order\ReceiveEvent;
use App\Logics\Admin\Order;
use App\Models\Setting;
use Event;
use Log;
use DB;

class OrderReceive implements ShouldQueue
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

    protected $receive;

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
        $this->receive = isset($this->setting['receive']) ? $this->setting['receive'] : 0;

        // 设置延迟的时间，delay() 方法的参数代表多少秒之后执行
        $this->delay($this->receive * (60 * 60 * 24));
    }

    public function handle()
    {
        try {
            // 0的话不执行自动签收
            if ($this->receive > 0) {
                // 订单尚未签收
                if ($this->order->receive_status == Order::RECEIVE_STATUS_UN) {
                    DB::beginTransaction();
                    $this->order->receive_time = time();
                    $this->order->receive_status = Order::RECEIVE_STATUS_END;
                    $this->order->order_status = Order::FINISHED;
                    $this->order->save();
                    Event::dispatch(new ReceiveEvent($this->order)); // 执行签收订单事件
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
