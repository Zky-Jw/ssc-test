<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'url',
        'active',
        'created_at',
        'updated_at',
        'createdby',
        'updatedby',
    ];    

    protected $casts = [
        'id' => 'string'
    ];
}
