<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformanceStat extends Model
{
    protected $fillable = [
        'user_id',
        'stat_type',
        'value',
        'recorded_at',
    ];

}
