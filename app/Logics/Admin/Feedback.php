<?php

namespace App\Logics\Admin;

use App\Models\Feedback as FeedbackModel;
use Illuminate\Http\Request;

class Feedback extends FeedbackModel
{
    public static function getList()
    {
        $request = Request::capture();
        $category = $request->get('category');
        $contact = $request->get('contact');
        $content = $request->get('content');
        $sort = $request->get('sort');

        $filter = [];
        !empty($category) && $filter[] = ['category_id', '=', $category];
        !empty($contact) && $filter[] = ['contact', 'like', "%$contact%"];
        !empty($content) && $filter[] = ['content', 'like', "%$content%"];
        $order = 'feedback_time desc';
        !empty($sort) && $order = str_replace_first(':', ' ', $sort);

        return self::has('category')
            ->with(['category'])
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

    public static function remove(string $id)
    {
        return self::destroy(explode(',', $id)) > 0;
    }
}
