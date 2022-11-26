<?php

namespace App\Http\Controllers;

use App\Handlers\Log;
use App\Handlers\ReplyMessage;
use App\Models\ContactUs;
use App\Models\LessonCard;
use App\Models\Point_task;
use App\Models\SignIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Site_config;
use App\Models\About_us;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\Classes;
use DB;

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

    public function server_info(Request $request)
    {
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
                    $postback_data = $event['postback']['data'];

                    // 取回 MessageBuilder
                    list($type, $replyContent) = $this->postback_handler($event);

                    $response = $this->bot->replyMessage($event['replyToken'], $replyContent);
                    $this->log->log('log', sprintf("%s %s", $response->getHTTPStatus(), $response->getRawBody()));

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
                $title = Site_config::where('key', config('site_config.TITLE'))->first()->value('value');
                $content = About_us::find(1)->value('content');

                $params = [
                    'title' => $title,
                    'message' => $content
                ];
                return $replyMessage->aboutMessage($params);

            case self::LESSONS:

                $params = [
                    'lessons' => LessonCard::where('display', 1)->get()->toArray(),
                ];

                // 課程介紹回覆
                return $replyMessage->lessonsMessage($params);

            case self::MEMBER:
                $uid = $event['source']['userId'];
                $user = User::where('userId', $uid)->first();
                $message = null;

                // 產生 token
                $token = Crypt::encryptString($uid.env('APP_KEY'));

                if ($user)
                {
                    // 有登錄過
                    // 會員專區回覆
                    $params = [
                        'title' => "歡迎使用會員功能",
                        'uid' => $uid,
                        'token' => $token,
                        'message' => $message
                    ];
                    return $replyMessage->memberMessage($params);
                }
                else
                {
                    // 沒有登錄
                    // 取得引導用戶註冊的文字訊息 from DB
                    $config = Site_config::where('key', config('site_config.FLEX_MEMBER_WELCOME_JOIN_MEMBER_MSG'))->first();
                    $message = $config->value;

                    // 產生 token
                    $params = [
                        'uid' => $uid,
                        'token' => $token,
                        'message' => $message
                    ];

                    $this->log->log('log', sprintf('In : %s', json_encode($params, JSON_UNESCAPED_UNICODE)));

                    // 會員專區回覆
                    return $replyMessage->unregisteredMemberMessage($params);
                }

            case self::CONTACT:
                $contact_us_info = ContactUs::all()->toArray();
                foreach ($contact_us_info as $value)
                {
                    $contact_us[$value['title']] = $value['content'];
                }

                $params = [
                    'contact_us' => $contact_us,
                ];

                //聯絡我們回覆
                return $replyMessage->contactMessage($params);

            default:
                return new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('無法處理的訊息。');

        }
    }

    public function postback_handler($event)
    {
        // user input text
        $postback_data = $event['postback']['data'];
        $userId  = $event['source']['userId'];
        parse_str($postback_data, $data_arr);
        $this->log->log('log', sprintf('Get Postback data From User : %s', $postback_data));

        $replyMessage = New ReplyMessage($event);
        switch ($data_arr['type'])
        {
            // 查詢積分
            case 'checkPoint' :
                $user = User::where('userID', $userId)->get()->first();
                $params = [
                    'name' => $user->name,
                    'point' => $user->point->point,
                ];

                return $replyMessage->checkPoint($params);

                break;

            // 取得班級清單
            case 'getClasses':
                $user = User::where('userID', $userId)->first()->toArray();;
                $classes = Classes::active()->get();

                $params = [
                    'user' => $user,
                    'classes' => Classes::active()->with('lesson')->get()->toArray(),
                ];

                // 取得可簽到的班級清單
                return $replyMessage->getClasses($params);
                break;

            // 簽到
            case 'sign_in':
                // 檢查是否簽到過
                if (SignIn::where([['userId', '=', $userId], ['class_id', '=', $data_arr['class_id']]])->first()) {
                    // 簽到過 不用再簽了
                    $message = "您已經完成簽到。";
                } else {
                    // 新增簽到紀錄
                    $user = User::where('userID', $userId)->first()->toArray();;
                    $sign = new SignIn();
                    $sign->lesson_id = $data_arr['lesson_id'];
                    $sign->class_id = $data_arr['class_id'];
                    $sign->user_id = $user['id'];
                    $sign->userId = $userId;
                    $sign->save();

                    // 簽到積分
                    $task = new Point_task();
                    $doTask = $task->makeTask('sign_in', $userId);

                    $_class = Classes::where('id', $data_arr['class_id'])->first();
                    $message = sprintf('簽到 [%s] 完成。', $_class['title']);
                }

                $params = [
                    'data'    => $data_arr,
                    'message' => $message
                ];
                return $replyMessage->signInClasses($params);
                break;

            // 學習歷程
            case 'history' :
                $user = User::where('userID', $userId)->get()->first();

                $sign_in_list = DB::table('sign_in')
                    ->leftJoin('lessons', 'sign_in.lesson_id', '=', 'lessons.id')
                    ->leftJoin('courses', 'lessons.course_id', '=', 'courses.id')
                    ->select('lessons.course_id', 'courses.name', DB::raw('count(*) as `num`'))
                    ->where('sign_in.user_id', $user['id'])
                    ->groupBy('lessons.course_id')
                    ->get()->toArray();

                $params = [
                    'name' => $user->name,
                    'sign_in_list' => $sign_in_list
                ];

                $this->log->log('msg', json_encode($sign_in_list, 256));

                return $replyMessage->history($params);

                break;

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
