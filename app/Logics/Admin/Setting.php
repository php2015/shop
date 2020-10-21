<?php

namespace App\Logics\Admin;

use App\Models\Setting as SettingModel;
use File;
use Cache;

class Setting extends SettingModel
{
    /**
     * 保存设置内容
     *
     * @param $data
     * @return bool
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function saveDate($data)
    {
        $this->where([
            'category' => $this->params['category'],
            'key' => $this->params['key'],
        ])->delete();

        $this->category = $this->params['category'];
        $this->key = $this->params['key'];
        $this->values = $data;

        $method = 'save' . ucfirst($this->params['category']) . ucfirst($this->params['key']);
        if (method_exists($this, $method)) {
            $this->{$method}();
        }
        Cache::store('file')->forget('setting_' . $this->params['category'] . '_' . $this->params['key']);
        Cache::store('file')->forget('setting_' . $this->params['category']);
        return $this->save();
    }

    /**
     * 处理系统基础设置中的logo
     * @return mixed
     */
    public function fetchSystemBase()
    {
        if ($this->values->url = $this->values->logo) {
            if (strpos($this->values->url, 'http') === false) {
                $path =  config('filesystems.disks.console.logo.path');
                $this->values->url = config('app.url') . $path . $this->values->logo;
            }
        }
    }

    /**
     * 保存微信支付设置，上传证书
     */
    public function saveWechatPayment()
    {
        if ($values = json_decode($this->values)) {
            if (!empty($values->apiclient_key) && !empty($values->apiclient_cert)) {
                $apiclient_key = $values->apiclient_key;
                $apiclient_cert = $values->apiclient_cert;
                $path = base_path('cert');

                if (!File::isDirectory($path)) {
                    File::makeDirectory($path);
                }
                File::put($path . '/apiclient_key.pem', $apiclient_key);
                File::put($path . '/apiclient_cert.pem', $apiclient_cert);
            }
            unset($values->apiclient_key);
            unset($values->apiclient_cert);
            $this->values = json_encode($values);
        }
    }
}
