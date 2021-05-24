<?php

namespace App\Workerman;

use Illuminate\Support\Facades\Log;
use GatewayWorker\Lib\Gateway;

class Events
{

    public static function onWorkerStart($businessWorker)
    {
    }

    public static function onConnect($client_id)
    {
    }

    public static function onWebSocketConnect($client_id, $data)
    {
        var_export($data);
        if (!isset($data['get']['api_token'])) {
             Gateway::closeClient($client_id);
        }
        Log::info("$data");
    }

    public static function onMessage($client_id, $message)
    {
        Log::info("{$message}");
    }

    public static function onClose($client_id)
    {
    }
}
