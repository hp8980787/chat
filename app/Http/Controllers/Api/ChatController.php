<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use GatewayWorker\Lib\Gateway;

class ChatController extends Controller
{
    public function join(Request $request)
    {
        $user = Auth::guard('api')->user();

        // 假设用户已经登录，用户uid和群组id在session中
        $uid      = $user->api_token;
        $data = $request->msg;
        $client_id = $data['client_id'];
       
        // client_id与uid绑定
        Gateway::bindUid($client_id, $uid);
        // 加入某个群组（可调用多次加入多个群组）
        Gateway::sendToUid($uid, 'sadsadas');
        return response($user);
    }
}
