<?php

namespace App\Handlers;

use App\Models\Action_log;
use App\Models\All_log;
use App\Models\Error_log;

class Log
{
    const NAME = "Log stat";

    const SIGNATURE_ERROR = 001;
    const ERROR_MAPPING = [
        self::SIGNATURE_ERROR => '找不到 header 簽名或簽名不匹配'
    ];

    /**
     * @param $request
     * @return mixed
     */
    public function log_all($request)
    {
        $log = new All_log();
        $log->request = json_encode($request, JSON_UNESCAPED_UNICODE);
        $log->save();

        return $log->id;
    }

    /**
     * @param $code
     * @param $message
     * @return mixed
     */
    public function log_error($code, $message = null)
    {
        $log = new Error_log();
        $log->code = $code;
        $log->message = (is_null($message)) ? self::ERROR_MAPPING[$code] : $message;
        $log->save();
        return $log->id;

    }

    /**
     * @param $userId
     * @param $event
     * @param $timestamp
     * @return mixed
     */
    public function log_action($userId, $event, $timestamp)
    {
        $log = new Action_log();
        $log->useId = $userId;
        $log->event = $event;
        $log->api_timestamp = $timestamp;
        $log->save();

        return $log->id;
    }

    /**
     * @param $log_id
     * @param $replyType
     * @param $replyContent
     * @return void
     */
    public function log_action_update($log_id, $replyType, $replyContent)
    {
        $log = Action_log::find($log_id);
        $log->reply_type = $replyType;
        $log->reply_content = json_encode($replyContent->buildMessage(), JSON_UNESCAPED_UNICODE);
        $log->save();
    }
    public function log($type, $msg)
    {
        $log_file = sprintf("Line-%s.txt", date('Y-m-d'));
        $fp = fopen(storage_path('logs/'.$log_file), 'a+');
        fwrite($fp, json_encode($msg, JSON_UNESCAPED_UNICODE));
        fwrite($fp,PHP_EOL);
        fclose($fp);
    }
}