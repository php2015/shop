<?php

namespace App\Services\Storage\Engine;

use Storage;
use Log;
use Image;

class Local extends Server
{
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function upload()
    {
        try {
            return Storage::disk('upload')->putFileAs(
                    $this->config['path'],
                    $this->file,
                    $this->fileName
            );
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function uploadAndResize(int $width, int $height)
    {
        try {
            $width = $width ? $width : null;
            $height = $height ? $height : null;
            return Storage::disk('upload')->put(
                $this->config['path'] . $this->fileName,
                Image::make($this->file)
                    ->resize($width, $height, function($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->encode()
                    ->encoded
            );
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function getFileName()
    {
        return $this->fileName;
    }
}
