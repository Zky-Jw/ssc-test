<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAdditional extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'description', 'requirement', 'duration', 'active', 'createdby', 'updatedby'
    ];

    protected $casts = [
        'id' => 'string'
    ];
}
