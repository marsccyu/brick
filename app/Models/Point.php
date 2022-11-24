<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'point'
    ];

    public function point_history()
    {
        return $this->hasMany(Point_history::class);
    }
}
