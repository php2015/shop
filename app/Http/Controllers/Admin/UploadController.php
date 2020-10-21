<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AppException;
use App\Services\Storage\Factory;
use Log;

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
            $file = $storage->getFileName();
            if (strpos($file, 'http') === false) {
                $path = config('filesystems.disks.' . $action . '.path') . $file;
                $url = config('app.url') . $path;
            } else {
                $url = $file;
            }
            $this->renderSuccess([
                'file' => $file,
                'url' => $url
            ], '上传成功');
        }
        $this->renderError([], '上传失败');
    }
}
