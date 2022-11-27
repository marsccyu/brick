<?php

namespace App\Handlers;

use App\Handlers\Log;
use App\Models\Action_log;
use App\Models\All_log;
use App\Models\Error_log;
use App\Models\Site_config;

class ReplyMessage
{
    const NONE = "none";
    const XS = "xs";
    const SM = "sm";
    const MD = "md";
    const LG = "lg";
    const XL = "xl";
    const XXL = "xxl";

    const NAME_COLOR = "#007bff";

    private $userId;

    public function __construct($event)
    {
        $this->userId = $event['source']['userId'];
    }

    // 關於我們
    public function aboutMessage($params)
    {
        $messageBuilder =  new \LINE\LINEBot\MessageBuilder\RawMessageBuilder(
            [
                'type' => 'flex',
                'altText' => "關於秘密積地工作室",
                'contents' => [
                    "type" => "bubble",
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "關於 " . $params['title'],
                                "weight" => "bold",
                                "size" => self::XL
                            ],
                            [
                                "type" => 'separator',
                                "margin" => self::LG
                            ],
                            [
                                "type" => "box",
                                "layout" => "vertical",
                                "margin" => self::LG,
                                "spacing" => self::SM,
                                "contents" => [
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => self::SM,
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => $params['message'],
                                                "wrap" => true,
                                                "color" => "#666666",
                                                "size" => self::SM,
                                                "flex" => 5
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]

                    ]
                ],
            ]
        );

