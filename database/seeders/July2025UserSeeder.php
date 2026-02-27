<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Person;

class July2025UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path_pegawai = storage_path('app/seeds/010725_seeder_add_user_pegawai.xlsx');
        $data_pegawai = Excel::toCollection(null, $path_pegawai)[0];

                // Lewati baris header
                foreach ($data_pegawai->skip(1) as $row) {

                    $person = Person::where('per_email', $row[4])->first();

                    User::create([
                        'person_id' => $person->id,
                        'username' => $row[3],
                        'email_verified_at' => NULL,
                        'password' => Hash::make($row[1]),
                    ]);
                }
    }
}
