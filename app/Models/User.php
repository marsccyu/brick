<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use DefaultDatetimeFormat;

    protected $fillable = [
        'userId',
        'password',
        'name',
        'email',
        'type',
        'telephone',
        'age',
    ];

    protected $hidden = [];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function point_task()
    {
        return Point_task::get();
    }

    public function point_history()
    {
        return $this->hasMany(Point_history::class);
    }

    public function point()
    {
        return $this->hasOne(Point::class);
    }

    public function signIn()
    {
        return $this->hasMany(SignIn::class);
    }

    public function getAgeAttribute($value): string
    {
        $start = strtotime($this->created_at);
        $end = time();
        $days = round(($end-$start)/3600/24);
        $years_diff = round($days/365) + $value;
        return round($years_diff);
    }
}
