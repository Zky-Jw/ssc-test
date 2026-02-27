<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;

class Service extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service',
        'active',
        'inactive_reason',
        'createdby',
        'updatedby'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            ServiceTag::class,
            'service_tag_mappings',
            'service_id',
            'service_tag_id'
        );
    }
}
