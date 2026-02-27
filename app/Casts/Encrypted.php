<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Crypt;

class Encrypted implements CastsAttributes
{
    /**
     * Decrypt the value when retrieving from the database.
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    /**
     * Encrypt the value before saving to the database.
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value ? Crypt::encryptString($value) : null;
    }
}
