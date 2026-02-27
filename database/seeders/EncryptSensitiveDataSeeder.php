<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Seeder;
use App\Models\Person;

class EncryptSensitiveDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $people = Person::all();

        foreach ($people as $person) {
            $updated = false;

            if (!empty($person->person) && !self::isEncrypted($person->person)) {
                $person->person = Crypt::encryptString($person->person);
                $updated = true;
            }

            if (!empty($person->per_num) && !self::isEncrypted($person->per_num)) {
                $person->per_num = Crypt::encryptString($person->per_num);
                $updated = true;
            }

            if (!empty($person->per_id) && !self::isEncrypted($person->per_id)) {
                $person->per_id = Crypt::encryptString($person->per_id);
                $updated = true;
            }

            if (!empty($person->per_phone) && !self::isEncrypted($person->per_phone)) {
                $person->per_phone = Crypt::encryptString($person->per_phone);
                $updated = true;
            }

            if (!empty($person->per_email) && !self::isEncrypted($person->per_email)) {
                $person->per_email = Crypt::encryptString($person->per_email);
                $updated = true;
            }

            if ($updated) {
                $person->save();
            }
        }
    }


    private static function isEncrypted($value): bool
    {
        try {
            Crypt::decryptString($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
