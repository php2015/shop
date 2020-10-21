<?php

namespace App\Logics\Api;

use App\Models\Cart as CartModel;
use App\Exceptions\AppException;

class Cart extends CartModel
{
    public static function getList()
    {
        $filter = ['user_id' => User::getId()];
        $order = 'created_at desc';
        
        return self::has('goods')
            ->with(['goods', 'sku'])
            ->where($filter)
            ->orderByRaw($order)
            ->get();
    }

    public static function getFailureList()
    {
        $filter = ['user_id' => User::getId()];
        $order = 'created_at asc';
        $list = [];

        $result = self::with(['goods', 'sku'])
            ->where($filter)
            ->orderByRaw($order)
            ->get();

        foreach ($result as $item) {
            if (empty($item['goods'])) {
                $list[] = $item;
            }
        }
        return $list;
    }

    /**
     * 获取用户购物车内商品总数
     * @return mixed
     */
    public static function getTotal()
    {
        if ($user_id = User::getId()) {
            return User::model()
                ->cart()
                ->has('goods')
                ->sum('quantity');
        }
    }

    /**
     * 添加到购物车
     * @param array $data
     * @return mixed
     * @throws AppException
     */
    public static function add(array $data)
    {
        $user = User::model();
        $model = $user->cart()
            ->where(['goods_sku_id' => $data['goods_sku_id']])
            ->first();

        if (empty($model)) $model = new static;
        $model->goods_id = $data['goods_id'];
        $model->goods_sku_id = $data['goods_sku_id'];
        $model->goods_name = $data['goods_name'];
        $model->sku_name = $data['sku_name'];
        $model->image = $data['image'];
        $model->sales_price = $data['sales_price'];
        $model->quantity += $data['quantity'];

        // 查询是否达到限购
        Goods::checkQuota($model->goods_id, $model->quantity);
        // 查询库存是否充足
        GoodsSku::checkStock($model->goods_sku_id, $model->quantity);
        return $user->cart()->save($model);
    }

    /**
     * 更新购物车
     *
     * @param array $data
     * @return mixed
     * @throws AppException
     */
    public static function change(array $data)
    {
        $model = User::model()->cart()
            ->where(['id' => $data['id']])
            ->first();

        // 查询是否达到限购
        Goods::checkQuota($model->goods_id, $data['quantity']);
        // 查询库存是否充足
        GoodsSku::checkStock($model->goods_sku_id, $data['quantity']);
        $model->quantity = $data['quantity'];
        return $model->save();
    }

    /**
     * 清空失效商品
     * @param string $id
     * @return bool
     */
    public static function clear()
    {
        $result = self::getFailureList();
        $id = [];

        foreach ($result as $item) {
            if (empty($item['goods'])) {
                $id[] = $item['id'];
            }
        }
        return self::destroy($id) > 0;
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}
