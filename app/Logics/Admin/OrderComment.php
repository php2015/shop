<?php

namespace App\Logics\Admin;

use App\Models\OrderComment as OrderCommentModel;
use Illuminate\Http\Request;

class OrderComment extends OrderCommentModel
{
    public static function getList()
    {
        $request = Request::capture();
        $content = $request->get('content');
        $reply_content = $request->get('reply_content');
        $sort = $request->get('sort');

        $filter = [];
        !empty($content) && $filter[] = ['content', 'like', "%$content%"];
        !empty($reply_content) && $filter[] = ['reply_content', 'like', "%$reply_content%"];
        $order = 'comment_time desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::has('goods')
            ->with(['goods', 'user', 'images'])
            ->where($filter)
            ->orderByRaw($order)
            ->paginate(
                $request->get('limit', self::PAGE)
            );
    }

    public static function detail(int $id)
    {
        return self::findOrFail($id);
    }

    public static function changeStatus(array $data)
    {
        $model = self::detail($data['id']);
        $model->{$data['field']} = $model->{$data['field']} == 10 ? 20 : 10;
        $model->save();
        return true;
    }

    public static function reply(array $data)
    {
        $model = self::detail($data['id']);
        $model->reply_content = $data['reply_content'];
        $model->reply_time = time();
        return $model->save();
    }

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}
