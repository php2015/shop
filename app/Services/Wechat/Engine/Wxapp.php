<?php

namespace App\Services\Wechat\Engine;

use App\Exceptions\AppException;
use EasyWeChat\Factory;

class Wxapp extends Server
{
    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->app = Factory::miniProgram([
            'app_id' => $config['app_id'],
            'secret' => $config['app_secret']
        ]);
    }

    /**
     *  获取小程序登录用户的session
     *
     * @param string $code
     * @return array|\EasyWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     * @throws AppException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getSession(string $code)
    {
        $result = $this->app->auth->session($code);
        if (isset($result['errcode'])) {
            throw new AppException('未获取到微信信息');
        }
        return $result;
    }

    /**
     * 生成小程序码
     *
     * @param string $scene
     * @param int $width
     * @return string
     */
    public function getUnlimit(string $scene, int $width = 280)
    {
        $response = $this->app->app_code->getUnlimit($scene, [
            'width' => $width,
        ]);
        if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
            return $response->getBody()->getContents();
        }
        return '';
    }
}
