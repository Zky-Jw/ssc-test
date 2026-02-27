<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
use App\Models\Unit;
use App\Models\Person;

class ServiceMapping extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'service_id',
        'unit_id',
        'service_category_id',
        'service_additional_id',
        'person_id',
        'active',
        'createdby',
        'updatedby'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function serviceAdditional()
    {
        return $this->belongsTo(ServiceAdditional::class, 'service_additional_id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
