<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\Category;
use App\Logics\Api\Setting;
use Log;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $design = Setting::getInstance(
                'design.category'
            )->fetch();
            $object = $design[1];
            $layout = $object->data->layout;
        } catch(\Exception $e) {
        	Log::error($e->getMessage() . PHP_EOL);
            $layout = 40;
        }

        $result = [
            'template' => $layout,
            'goods' => []
        ];

        switch ($layout) {
            case 10:
            case 20:
            case 30:
                $result['category'] = Category::getList(1);
                break;
            case 40:
                $result['category'] = Category::getTree();
                break;
        }
        $this->renderSuccess( $result );
    }
}
