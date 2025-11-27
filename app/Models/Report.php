<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'period_start',
        'period_end',
        'payload',
        'path',
    ];

    protected $casts = [
        'payload' => 'array',
        'period_start' => 'date',
        'period_end' => 'date',
    ];
}
