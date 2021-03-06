<?php

namespace App\Logics\Api;

use App\Models\Feedback as FeedbackModel;

class Feedback extends FeedbackModel
{
    public static function saveData(array $data)
    {
        $model = new static;
        $model->category_id = $data['category_id'];
        $model->contact = $data['contact'];
        $model->content = $data['content'];
        $model->feedback_time = time();
        return $model->save();
    }
}