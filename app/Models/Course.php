<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class Course extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;

    protected $fillable = [
        'name',
    ];

    public function lesson()
    {
        return $this->hasMany(Lesson::class);
    }

    public function classes()
    {
        return $this->hasMany(Classes::class);
    }
}
