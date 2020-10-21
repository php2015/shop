<?php

namespace App\Services\Storage\Engine;

use Log;
use Image;
use OSS\OssClient;
use OSS\Core\OssException;

class Ali extends Server
{
    private $ossClient;

    public function __construct(array $config)
    {
        $config['schema'] = 'https://';

        parent::__construct($config);

        $this->ossClient = new OssClient(
            $config['app_id'],
            $config['app_secret'],
            $config['endpoint']
        );
    }

    public function upload()
    {
        try{
            $object = $this->config['path'] . $this->getFileName();
            $filePath = $this->file->getRealPath();
            $this->ossClient->uploadFile($this->config['bucket'], $object, $filePath);
            $this->fileName = $this->config['schema'] . $this->config['bucket'] . '.' . $this->config['endpoint'] . '/' . $object;
            unlink($filePath);
            return true;
        } catch(OssException $e) {
            Log::error($e->getMessage());
        }
    }

    public function uploadAndResize(int $width, int $height)
    {
        try {
            $width = $width ? $width : null;
            $height = $height ? $height : null;
            $object = $this->config['path'] . $this->getFileName();
            $content = Image::make($this->file)
                ->resize($width, $height, function($constraint) {
                    $constraint->aspectRatio();
                })
                ->encode()
                ->encoded;
            $this->ossClient->putObject($this->config['bucket'], $object, $content);
            $this->fileName = $this->config['schema'] .  $this->config['bucket'] . '.' . $this->config['endpoint'] . '/' . $object;
            return true;
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public function getFileName()
    {
        return $this->fileName;
    }
}
