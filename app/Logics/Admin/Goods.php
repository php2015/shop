<?php

namespace App\Logics\Admin;

use App\Models\Goods as GoodsModel;
use App\Exceptions\AppException;
use Illuminate\Http\Request;
use DB;
use Log;

class Goods extends GoodsModel
{
    const ORDER_EXIST = '当前商品存在未完成的订单，禁止删除';

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) {
            $model->images()->delete();
            $model->sku()->delete();
            $model->skuValue()->delete();
            $model->comment()->delete();
            $model->group()->detach();
            $model->support()->detach();
            $model->like()->delete();
            $model->history()->delete();
        });
    }

    public static function getList()
    {
        $request = Request::capture();
        $type = $request->get('type');
        $goods_name = $request->get('goods_name');
        $sort = $request->get('sort');

        $filter = [];
        switch ($type) {
            case 1: // 销售中
                $filter[] = ['status', '=', self::STATUS_ON];
                $filter[] = ['stock', '>', 0];
                break;
            case 2: // 仓库中
                $filter[] = ['status', '=', self::STATUS_OFF];
                break;
            case 3: // 已售罄
                $filter[] = ['status', '=', self::STATUS_ON];
                $filter[] = ['stock', '=', 0];
                break;
        }
        !empty($goods_name) && $filter[] = ['goods_name', 'like', "%$goods_name%"];
        $order = 'sort asc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::with(['category', 'group'])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function getCount()
    {
        $count[] = self::where([
            ['status', '=', self::STATUS_ON],
            ['stock', '>', 0]
        ])->count();

        $count[] = self::where([
            ['status', '=', self::STATUS_OFF]
        ])->count();

        $count[] = self::where([
            ['status', '=', self::STATUS_ON],
            ['stock', '=', 0]
        ])->count();

        return $count;
    }

    public static function detail(int $id)
    {
        return self::with(['group', 'support', 'images'])
            ->findOrFail($id);
    }

    public static function getImages(int $id)
    {
        return self::with('images')
            ->select(['id', 'image'])
            ->findOrFail($id);
    }

    public static function getSale(int $id)
    {
        $detail = self::with(['sku.value.spec'])->findOrFail($id);
        $specValueDetail = self::with(['sku.value.specValue'])->findOrFail($id);
        $skuValues = $detail->sku[0]->value;
        $header = [];
        foreach ($skuValues as $item) {
            $header[] = $item->spec->name;
        }
        $data['header'] = $header;
        $data['sku'] = $specValueDetail->sku;
        $data['detail'] = $detail;
        return $data;
    }

    public static function add(array $data)
    {
        try {
            DB::beginTransaction();
            $data['goods_no'] = self::number();
            if ($model = self::create($data)) {
                $model->saveImages($data);
                $model->saveGroup($data);
                $model->saveSupport($data);
                $model->addSku($data);
            }
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public static function edit(array $data)
    {
        try {
            DB::beginTransaction();
            $model = self::detail($data['id']);
            if ($model->fill($data)->save()) {
                $model->saveImages($data);
                $model->saveGroup($data);
                $model->saveSupport($data);
            }
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    private function saveImages(array $data)
    {
        if (isset($data['image_list'])) {
            $this->images()->delete();
            $this->images()->saveMany(
                array_map(function ($value) {
                    return new GoodsImages(['name' => $value['name']]);
                }, $data['image_list'])
            );
        }
    }

    private function saveGroup(array $data)
    {
        if (isset($data['group'])) {
            $this->group()->detach();
            $this->group()->attach($data['group']);
        }
    }

    private function saveSupport(array $data)
    {
        if (isset($data['support'])) {
            $this->support()->detach();
            $this->support()->attach($data['support']);
        }
    }

    private function addSku(array $data)
    {
        // 初始销售价，用于比较最低价
        $sales_price = $data['sku'][0]['sales_price'];
        // 初始总库存
        $stock = 0;
        foreach ($data['sku'] as $key => $item) {
            // 找出价格最低sku
            $sales_price = $sales_price > $item['sales_price'] ? $item['sales_price'] : $sales_price;
            // 合计总库存
            $stock += $item['stock'];

            // 保存Sku
            $sku = $this->sku()->save(
                new GoodsSku([
                    'sku_id' => self::number(),
                    'sku_no' => isset($item['sku_no']) ? $item['sku_no'] : '',
                    'sku_name' => isset($item['sku_name']) ? $item['sku_name'] : '',
                    'sales_price' => isset($item['sales_price']) ? $item['sales_price'] : 0,
                    'cost_price' => isset($item['cost_price']) ? $item['cost_price'] : 0,
                    'weight' => isset($item['weight']) ? $item['weight'] : 0,
                    'stock' => isset($item['stock']) ? $item['stock'] : 0,
                    'points' => isset($item['points']) ? $item['points'] : 0,
                    'level_one' => isset($item['level_one']) ? $item['level_one'] : 0,
                    'level_two' => isset($item['level_two']) ? $item['level_two'] : 0,
                ])
            );

            if ($data['sku_type'] == self::SPEC_TYPE_MULTI) {
                // 规格值列表
                $spec_value_list = explode(':', $item['sku_no']);
                // 保存sku value
                foreach ($spec_value_list as $value) {
                    $specValue = SpecValue::detail($value);
                    $sku->value()->save(
                        new GoodsSkuValue([
                            'goods_id' => $this->id,
                            'spec_id' => $specValue->spec_id,
                            'spec_value_id' => $specValue->id
                        ])
                    );
                }
            }

        }
        $this->sales_price = $sales_price;
        $this->stock = $stock;
        $this->save();
    }

    public static function saveSale(array $data)
    {
        try {
            self::edit($data);
            // 初始销售价、划线价，用于比较最低价
            $sales_price = $data['sku'][0]['sales_price'];
            // 初始总库存
            $stock = 0;
            foreach ($data['sku'] as $item) {
                // 找出价格最低sku
                $sales_price = $sales_price > $item['sales_price'] ? $item['sales_price'] : $sales_price;
                // 合计总库存
                $stock += $item['stock'];

                $sku = GoodsSku::detail($item['id']);
                $sku->sku_name = isset($item['sku_name']) ? $item['sku_name'] : '';
                $sku->sales_price = isset($item['sales_price']) ? $item['sales_price'] : 0;
                $sku->cost_price = isset($item['cost_price']) ? $item['cost_price'] : 0;
                $sku->weight = isset($item['weight']) ? $item['weight'] : 0;
                $sku->stock = isset($item['stock']) ? $item['stock'] : 0;
                $sku->points = isset($item['points']) ? $item['points'] : 0;
                $sku->level_one = isset($item['level_one']) ? $item['level_one'] : 0;
                $sku->level_two = isset($item['level_two']) ? $item['level_two'] : 0;
                $sku->save();
            }
            // 更新销售价和总库存
            $goods = self::detail($data['id']);
            $goods->sales_price = $sales_price;
            $goods->stock = $stock;
            $goods->save();
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public static function changeStatus(array $data)
    {
        try {
            DB::beginTransaction();
            $id = explode(',', $data['id']);
            self::whereIn('id', $id)->update([
                'status' => $data['value']
            ]);
            DB::commit();
            return true;
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    public static function remove(string $id)
    {
        try {
            DB::beginTransaction();
            $order = self::has('order')->where('id', $id)->first();
            if (!empty($order)) {
                throw new AppException();
            }
            self::destroy($id);
            DB::commit();
            return true;
        } catch(AppException $e) {
            throw new AppException(self::ORDER_EXIST);
        } catch(\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage() . PHP_EOL);
        }
    }

    /**
     * Dialog 选择商品
     * @return mixed
     */
    public static function getSelectList()
    {
        $request = Request::capture();
        $goods_name = $request->get('name');
        $sort = $request->get('sort');

        $filter[] = ['status', '=', self::STATUS_ON];
        !empty($goods_name) && $filter[] = ['goods_name', 'like', "%$goods_name%"];
        $order = 'created_at desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    private static function number()
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
