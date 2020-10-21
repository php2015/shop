<?php

namespace App\Logics\Api;

use App\Models\Invoice as InvoiceModel;

class Invoice extends InvoiceModel
{
    public static function info()
    {
        return User::model()->invoice;
    }

    public static function saveData(array $data)
    {
        $user = User::model();
        if (!$model = $user->invoice) {
            $model = new static;
            $model->user_id = $user->id;
        }
        $model->category = $data['category'] == 0 ? self::CATEGORY_PERSON : self::CATEGORY_COMPANY;
        $model->title = $data['title'];
        $model->tax_no = $data['tax_no'];
        $model->phone = $data['phone'];
        $model->email = $data['email'];
        return $model->save();
    }
}
