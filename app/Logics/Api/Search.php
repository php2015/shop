<?php

namespace App\Logics\Api;

use App\Models\Search as SearchModel;
use Illuminate\Http\Request;

class Search extends SearchModel
{
    public static function getAll()
    {
        if ($userId = User::getId()) {
            return self::where('user_id', $userId)->get();
        }
        return [];
    }

    public static function saveData()
    {
        $request = Request::capture();
        $keyword = $request->get('keyword');

        if ($userId = User::getId()) {
            $model = self::where([
                'keyword' => $keyword,
                'user_id' => $userId
            ])->first();

            if (empty($model)) {
                $model = new static;
                $model->keyword = $keyword;
                $model->search_time = time();
                $model->user_id = $userId;
                $model->save();
            }
        }
    }

    public static function clearHistory()
    {
        if ($userId = User::getId()) {
            self::where('user_id', $userId)->delete();
        }
    }
}
