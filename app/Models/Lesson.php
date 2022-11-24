<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class Lesson extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;

    protected $fillable = [
        'coruse',
        'lesson_num',
        'title',
        'subtitle',
        'content',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function classes()
    {
        return $this->hasMany(Classes::class);
    }
}
