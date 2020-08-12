<?php

namespace App\Http\Controllers;

use App\service\WechatService;
use Illuminate\Http\Request;

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

        $response = $this->wechatService->app->server->serve();
        return $response;

    }
    public function getImg()
    {
//        $string = "赵博";
//        $response = $this->wechatService->send_post("http://www.yishuzi.com/b/re13.php", ['id'=>$string]);
        $response = $this->wechatService->app->server->push(function ($message)  {
//            return $response;
            return "您好！欢迎来到 我要找群";
        });
        info($response);
//        $response = $this->wechatService->app->server->serve();
        return $response;

    }
}
