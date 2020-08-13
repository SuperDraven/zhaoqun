<?php

namespace App\Http\Controllers;

use App\service\WechatService;
use EasyWeChat\Kernel\Messages\Image;
use Illuminate\Http\Request;
use EasyWeChat\Kernel\Messages\Text;
use Illuminate\Support\Facades\Log;

class WechatController extends Controller
{
    //
    public $wechatService;
    public function __construct(WechatService $wechatServic)
    {
        $this->wechatService = $wechatServic;
    }

    public function Token()
    {
        $this->wechatService->downloadImage("https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1597293884936&di=8f2605bdc3da8106bef129118790ca1b&imgtype=0&src=http%3A%2F%2Fa2.att.hudong.com%2F36%2F48%2F19300001357258133412489354717.jpg");

    }
    public function getImg()
    {

        $this->wechatService->app->server->push(function ($message)  {
            $content = explode($message['Content'], ",");
            Log::info("用户输入:", $message);
            $img = $this->wechatService->send_post("http://www.yishuzi.com/b/re13.php", ["id"=>$content[1]]);
            Log::info("获取图片:", $img);

            preg_match('/<img.+src=\"?(.+\.(jpg|gif|bmp|bnp|png))\"?.+>/i',$img,$match);
            $mediaId = $this->wechatService->getMediaId($match[1]);
            Log::info("src:", $match[1]);

            $image = new Image($mediaId);
            Log::info("img:", $image);
            return $image;
        });

        $response = $this->wechatService->app->server->serve();
        return $response;

    }
}
