<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LineController extends Controller
{
    private $bot;

    public function __construct()
    {
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(env('LINE_ACCESS_TOKEN'));
        $this->bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('LINE_SECRET')]);
    }

	public function index(Request $request)
	{
        $signature = null;

        // all request
        $all = $request->all();

        // 先檢查簽名
        $headers = $request->header();
        foreach ($headers as $key => $value)
        {
            if (strtolower($key) == 'x-line-signature')
            {
                $signature = $value;
            }
        }

        // 找不到 Line header "x-line-signature" 簽名
        if (is_null($signature))
        {
            return response()->json(['success'=>'success'], 200);
        }

        // 找到簽名, 進行比對
        if (!$signature_match = $this->signature_validation($signature, $request->getContent()))
        {
            // 簽名不匹配
            return response()->json(['success'=>'success'], 200);
        }

        $this->logtxt('簽名比對正確, 進行動作');

        // events
        $event = $all['events'][0];
        // event type
        $eventType = $event['type'];

        switch ($eventType)
        {
            // 訊息模式
            case 'message':
                $type = $event['message']['type'];

                if ($type != 'text')
                {
                    // 不是文字訊息類型不處理
                    return response()->json(['success'=>'success'], 200);
                }

                $reply = $this->text_handler($event);

                //$event['timestamp'];
                //$event['source']['userId'];
                //$event['replyToken'];

                // 回覆
                if ($reply['type'] == 'text')
                {
                    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($reply['reply_text']);
                    $response = $this->bot->replyMessage($event['replyToken'], $textMessageBuilder);

                    $this->logtxt( $response->getHTTPStatus() . ' ' . $response->getRawBody());
                }

                break;

            // post 模式
            case 'postback':
                break;
        }

        return response()->json(['success'=>'success'], 200);
	}

    public function text_handler($event)
    {
        // user input text
        $text = $event['message']['text'];
        $this->logtxt(sprintf('Get TEXT From User : %s', $text));

        $replyText = '';
        switch ($text)
        {
            case '關於我們':
                // 關於我們回覆
                $replyText = sprintf("這是 %s 回覆內容", $text);
                break;
            case '課程介紹':
                // 課程介紹回覆
                $replyText = sprintf("這是 %s 回覆內容", $text);
                break;
            case '會員專區':
                // 會員專區回覆
                $replyText = sprintf("這是 %s 回覆內容", $text);
                break;
            case '聯絡我們':
                //聯絡我們回覆
                $replyText = sprintf("這是 %s 回覆內容", $text);
                break;
        }

        return ['type' => 'text', 'reply_text' => $replyText];
    }

    private function signature_validation($signature, $httpRequestBody)
    {
        $hash = hash_hmac('sha256', $httpRequestBody, env('LINE_SECRET'), true);
        $v_signature = base64_encode($hash);
        return hash_equals($signature[0], $v_signature);
    }

    public function logtxt($msg)
    {
        $fp = fopen(storage_path('app/line.txt'), 'a+');
        fwrite($fp, json_encode($msg, JSON_UNESCAPED_UNICODE));
        fwrite($fp,PHP_EOL);
        fclose($fp);
    }
}
