<?php

namespace App\Http\Controllers\Api;

use App\Services\Storage\Factory;

class UploadController extends Controller
{
    public function index(string $action = '', int $width = 0, int $height = 0)
    {
        $storage = Factory::getInstance($action);

        if (empty($width) && empty($height)) {
            $result = $storage->upload();
        } else {
            $result = $storage->uploadAndResize($width, $height);
        }

        if ($result) {
            $url = $storage->getFileName();
            if (strpos($url, 'http') === false) {
                $path = config('filesystems.disks.' . $action . '.path');
                $url = config('app.url') . $path . $url;
            }
            $this->renderSuccess([
                'file' => $url,
                'url' => $url
            ], '上传成功');
        }
        $this->renderError([], '上传失败');
    }
}
