<?php

namespace App\Models;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'active',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public function people()
    {
        return $this->belongsTo(Person::class, 'person_role_mappings', 'role_id', 'person_id');
    }
}
