<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ServiceTagMapping extends Pivot
{
    use HasFactory;

    protected $table = 'service_tag_mappings';
    public $timestamps = false;

    protected $fillable = [
        'service_id',
        'tag_id',
    ];
}
