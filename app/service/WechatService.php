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
    public function send_post($url, $post_data) {
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    public function getMediaId($url = '')
    {
        if (!empty($url)) {
            $cache_key = 'get_media_id_' . $url;
            $media_id = cache($cache_key);
            if ($media_id === false) {
                $imagePath = $this->downloadImage($url);
                $data = [
                    'midia' => realpath('.' . $imagePath),
                ];
                try {
                    $result = $this->app->media->uploadImage($data['midia']);
                    if ($result['media_id']) {
                        $media_id = $result['media_id'];
                        cache($cache_key, $media_id, 60 * 60 * 48);
                    }
                } catch (\Exception $e) {

                }

            }
            return $media_id;
        }
        return false;
    }
    public function downloadImage($url)
    {
        set_time_limit(0);
        $saveDir = '/uploads/' . date('Ymd');
        if (!is_dir("." . $saveDir)) {
            mkdir("." . $saveDir, 0777, true);
        }
        $saveSrc = $saveDir . '/' . md5($url) . ".jpg";
        try {
            $res = file_get_contents($url);
            if (false === $res) {
                return '';
            }
            file_put_contents("." . $saveSrc, $res);
            return $saveSrc;
        } catch (\Exception $e) {
            return '';
        }
    }
}
