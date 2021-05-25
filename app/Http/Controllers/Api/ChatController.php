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
        $client_id = $request->client_id;

        // client_id与uid绑定
        Gateway::bindUid($client_id, $uid);
        $data = [
            'type' => 'say',
            'data' => [
                'name' => $user->name,
                'email' => $user->email,
                'content' => $user->name . '加入聊天室',
                'time' => now()->toDateString('Y-m-d H:i:s'),
            ],
        ];
        Gateway::sendToAll(json_encode($data));
    }
}
