<?php

namespace App\Logics\Api;

use App\Models\FeedbackCategory as FeedbackCategoryModel;

class FeedbackCategory extends FeedbackCategoryModel
{
    public static function getAll()
    {
        return self::orderBy('sort', 'asc')
            ->get();
    }
}