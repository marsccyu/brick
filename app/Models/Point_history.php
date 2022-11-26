<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class Point_history extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;

    protected $table = 'point_histories';

    protected $fillable = [
        'user_id',
        'point_task_id',
        'before',
        'change',
        'after',
        'description',
        'comment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function point_tasks()
    {
        return $this->belongsTo(Point_task::class);
    }
}
