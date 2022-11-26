<?php

namespace App\Http\Controllers\Auth;

use App\Models\Point;
use App\Models\Point_task;
use App\Models\Site_config;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm(Request $request)
    {
        $title = Site_config::where('key', config('site_config.TITLE'))->first()->value('value');

        // 測試時才打開
//         return view('auth.register', [
//             'uid' => 1,
//             'registered' => FALSE
//         ]);

        // 取得 uid 是否已登錄
        if ($user = User::where('userId', $request->input('uid'))->first())
        {
            return view('auth.register', ['uid' => $request->input('uid'), 'title' => $title, 'registered' => TRUE]);
        }

        // 取不到值時
        if ((!$uid = $request->input('uid')) || (!$token = $request->input('token')))
        {
            abort(403);
        }

        // 解密驗證字串失敗
        try {
            $deToken = Crypt::decryptString($token);
        } catch (DecryptException $e) {
            abort(403);
        }

        // token 與驗證字串不相符時
        if (!hash_equals($uid.env('APP_KEY'), $deToken))
        {
            abort(403);
        }

        return view('auth.register', ['uid' => $request->input('uid'), 'title' => $title, 'registered' => FALSE]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $point = new Point();
        $point->user_id = $user->id;
        $point->save();

        // 綁定積分
        $task = new Point_task();
        $doTask = $task->makeTask('bind_account', $request->userId);

        echo "<script>alert('綁定完成, 歡迎使用會員功能。');</script>";

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect('https://line.me/R/oaMessage/@053clhcl/?會員專區');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'userId'    => ['required', 'string', 'max:128', 'unique:users'],
            'name'      => ['required', 'string', 'max:16'],
            'email'     => ['required', 'string', 'email', 'max:128', 'unique:users'],
            'telephone' => ['required', 'string', 'max:12'],
            'age'       => ['required', 'string', 'max:2'],
            'type'      => ['required', 'string',],
        ],
        [
            'userId.unique' => '這個 Line 帳號已經完成綁定',
            'name.required' => '請填寫姓名',
            'name.max' => '長度最多為 16 個字元',
            'email.required' => '請填寫 Email 帳號',
            'email.max' => '長度最多為 128 個字元',
            'email.unique' => '此組 Email 已被註冊',
            'telephone.required' => '請填寫聯絡電話',
            'telephone.max' => '電話長度錯誤',
            'age.required' => '請填寫年齡',
            'age.max' => '年齡格式錯誤, 請重新填寫',
            'type.required' => '請選擇您的身分',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'userId' => $data['userId'],
            'name' => $data['name'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'age' => $data['age'],
            'type' => $data['type'],
            'password' => Hash::make($data['userId']),
        ]);
    }
}
