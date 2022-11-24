<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class Site_config extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;

    protected $fillable = [
        'key',
        'value',
        'description',
    ];
}
