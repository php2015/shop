<?php

namespace App\Logics\Api;

use App\Exceptions\AppException;
use App\Models\Goods as GoodsModel;
use App\Services\Wechat\Factory as WechatFactory;
use App\Services\Poster\Factory as PosterFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Events\Goods\ViewEvent;
use Event;
use Log;

class Goods extends GoodsModel
{
    const QUOTA_UNDER = '超过限购数量';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where(['status' => self::STATUS_ON]);
        });
    }

    public static function getList()
    {
        $request = Request::capture();
        $category = $request->get('category');
        $group = $request->get('group');
        $keyword = $request->get('keyword');
        $type = $request->get('type');

        $filter = [];
        !empty($keyword) && $filter[] = ['goods_name', 'like', "%$keyword%"];
        !empty($category) && $filter[] = ['category_id', '=', $category];

        $order = 'sort asc';

        if ($type == 10) {
            $order = 'sort desc';
        }
        if ($type == 20) {
            $order = 'sales_price asc';
        }
        if ($type == 30) {
            $order = 'sales_price desc';
        }
        if ($type == 40) {
            $order = '(sales_init + sales) desc';
        }
        if ($type == 50) {
            $order = 'created_at desc';
        }

        if (empty($group)) {
            return self::where($filter)
                ->orderByRaw($order)
                ->paginate(
                    $request->get('limit', self::PAGE)
                );
        } else {
            return self::whereHas('group', function (Builder $query) use ($group) {
                $query->where('group_id', $group);
            })
                ->orderByRaw($order)
                ->paginate(
                    $request->get('limit', self::PAGE)
                );
        }
    }

    /**
     * 根据分类ID获取分类下的商品列表
     *
     * @param int $category
     * @return mixed
     */
    public static function getListByCategory(int $category = 0)
    {
        $request = Request::capture();

        $filter[] = ['category_id', '=', $category];
        $order = 'sort desc';

        return self::where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail($id)
    {
        $detail = self::with(['support', 'images', 'sku', 'spec', 'specValue', 'comment.user'])
            ->findOrFail( $id );
        Event::dispatch(new ViewEvent($detail));
        return $detail;
    }

    public static function checkQuota(int $id, int $quantity)
    {
        $detail = self::findOrFail( $id );

        if ($detail->quota_quantity > 0 && $detail->quota_quantity < $quantity) {
            throw new AppException(self::QUOTA_UNDER);
        }
        return true;
    }

    /**
     * 生成海报
     *
     * @param int $id
     * @return mixed
     */
    public static function makePoster(int $id)
    {
        $goods = self::detail($id);
        $scene = "t=0&id=$goods->id";
        // 生成小程序码
        $arcode = WechatFactory::getInstance('wxapp')->getUnlimit($scene);
        $poster = PosterFactory::getInstance([
            'width' => 1080,
            'height' => 1920,
        ]);
        return $poster->make($arcode, $goods);
    }

    /**
     * 设计获取商品数据
     */
    public static function getDesignGoods(object $params)
    {
        try {
            $order = 'sort asc';
            if ($params->sort == 20) {
                $order = 'sales_price asc';
            }
            if ($params->sort == 30) {
                $order = '(sales_init + sales) desc';
            }

            // 自动获取
            if ($params->data == 10) {
                $filter = [];

                !empty($params->category) && $filter[] = ['category_id', '=', $params->category];

                $result = self::where($filter)
                    ->orderByRaw($order)
                    ->limit($params->limit)
                    ->get();
            } else {
                // 选择商品
                $id = array_column($params->goods, 'id');
                $filter[] = ['in' => ['id' => $id]];

                $result = self::whereIn('id', $id)
                    ->orderByRaw($order)
                    ->limit($params->limit)
                    ->get();
            }
            return $result;
        } catch(\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            return [];
        }
    }

    /**
     * 设计获取商品分组列表数据
     */
    public static function getDesignGoodsGroup(object $params)
    {
        try {
            $order = 'sort asc';
            if ($params->sort == 20) {
                $order = 'sales_price asc';
            }
            if ($params->sort == 30) {
                $order = '(sales_init + sales) desc';
            }

            $result = GoodsGroup::whereIn('id', $params->group)->orderBy('sort', 'asc')->get();
            foreach($result as $item) {
                $item->goods = $item->goods()
                    ->where('status', self::STATUS_ON)
                    ->orderByRaw($order)
                    ->limit($params->limit)
                    ->get();
            }
            return $result;
        } catch(\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
            return [];
        }
    }
}
