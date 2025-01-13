<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tide extends Model
{
    /** @use HasFactory<\Database\Factories\TideFactory> */
    use HasFactory;

    protected $fillable = [
        'ID',
        'year',
        'month',
        'day',
        'time',
        'meter',
        'feet',
    ];
}
