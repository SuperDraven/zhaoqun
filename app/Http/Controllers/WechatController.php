<?php

namespace App\Http\Controllers;

use App\service\WechatService;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    //

    public function Token(WechatService $wechatService)
    {

        $response = $wechatService->app->server->serve();
        return $response;

    }
}
