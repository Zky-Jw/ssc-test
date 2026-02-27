<?php

namespace App\Models;

use App\Models\Role;
use App\Models\PersonRoleMapping;
use App\Models\UnitPeople;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelCipherSweet\Contracts\CipherSweetEncrypted;
use Spatie\LaravelCipherSweet\Concerns\UsesCipherSweet;
use ParagonIE\CipherSweet\Transformation\Lowercase;
use ParagonIE\CipherSweet\EncryptedRow;
use ParagonIE\CipherSweet\BlindIndex;

class Person extends Model implements CipherSweetEncrypted
{
    use HasFactory;
    use UsesCipherSweet;

    protected $primaryKey = 'id';
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'person',
        'per_num',
        'per_id',
        'per_phone',
        'per_email',
        'per_group',
        'per_major',
        'per_years',
        'per_faculty',
        'active',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'string'
    ];

    public static function configureCipherSweet(EncryptedRow $encryptedRow): void
    {
        $encryptedRow
            ->addTextField('person')
            ->addBlindIndex(
                'person',
                new BlindIndex(
                    'person_index',
                    [new Lowercase()]
                ),
            );

        $encryptedRow
            ->addTextField('per_phone')
            ->addBlindIndex(
                'per_phone',
                new BlindIndex('per_phone_index'),
            );
    }

    public function user()
    {
        return $this->hasOne(User::class, 'person_id');
    }

    public function roles()
    {
        // return $this->belongsTo(Role::class, 'person_role_mappings', 'person_id', 'role_id');

        return $this->hasOneThrough(
            Role::class,
            PersonRoleMapping::class,
            'person_id',
            'id',
            'id',
            'role_id'
        );
    }

    public function roleMapping()
    {
        return $this->hasOne(PersonRoleMapping::class, 'person_id');
    }

    public function serviceMappings()
    {
        return $this->hasMany(ServiceMapping::class, 'person_id');
    }


    public function unitPeople()
    {
        return $this->hasOne(UnitPeople::class, 'person_id');
    }
}
