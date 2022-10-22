<?php

namespace App\Http\Controllers;

use App\Handlers\Log;
use App\Handlers\ReplyMessage;
use App\Models\Action_log;
use App\Models\Error_log;
use App\Models\All_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;

class LineController extends Controller
{
    // 可以輸入的關鍵字
    const ABOUT   = "關於工作室";
    const LESSONS = "課程介紹";
    const MEMBER  = "會員專區";
    const CONTACT = "聯絡我們";

    private $bot;
    private $log;
    private $all_request;
    private array $keyword_array = [self::ABOUT, self::LESSONS, self::MEMBER, self::CONTACT];

    public function __construct()
    {
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(env('LINE_ACCESS_TOKEN'));
        $this->bot = new \LINE\LINEBot($httpClient, ['channelSecret' => env('LINE_SECRET')]);

        $this->log = new Log();
    }

    public function test()
    {
        $co = new \LINE\LINEBot\MessageBuilder\RawMessageBuilder(
            [
                'type' => 'flex',
                'altText' => 'alt test',
                'contents' => [
                    'type' => 'bubble',
                    'body' => [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'contents' => [
                            [
                                'type' => 'text',
                                'text' => 'Hello,'
                            ],
                            [
                                'type' => 'text',
                                'text' => 'World!'
                            ]
                        ]
                    ]
                ],
                'quickReply' => [
                    'items' => [
                        [
                            'type' => 'action',
                            'action' => [
                                'type' => 'message',
                                'label' => 'reply1',
                                'text' => 'Reply1'
                            ]
                        ],
                        [
                            'type' => 'action',
                            'action' => [
                                'type' => 'message',
                                'label' => 'reply2',
                                'text' => 'Reply2'
                            ]
                        ]
                    ]
                ]
            ]
        );

        dd($co);
    }
    
	public function index(Request $request)
	{
        $signature = null;

        // all request
        $all = $request->all();
        $this->all_request = $all;
        $this->log->log_all($all);

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
            $this->log->log_error(Log::SIGNATURE_ERROR);
            return response()->json(['success'=>'success'], 200);
        }

        // 找到簽名, 進行比對
        if (!$signature_match = $this->signature_validation($signature, $request->getContent()))
        {
            // 簽名不匹配
            $this->log->log_error(Log::SIGNATURE_ERROR);
            return response()->json(['success'=>'success'], 200);
        }

        $this->log->log('log', '簽名比對正確, 進行動作');

        // 處理 events, 可能為多動作的陣列
        foreach ($all['events'] as $key => $event)
        {
            // event type
            $eventType = $event['type'];
            $sourceUserID = $event['source']['userId'];

            // event log
            $log_id = $this->log->log_action($sourceUserID, $eventType, $event['timestamp']);

            switch ($eventType)
            {
                // 訊息模式
                case 'message':
                    $messageType = $event['message']['type'];
                    $messageText = $event['message']['text'];

                    // 不是文字訊息類型不處理
                    if ($messageType != 'text')
                    {
                        return response()->json(['success'=>'success'], 200);
                    }

                    // 取回 MessageBuilder
                    list($type, $replyContent) = $this->text_handler($event);

                    $response = $this->bot->replyMessage($event['replyToken'], $replyContent);
                    $this->log->log('log', sprintf("%s %s", $response->getHTTPStatus(), $response->getRawBody()));

                    break;

                // post 模式
                case 'postback':
                    break;
            }

            $this->log->log_action_update($log_id, $type, $replyContent);
        }

        return response()->json(['success'=>'success'], 200);
	}

    public function text_handler($event)
    {
        // user input text
        $text = $event['message']['text'];
        $this->log->log('log', sprintf('Get TEXT From User : %s', $text));

        $replyText = '';
        $type = 'text';
        $replyMessage = New ReplyMessage($event);
        switch ($text)
        {
            case self::ABOUT:
                // 關於我們回覆
                return $replyMessage->aboutMessage();
            case self::LESSONS:
                // 課程介紹回覆
                return $replyMessage->lessonsMessage();
            case self::MEMBER:
                // 會員專區回覆
                return $replyMessage->memberMessage();
            case self::CONTACT:
                //聯絡我們回覆
                return $replyMessage->contactMessage();
            default:
                return new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('無法處理的訊息。');

        }
    }

    private function signature_validation($signature, $httpRequestBody)
    {
        $hash = hash_hmac('sha256', $httpRequestBody, env('LINE_SECRET'), true);
        $v_signature = base64_encode($hash);
        return hash_equals($signature[0], $v_signature);
    }

}
