<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class SignIn extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;

    protected $table = "sign_in";

    protected $fillable = [
        'userId',
        'lesson_id',
        'classes_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }
}
