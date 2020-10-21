<?php

namespace App\Services\Storage\Engine;

use Log;
use Image;
use Qcloud;

class Tencent extends Server
{
    private $cosClient;

    public function __construct(array $config)
    {
        $config['schema'] = 'https://';

        parent::__construct($config);

        $this->cosClient = new Qcloud\Cos\Client([
            'region' => $config['region'],
            'schema' => 'https',
            'credentials' => [
                'secretId'  => $config['secret_id'],
                'secretKey' => $config['secret_key']
            ]
        ]);
    }

    public function upload()
    {
        try{
            $object = $this->config['path'] . $this->getFileName();
            $filePath = $this->file->getRealPath();
            $result = $this->cosClient->putObject([
                'Bucket' => $this->config['tencent_bucket'],
                'Key' => $object,
                'Body' => fopen($filePath, "rb")
            ]);
            $this->fileName = $this->config['schema'] . $result['Location'];
            unlink($filePath);
            return true;
        } catch(\Exception $e) {
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
            $result = $this->cosClient->putObject([
                'Bucket' => $this->config['tencent_bucket'],
                'Key' => $object,
                'Body' => $content
            ]);
            $this->fileName = $this->config['schema'] . $result['Location'];
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
