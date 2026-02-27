<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageRoleMapping extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'page_id',
        'role_id',
        'access',
        'active',
        'created_at',
        'updated_at',
    ];
    
    protected $casts = [
        'id' => 'string'
    ];
}
