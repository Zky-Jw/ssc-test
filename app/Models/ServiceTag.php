<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function services()
    {
        return $this->belongsToMany(
            Service::class,
            'service_tag_mappings',
            'service_tag_id',
            'service_id'
        );
    }
}
