<?php

namespace App\Models;

use App\Exceptions\AppException;
use Cache;
use Log;
use DB;

class Setting extends Model
{
    protected $table = 'setting';

    protected $hidden = ['id', 'created_at', 'updated_at', 'deleted_at'];

    protected $fillable = [
        'category',
        'key',
        'values',
    ];

    /**
     * 系统安全设置
     */
    const LOCK = 20; // 锁定账户功能(10：关闭、20：开启)

    /**
     * 消息设置
     */
    const SMS = 20; // 发送短信功能(10：关闭、20：开启)

    /**
     * 打印设置
     */
    const PRINTS = 20; // 打印小票功能(10：关闭、20：开启)

    /**
     * 财务
     */
    const CASH_FEE_TYPE_PERCENTAGE = 10; // 提现手续费类型,按固定金额
    const CASH_FEE_TYPE_FIXED = 20; // 提现手续费类型,按固定金额

    /**
     * 营销
     */
    const DISTRIBUTION = 20; // 分销功能(10：关闭、20：开启)
    const DISTRIBUTION_JOIN = 20; // 加入分销是否需审核(10：不需审核、20：需审核)
    const DISTRIBUTION_LEVEL = 2; // 分销等级

    // 分销计算类型(10：按百分比、20：按固定金额)
    const DISTRIBUTION_TYPE_PERCENTAGE = 10; // 分佣类型,按百分比
    const DISTRIBUTION_TYPE_FIXED = 20; // 分佣类型,按固定金额


    // 免运费(10：关闭、20：开启)
    const LOGISTICS_FREE = 20;

    // 免运费类型(10:满额免邮、20：满件免邮)
    const LOGISTICS_FREE_MONEY = 10;
    const LOGISTICS_FREE_QUANTITY = 20;

    /**
     * 物流
     */
    // 配送方式
    const LOGISTICS_METHOD_EXPRESS = 10; // 快递发货
    const LOGISTICS_METHOD_LOCAL = 20; // 同城配送
    const LOGISTICS_METHOD_PICKUP = 30; //上门自提

    // 是否支持当日自提(10：否、20：是)
    const TODAY_FETCH = 20;

    // 运费计算方式(10：叠加、20：最低、30：最高)
    const LOGISTICS_FEE_TOTAL = 10;
    const LOGISTICS_FEE_MIN = 20;
    const LOGISTICS_FEE_MAX = 30;

    /**
     * 应用
     */
    // 减库存策略(10：下单减库存、20：支付减库存)
    const STOCK_PLAN_ORDER = 10;
    const STOCK_PLAN_PAYMENT = 20;

    // 是否支持开具发票(10：否、20：是)
    const INVOICE = 20;

    protected $params;

    public function __construct(array $params = [])
    {
        parent::__construct();

        $this->params = $params;
    }

    /**
     * @param string $params
     * @return Setting
     */
    public static function getInstance(string $params)
    {
        $category = $params;
        $key = '';
        if (($index = strpos($params, '.')) !== false) {
            $category = substr($params, 0, $index);
            $key = substr($params, $index + 1);
        }
        return new static([
            'category' => $category,
            'key' => $key
        ]);
    }

    public function fetch()
    {
        try {
            $key = 'setting_' . $this->params['category'] . '_' . $this->params['key'];
            $model = Cache::store('file')->rememberForever($key, function () {
                return self::where([
                    'category' => $this->params['category'],
                    'key' => $this->params['key']
                ])->first();
            });

            if ($model) {
                $model->values = json_decode($model->values);
                if ($model->values !== null) {
                    $method = 'fetch' . ucfirst($this->params['category']) . ucfirst($this->params['key']);
                    if (method_exists($model, $method)) {
                        $model->{$method}();
                    }
                    return (array) $model->values;
                }
            }
            return null;
        } catch(\Exception $e) {
            Log::error($key . PHP_EOL);
            Log::error($e->getMessage() . PHP_EOL);
            return null;
        }
    }

    public function fetchByCategory()
    {
        try {
            $key = 'setting_' . $this->params['category'];
            $result = Cache::store('file')->rememberForever($key, function () {
                return self::where([
                    'category' => $this->params['category']
                ])->get();
            });

            $settings = [];
            foreach ($result as $item) {
                $settings[ $item->key ] = json_decode($item->values, true);
            }
            return $settings;
        } catch(\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            throw new AppException('系统设置错误');
        }
    }

    /**
     * 查询指定key的模板列表
     *
     * @param array $template
     * @param array $keys
     * @return array
     */
    public static function getTemplateByKeys(array $template=[], array $keys=[])
    {
        $result = [];
        $template = isset($template['template']) ? $template['template'] : [];
        foreach ($template as $item) {
            if (in_array($item->key, $keys)) {
                $result[] = $item->value;
            }
        }
        return $result;
    }

    /**
     * 处理分销设置中的content
     */
    public function fetchMarketDistribution()
    {
        $this->values->content = urldecode($this->values->content);
    }

    /**
     * 处理积分设置中的content
     */
    public function fetchAppPoints()
    {
        $this->values->content = urldecode($this->values->content);
    }

    /**
     * 处理邀请设置
     */
    public function fetchAppInvite()
    {
        $this->values->content = urldecode($this->values->content);
        foreach ($this->values->image_list as $key => $item) {
            if (strpos($item->name, 'http') === false) {
                $path = config('filesystems.disks.invite.poster.path');
                $item->url = config('app.url') . $path . $item->name;
            } else {
                $item->url = $item->name;
            }
        }
    }

    /**
     * 处理打印设置中的header,footer
     */
    public function fetchPrintsBase()
    {
        $this->values->header = urldecode($this->values->header);
        $this->values->footer = urldecode($this->values->footer);
    }
}
