<?php

namespace App\Logics\Admin;

use App\Models\OrderInvoice as OrderInvoiceModel;
use Illuminate\Http\Request;

class OrderInvoice extends OrderInvoiceModel
{
    public static function getList()
    {
        $request = Request::capture();
        $title = $request->get('title');
        $sort = $request->get('sort');

        $filter = [];
        !empty($title) && $filter[] = ['title', 'like', "%$title%"];
        $order = 'id desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::with('order')
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::with('order')
            ->findOrFail($id);
    }

    public static function issue(array $data)
    {
        $detail = self::detail($data['id']);
        $detail->tax = $data['tax'];
        $detail->code = $data['code'];
        $detail->issue_time = time();
        $detail->status = $data['status'];
        return $detail->save();
    }
}
