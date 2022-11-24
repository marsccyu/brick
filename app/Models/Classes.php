<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class Classes extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;

    protected $fillable = [
        'lesson_id',
        'title',
        'start',
        'end',
    ];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function signIn()
    {
        return $this->hasMany(SignIn::class);
    }

    public function scopeActive($query)
    {
        return $query->where('start', '<', date('Y-m-d H:i:s'))->where('end', '>', date('Y-m-d H:i:s'))->limit(10);
    }
}
