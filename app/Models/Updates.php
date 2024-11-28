<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Updates extends Model
{
    /** @use HasFactory<\Database\Factories\UpdatesFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'date',
        'time',
    ];
}
