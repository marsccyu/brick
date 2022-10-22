<?php

namespace App\Handlers;

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

    public function memberMessage()
    {
        $message =  new \LINE\LINEBot\MessageBuilder\RawMessageBuilder(
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
                                "url" => "https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_1_cafe.png",
                                "size" => "full",
                                "aspectRatio" => "20:13",
                                "aspectMode" => "cover",
                                "action" => [
                                    "type" => "uri",
                                    "uri" => "http://linecorp.com/"
                                ]
                            ],
                        ]
                    ]
                ],
            ]
        );

        return ['message', $message];
    }

    public function contactMessage()
    {
        $message = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder(sprintf("這是 %s 回覆內容",'-聯絡我們-'));

        return ['message', $message];
    }
}