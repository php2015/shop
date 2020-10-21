<?php

namespace App\Logics\Api;

use App\Models\Address as AddressModel;
use Illuminate\Http\Request;

class Address extends AddressModel
{
    public static function getList()
    {
        $request = Request::capture();
        $order = 'is_default desc';

        return User::model()->address()
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function saveData(array $data)
    {
        $user = User::model();
        $model = new static;
        if ($data['is_default'] == self::IS_DEFAULT_ON) {
            $user->address()->update(['is_default' => self::IS_DEFAULT_OFF]);
        }
        if (!empty($data['id'])) {
            $model = self::detail($data['id']);
        }

        $model->contact = $data['contact'];
        $model->phone = $data['phone'];
        $model->province = $data['province'];
        $model->city = $data['city'];
        $model->district = $data['district'];
        $model->detail = $data['detail'];
        $model->num = $data['num'];
        $model->is_default = $data['is_default'];
        $model->lon = $data['lon'];
        $model->lat = $data['lat'];
        return $user->address()
            ->save($model);
    }

    public static function default()
    {
        $address = User::model()
            ->address()
            ->where('is_default', self::IS_DEFAULT_ON)
            ->first();

        if (empty($address)) {
            $address = User::model()
                ->address()
                ->first();
        }
        return $address;
    }

    public static function remove(int $id)
    {
        return self::destroy($id) > 0;
    }
}
