<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use App\Models\User;
use App\Models\Site_config;

class Point_task extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;

    protected $fillable = [
        'name', 'description', 'point'
    ];

    public function point_history()
    {
        return $this->hasMany(Point_history::class);
    }

    // 計算積分異動
    public function calculate($user, $change)
    {
        // 用戶積分模型
        $user_point = $user->point;
        // 用戶目前積分
        $now_point = $user_point->point;
        // 異動後積分
        $after_point = $now_point + $change;
        // 更新用戶積分
        $user->point()->update(['point' => $after_point]);

        return [
            'before' => $now_point,
            'after' => $after_point
        ];
    }

    // 執行積分任務
    public function makeTask($task, $userId, $comment = null)
    {
        $point_exchange = [];

        $is_point_disable = Site_config::where('key', config('site_config.POINT_FEATURE'))->value('value');

        // 若積分功能關閉則不進行任務
        if ($is_point_disable == '0')
        {
            return [];
        }

        // 任務資料
        if ($doTask = $this->where(['name' => $task, 'is_disabled' => 1])->first()) {

            // 用戶
            $user = User::where('userId', $userId)->first();

            // 計算異動
            $point_exchange = $this->calculate($user, $doTask->point);

            // 寫入清單
            $history = new Point_history([
                'point_task_id' => $doTask->id,
                'user_id' => $user->id,
                'before' => $point_exchange['before'],
                'change' => $doTask->point,
                'after' => $point_exchange['after'],
                'description' => 'Execute ' . $doTask->name,
                'comment' => $comment
            ]);

            $doTask->point_history()->save($history);
        }

        return $point_exchange;
    }
}
