<?php


namespace App\service;
use EasyWeChat\Factory;

class WechatService
{

    public $app;
    public function __construct()
    {
        $config = [
            'app_id' => 'wx91cbc94685929557',
            'secret' => '30484c35837b5d7c124b50381a490819',
            'token' => 'woyaozhaoqun',
            'response_type' => 'array',
            //...
        ];
        $this->app = Factory::officialAccount($config);
    }
}