        return ['message', $messageBuilder];
    }

    // 課程介紹
    public function lessonsMessage($params)
    {
        $lessons_content = [];

        foreach ($params['lessons'] as $lesson)
        {
            $lessons_content[] = [
                "type" => "bubble",
                "size" => "kilo",
                "hero" => [
                    "type" => "image",
                    "url" => asset('storage/' . $lesson['image']),
                    "size" => "full",
                    "aspectMode" => "cover",
                    "aspectRatio" => "220:200"
                ],
                "body" => [
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => [
                        [
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => [
                                [
                                    "type" => "text",
                                    "text" => $lesson['title'],
                                    "weight" => "bold",
                                    "size" => self::MD,
                                    "wrap" => true,
                                    "flex" => 3,
                                    "adjustMode" => "shrink-to-fit",
                                ],
                                [
                                    "type" => "text",
                                    "text" => $lesson['subtitle'],
                                    "wrap" => true,
                                    "color" => "#8c8c8c",
                                    "size" => self::XS,
                                    "flex" => 4,
                                    "adjustMode" => "shrink-to-fit",
                                    "gravity" => "bottom",
                                    "align" => "end",
                                ],
                            ]
                        ],
                        [
                            "type" => 'separator',
                            "margin" => self::LG
                        ],
                        [
                            "type" => "box",
                            "layout" => "vertical",
                            "contents" => [
                                [
                                    "type" => "box",
                                    "layout" => "baseline",
                                    "spacing" => self::SM,
                                    "contents" => [
                                        [
                                            "type" => "text",
                                            "text" => $lesson['content'],
                                            "wrap" => true,
                                            "color" => "#8c8c8c",
                                            "size" => self::XS,
                                            "flex" => 5
                                        ]
                                    ]
                                ]
                            ],
                            "paddingTop" => '10px'
                        ]
                    ],
                    "spacing" => self::SM,
                    "paddingAll" => "13px"
                ]
            ];
        }

        $messageBuilder =  new \LINE\LINEBot\MessageBuilder\RawMessageBuilder(
            [
                'type' => 'flex',
                'altText' => "課程介紹",
                'contents' => [
                    "type" => "carousel",
                    "contents" => $lessons_content
                ],
            ]
        );

        return ['message', $messageBuilder];
    }

    // 會員專區 [已註冊]
    public function memberMessage($params)
    {
        $body_contents = [
            [
                "type" => "box",
                "layout" => "vertical",
                "margin" => self::LG,
                "spacing" => self::SM,
                "contents" => [
                    [
                        "type" => "box",
                        "layout" => "baseline",
                        "spacing" => self::SM,
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => $params['title'],
                                "wrap" => true,
                                "color" => "#666666",
                                "size" => self::SM,
                                "flex" => 5,
                            ]
                        ]
                    ]
                ]
            ],
            [
                "type" => 'separator',
                "margin" => self::LG
            ],
            [
                "type" => "button",
                "style" => "link",
                "height" => self::SM,
                "action" => [
                    "type" => "postback",
                    "label" => "積分查詢",
                    "data" => sprintf('uid=%s&type=checkPoint', $params['uid']),
                    "displayText" => "積分查詢",
                    "inputOption" => "closeRichMenu"
                ]
            ],
            [
                "type" => "button",
                "style" => "link",
                "height" => self::SM,
                "action" => [
                    "type" => "postback",
                    "label" => "學習歷程",
                    "data" => sprintf('uid=%s&type=history', $params['uid']),
                    "displayText" => "學習歷程",
                    "inputOption" => "closeRichMenu"
                ]
            ],
            [
                "type" => 'separator',
                "margin" => self::LG
            ],
            [
                "type" => "button",
                "style" => "link",
                "height" => self::SM,
                "action" => [
                    "type" => "postback",
                    "label" => "簽到",
                    "data" => sprintf('uid=%s&type=getClasses', $params['uid']),
                    "displayText" => "簽到",
                    "inputOption" => "closeRichMenu"
                ]
            ],
            /*
             * 先不提供資料編輯
            [
                "type" => "button",
                "style" => "link",
                "height" => self::SM,
                "action" => [
                    "type" => "message",
                    "label" => "編輯資料",
                    "text" => "*編輯資料[功能建置中]*"
                ]
            ],
            */
        ];
        $point_feature = Site_config::where('key', config('site_config.POINT_FEATURE'))->value('value');
        // 若積分功能關閉則此處不回覆聊天室"查詢積分"按鈕
        if ($point_feature == '0')
        {
            unset($body_contents[2]);
            $body_contents = array_values($body_contents);
        }

        // 若簽到功能關閉則此處不回覆聊天室"簽到"按鈕
        $sign_in_feature = Site_config::where('key', config('site_config.SIGN_IN_FEATURE'))->value('value');
        if ($sign_in_feature == '0')
        {
            unset($body_contents[4]);
            $body_contents = array_values($body_contents);
        }
        
        $data = [
            'type' => 'flex',
            'altText' => '會員功能',
            'contents' => [
                'type' => 'bubble',
                'size' => 'kilo',
                'hero' => [
                    'type' => 'box',
                    'layout' => 'vertical',
                    'contents' => [
                        [
                            'type' => 'image',
                            "url" => asset('storage/images/member/member.jpg'),
                            "size" => "full",
                            "aspectRatio" => "20:13",
                            "aspectMode" => "cover",
                        ],
                    ],
                ],
                "body" => [
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => $body_contents
                ],
            ],
        ];

        $messageBuilder =  new \LINE\LINEBot\MessageBuilder\RawMessageBuilder($data);

        return ['message', $messageBuilder];
    }

    // 會員專區 [未註冊]
    public function unregisteredMemberMessage($params)
    {
        $messageBuilder =  new \LINE\LINEBot\MessageBuilder\RawMessageBuilder([
                'type' => 'flex',
                'altText' => "未綁定會員",
                'contents' => [
                    'type' => 'bubble',
                    'size' => 'kilo',
                    'hero' => [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'contents' => [
                            [
                                'type' => 'image',
                                "url" => asset('storage/images/member/unregister.jpg'),
                                "size" => "full",
                                "aspectRatio" => "20:13",
                                "aspectMode" => "cover",
                                "action" => [
                                    "type" => "uri",
                                    "uri" => "https://google.com/"
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
                                "margin" => self::LG,
                                "spacing" => self::SM,
                                "contents" => [
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => self::SM,
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => $params['message'],
                                                "wrap" => true,
                                                "color" => "#666666",
                                                "size" => self::SM,
                                                "flex" => 5,
                                            ],
                                        ]
                                    ],
                                    [
                                        "type" => 'separator',
                                        "margin" => self::LG
                                    ],
                                ]
                            ],
                        ]
                    ],
                    "footer" => [
                        "type"=> "box",
                        "layout"=> "vertical",
                        "spacing"=> self::SM,
                        "contents"=> [
                            [
                                "type" => "button",
                                "style" => "primary",
                                "height" => self::SM,
                                "gravity" => "top",
                                "action" => [
                                    "type" => "uri",
                                    "label" => "綁定會員",
                                    "uri" => route('register', ['uid' => $params['uid'], 'token' => $params['token']]),
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

    // 聯絡我們
    public function contactMessage($params)
    {
        $messageBuilder =  new \LINE\LINEBot\MessageBuilder\RawMessageBuilder(
            [
                'type' => 'flex',
                'altText' => sprintf('聯絡 %s ', $params['contact_us']['header']),
                'contents' => [
                    "type" => "bubble",
                    'size' => 'kilo',
                    "hero" => [
                        "type" => "image",
                        "url" => asset('storage/images/location.jpg'),
                        "size" => "full",
                        "aspectRatio" => "20:13",
                        "aspectMode" => "cover",
                        "action" => [
                            "type" => "uri",
                            "uri" => $params['contact_us']['map_uri'],
                        ]
                    ],
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => $params['contact_us']['header'],
                                "weight" => "bold",
                                "size" => self::XL
                            ],
                            [
                                "type" => 'separator',
                                "margin" => self::LG
                            ],
                            [
                                "type" => "box",
                                "layout" => "vertical",
                                "margin" => self::LG,
                                "spacing" => self::SM,
                                "contents" => [
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => self::SM,
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "Place",
                                                "color" => "#aaaaaa",
                                                "size" => self::SM,
                                                "flex" => 1
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => $params['contact_us']['place'],
                                                "wrap" => true,
                                                "color" => "#666666",
                                                "size" => self::SM,
                                                "flex" => 5
                                            ]
                                        ]
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => self::SM,
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "Tel",
                                                "color" => "#aaaaaa",
                                                "size" => self::SM,
                                                "flex" => 1
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => $params['contact_us']['tel'],
                                                "wrap" => true,
                                                "color" => "#666666",
                                                "size" => self::SM,
                                                "flex" => 5
                                            ]
                                        ]
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => self::SM,
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "Time",
                                                "color" => "#aaaaaa",
                                                "size" => self::SM,
                                                "flex" => 1
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => $params['contact_us']['time1'],
                                                "wrap" => true,
                                                "color" => "#666666",
                                                "size" => self::SM,
                                                "flex" => 5
                                            ]
                                        ]
                                    ],
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => self::SM,
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => " ",
                                                "color" => "#aaaaaa",
                                                "size" => self::SM,
                                                "flex" => 1
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => $params['contact_us']['time2'],
                                                "wrap" => true,
                                                "color" => "#666666",
                                                "size" => self::SM,
                                                "flex" => 5
                                            ]
                                        ]
                                    ],
                                ]
                            ],
                            [
                                "type" => 'separator',
                                "margin" => self::LG
                            ],
                            [
                                "type" => "button",
                                "style" => "primary",
                                "height" => self::SM,
                                "gravity" => "top",
                                "action" => [
                                    "type" => "uri",
                                    "label" => "地圖",
                                    "uri" => $params['contact_us']['map_uri'],
                                ]
                            ]
                        ]
                    ],
                ],
            ]
        );

        return ['message', $messageBuilder];
    }

    // 取得班級清單 (簽到)
    public function getClasses($params)
    {
        // 有待簽到班級時回覆
        if ($params['classes'])
        {
            $bgcolor = "#0D4C92";
            $classes_content = [
                [
                    "type" => "bubble",
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "簽到",
                                "color" => "#ffffff",
                                "size" => "sm"
                            ],
                            [
                                "type" => "text",
                                "text" => $params['user']['name'],
                                "weight" => "bold",
                                "size" => self::XL,
                                "color" => self::NAME_COLOR,
                                "margin" => "md"
                            ],
                            [
                                "type" => "separator",
                                "margin" => "xxl"
                            ],
                            [
                                "type" => "box",
                                "layout" => "vertical",
                                "margin" => "xxl",
                                "spacing" => "sm",
                                "contents" => [
                                    [
                                        "type" => "box",
                                        "layout" => "horizontal",
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "請選擇您要簽到的班級 >>",
                                                "size" => "md",
                                                "color" => "#ffffff",
                                            ]
                                        ]
                                    ]
                                ],
                                "backgroundColor" => $bgcolor
                            ]
                        ],
                        "backgroundColor" => $bgcolor
                    ],
                    "size" => "kilo"
                ]
            ];

            foreach ($params['classes'] as $class)
            {
                $classes_content[] = [
                    "type" => "bubble",
                    "size" => "kilo",
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => $class['title'],
                                "weight" => "bold",
                                "size" => self::MD,
                                "color" => "#ffffff"
                            ],
                            [
                                "type" => "box",
                                "layout" => "vertical",
                                "margin" => self::LG,
                                "spacing" => self::SM,
                                "contents" => [
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => self::SM,
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "課程 :",
                                                "color" => "#000000",
                                                "size" => self::SM,
                                                "flex" => 2
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => $class['lesson']['title'],
                                                "wrap" => true,
                                                "color" => "#ffffff",
                                                "size" => self::MD,
                                                "flex" => 5,
                                                "weight" => "bold"
                                            ]
                                        ]
                                    ],
                                ]
                            ],
                            [
                                "type" => "box",
                                "layout" => "vertical",
                                "margin" => self::LG,
                                "spacing" => self::SM,
                                "contents" => [
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => self::SM,
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "說明 :",
                                                "color" => "#000000",
                                                "size" => self::SM,
                                                "flex" => 2
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => $class['description'],
                                                "wrap" => true,
                                                "color" => "#ffffff",
                                                "size" => self::MD,
                                                "flex" => 5,
                                                "weight" => "bold"
                                            ]
                                        ]
                                    ],
                                ]
                            ]
                        ],
                        "backgroundColor" => "#27ACB2"
                    ],
                    "footer" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "spacing" => self::SM,
                        "contents" => [
                            [
                                "type" => "button",
                                "height" => self::SM,
                                "action" => [
                                    "type" => "postback",
                                    "label" => "簽到",
                                    "data" => sprintf("lesson_id=%s&class_id=%s&type=sign_in",$class['lesson']['id'], $class['id']),
                                    "displayText" => sprintf("簽到:%s", $class['title'])
                                ],
                                "style" => "primary"
                            ],
                            [
                                "type" => "box",
                                "layout" => "vertical",
                                "contents" => [],
                                "margin" => self::SM
                            ]
                        ],
                        "flex" => 0,
                        "borderWidth" => "bold"
                    ]
                ];
            }

            $messageBuilder = new \LINE\LINEBot\MessageBuilder\RawMessageBuilder(
                [
                    'type' => 'flex',
                    'altText' => "簽到",
                    'contents' => [
                        "type" => "carousel",
                        "contents" => $classes_content
                    ],
                ]
            );
        }
        else
        {
            // 沒有待簽到班級時回覆一般訊息
            $messageBuilder =  new \LINE\LINEBot\MessageBuilder\RawMessageBuilder(
                [
                    'type' => 'flex',
                    'altText' => "目前沒有可簽到的班級",
                    'contents' => [
                        "type" => "bubble",
                        "body" => [
                            "type" => "box",
                            "layout" => "vertical",
                            "contents" => [
                                [
                                    "type" => "text",
                                    "text" => "簽到",
                                    "size" => "sm"
                                ],
                                [
                                    "type" => "text",
                                    "text" => $params['user']['name'],
                                    "weight" => "bold",
                                    "size" => self::XL,
                                    "margin" => "md",
                                    "color" => self::NAME_COLOR
                                ],
                                [
                                    "type" => "separator",
                                    "margin" => "xxl"
                                ],
                                [
                                    "type" => "box",
                                    "layout" => "vertical",
                                    "margin" => "xxl",
                                    "spacing" => "sm",
                                    "contents" => [
                                        [
                                            "type" => "box",
                                            "layout" => "horizontal",
                                            "contents" => [
                                                [
                                                    "type" => "text",
                                                    "text" => "目前沒有可簽到的班級",
                                                    "size" => "md",
                                                    "weight" => "bold"
                                                ]
                                            ]
                                        ]
                                    ],
                                ]
                            ],
                        ],
                        "size" => "kilo"
                    ],
                ]
            );
        }

        return ['message', $messageBuilder];
    }

    // 簽到 (簽到)
    public function signInClasses($params)
    {
        // 沒有待簽到班級時回覆一般訊息
        $messageBuilder =  new \LINE\LINEBot\MessageBuilder\RawMessageBuilder(
            [
                'type' => 'flex',
                'altText' => "目前沒有可簽到的班級",
                'contents' => [
                    "type" => "bubble",
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => $params['message'],
                                "weight" => "bold",
                                "size" => self::MD
                            ]
                        ]
                    ]
                ],
            ]
        );

        return ['message', $messageBuilder];
    }

    // 積分查詢
    public function checkPoint($params)
    {
        $messageBuilder =  new \LINE\LINEBot\MessageBuilder\RawMessageBuilder(
            [
                "type" => 'flex',
                "altText" => "積分查詢",
                "contents" => [
                    "type" => "bubble",
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => "積分查詢",
                                "size" => "sm"
                            ],
                            [
                                "type" => "text",
                                "text" => $params['name'],
                                "size" => self::XL,
                                "margin" => "md",
                                "weight" => "bold",
                                "color" => self::NAME_COLOR
                            ],
                            [
                                "type" => "separator",
                                "margin" => "xxl"
                            ],
                            [
                                "type" => "box",
                                "layout" => "vertical",
                                "margin" => "xxl",
                                "spacing" => "sm",
                                "contents" => [
                                    [
                                        "type" => "box",
                                        "layout" => "horizontal",
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "累計積分",
                                                "size" => "md",
                                                "flex" => 0,
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => $params['point'],
                                                "size" => "md",
                                                "align" => "end",
                                                "weight" => "bold"
                                            ]
                                        ]
                                    ]
                                ],
                            ]
                        ],
                    ],
                    "styles" => [
                        "footer" => [
                            "separator" => true
                        ]
                    ],
                    "size" => "kilo"
                ]
            ]
        );

        return ['message', $messageBuilder];
    }

    // 學習歷史
    public function history($params)
    {
        $bgcolor = "#0D4C92";
        $content = [
            [
                "type" => "bubble",
                "body" => [
                    "type" => "box",
                    "layout" => "vertical",
                    "contents" => [
                        [
                            "type" => "text",
                            "text" => "學習歷程",
                            "color" => "#ffffff",
                            "size" => "sm"
                        ],
                        [
                            "type" => "text",
                            "text" => $params['name'],
                            "weight" => "bold",
                            "size" => self::XL,
                            "color" => "#ffffff",
                            "margin" => "md"
                        ],
                        [
                            "type" => "separator",
                            "margin" => "xxl"
                        ],
                        [
                            "type" => "box",
                            "layout" => "vertical",
                            "margin" => "xxl",
                            "spacing" => "sm",
                            "contents" => [
                                [
                                    "type" => "box",
                                    "layout" => "horizontal",
                                    "contents" => [
                                        [
                                            "type" => "text",
                                            "text" => ($params['sign_in_list']) ? "學習歷程 >>" : "沒有學習記錄",
                                            "size" => "md",
                                            "color" => "#ffffff",
                                        ]
                                    ]
                                ]
                            ],
                            "backgroundColor" => $bgcolor
                        ]
                    ],
                    "backgroundColor" => $bgcolor,
                    "height" => "180px"
                ],
                "size" => "kilo"
            ]
        ];

        if ($params['sign_in_list'])
        {
            foreach ($params['sign_in_list'] as $list)
            {
                $content[] = [
                    "type" => "bubble",
                    "size" => "kilo",
                    "body" => [
                        "type" => "box",
                        "layout" => "vertical",
                        "contents" => [
                            [
                                "type" => "text",
                                "text" => sprintf("第 %s 期", $list->course_id),
                                "weight" => "bold",
                                "size" => self::MD,
                                "color" => "#ffffff",
                                "wrap" => true
                            ],
                            [
                                "type" => "text",
                                "text" => $list->name,
                                "weight" => "bold",
                                "size" => self::MD,
                                "color" => "#ffffff",
                                "wrap" => true
                            ],
                            [
                                "type" => 'separator',
                                "margin" => self::LG
                            ],
                            [
                                "type" => "box",
                                "layout" => "vertical",
                                "margin" => self::LG,
                                "spacing" => self::SM,
                                "contents" => [
                                    [
                                        "type" => "box",
                                        "layout" => "baseline",
                                        "spacing" => self::SM,
                                        "contents" => [
                                            [
                                                "type" => "text",
                                                "text" => "完成節數 : ",
                                                "color" => "#000000",
                                                "size" => self::SM,
                                                "flex" => 2
                                            ],
                                            [
                                                "type" => "text",
                                                "text" => $list->num . "",
                                                "wrap" => true,
                                                "color" => "#000000",
                                                "size" => self::MD,
                                                "flex" => 5,
                                                "weight" => "bold"
                                            ]
                                        ],

                                    ],
                                ]
                            ],
                        ],
                        "backgroundColor" => "#27ACB2"
                    ],
                ];
            }
        }

        $messageBuilder = new \LINE\LINEBot\MessageBuilder\RawMessageBuilder(
            [
                'type' => 'flex',
                'altText' => "學習歷程",
                'contents' => [
                    "type" => "carousel",
                    "contents" => $content
                ],
            ]
        );

        return ['message', $messageBuilder];
    }
}
