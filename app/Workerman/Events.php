<?php

namespace App\Workerman;

use App\User as AppUser;
use Illuminate\Support\Facades\Log;
use GatewayWorker\Lib\Gateway;
use App\User;
class Events
{

    public static function onWorkerStart($businessWorker)
    {
    }

    public static function onConnect($client_id)
    {
        Gateway::sendToClient($client_id, json_encode(array(
            'type'      => 'init',
            'client_id' => $client_id,
            
        )));
      
    }

    public static function onWebSocketConnect($client_id, $data)
    {
       
    }

    public static function onMessage($client_id, $message)
    {

        $api_token =Gateway::getUidByClientId($client_id);
        $user = User::query()->where('api_token',$api_token)->first(); 
        Gateway::sendToAll(json_encode(['type'=>'send','data'=>[
            'content'=>$message,
            'name'=>$user->name,
            'time'=>now()->toDateString('Y-m-d H:i:s'),
        ]]));
        
    }

    public static function onClose($client_id)
    {
    }
}
