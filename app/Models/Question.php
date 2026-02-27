<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;

class Question extends Model

{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $table = 'question';

    protected $fillable = [
        'id',
        'questionNumber',
        'title',
        'date',
        'category',
        'question',
        'answer'
    ];

    protected $casts = [
        'id' => 'string',
        'date' => 'datetime',
    ];
}
