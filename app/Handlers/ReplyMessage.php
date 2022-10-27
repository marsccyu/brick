<?php

namespace App\Handlers;

use App\Handlers\Log;
use App\Models\Action_log;
use App\Models\All_log;
use App\Models\Error_log;

class ReplyMessage
{
    private $user_id;

    public function __construct($event)
    {
        $this->user_id = $event['source']['userId'];
    }

    public function aboutMessage()
    {
        $message = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder(sprintf("這是 %s 回覆內容",'-關於我們-'));
        return ['message', $message];
    }

    public function lessonsMessage()
    {
        $message = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder(sprintf("這是 %s 回覆內容",'-課程介紹-'));

        return ['message', $message];
    }

    public function memberMessage($message)
    {
        $messageBuilder =  new \LINE\LINEBot\MessageBuilder\RawMessageBuilder(
            [
                'type' => 'flex',
                'altText' => 'alt test',
                'contents' => [
                    'type' => 'bubble',
                    'size' => 'kilo',
                    'hero' => [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'contents' => [
                            [
                                'type' => 'image',
                                "url" => asset('storage/images/2.jpg'),
                                "size" => "full",
                                "aspectRatio" => "20:13",
                                "aspectMode" => "cover",
                                "action" => [
                                    "type" => "uri",
                                    "uri" => "http://linecorp.com/"
                                ]
                            ],
                        ],
                    ],
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "box",
                                "layout" => "vertical",
                                "margin" => "lg",
                                "spacing" => "sm",
                                "contents" => [
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => "sm",
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => $message,
                                                "wrap" => true,
                                                "color" => "#666666",
                                                "size" => "sm",
                                                "flex" => 5,
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                        ]
                    ],
                    "footer" => [
                        "type"=> "box",
                        "layout"=> "vertical",
                        "spacing"=> "sm",
                        "contents"=> [
                            [
                                "type"=> "button",
                                "style"=> "link",
                                "height"=> "sm",
                                "action" => [
                                    "type" => "uri",
                                    "label" => "加入會員",
                                    "uri" => 'https://google.com',
                                ]
                            ]
                        ],
                        "flex"=> 0
                    ]
                ],
            ]
        );

        return ['message', $messageBuilder];
    }

    public function contactMessage()
    {
        $message = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder(sprintf("這是 %s 回覆內容",'-聯絡我們-'));

        return ['message', $message];
    }
}