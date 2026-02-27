<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unit',
        'icons',
        'icon',
        'colors',
        'unit_parent',
        'active',
        'createdby',
        'updatedby'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function supervisor()
    {
        return $this->hasOneThrough(
            Person::class,
            UnitPeople::class,
            'unit_id',     // FK di unit_people
            'id',          // PK di people
            'id',          // PK di units
            'person_id'    // FK di unit_people
        )
            ->where(function ($q) {
                $q->where('unit_people.position', 'like', 'KEPALA BAGIAN%')
                    ->orWhere('unit_people.position', 'like', 'KEPALA URUSAN%');
            });
    }
}
