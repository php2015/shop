<?php

namespace App\Http\Controllers\Api;

use App\Logics\Api\GoodsHistory;

class GoodsHistoryController extends Controller
{
    public function index()
    {
        $this->renderSuccess(
            GoodsHistory::getList()
        );
    }

    public function remove()
    {
        $this->validate([
            'id' => 'required|int',
        ]);

        if (GoodsHistory::remove($this->request->post('id')) === true) {
            $this->renderSuccess();
        }
        $this->renderError();
    }

    private function format($list)
    {
        $year = date('Y');
        $visit_list = [];
        foreach ($list as $v) {
            if ($year == date('Y', $v['visittime'])) {
                $date = date('m月d日', $v['visittime']);
            } else {
                $date = date('Y年m月d日', $v['visittime']);
            }
            $visit_list[$date][] = $v;
        }
        return $visit_list;
    }
}
