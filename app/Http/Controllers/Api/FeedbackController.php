<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Feedback;
use App\Logics\Api\FeedbackCategory;

class FeedbackController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            FeedbackCategory::getAll()
        );
    }

    public function save()
    {
        $this->validate([
            'category_id' => 'required|int',
            'contact' => 'required|string',
            'content' => 'required|string',
        ]);

        if (Feedback::saveData( $this->request->all() )) {
            $this->renderSuccess();
        }
        $this->renderError();
    }
}