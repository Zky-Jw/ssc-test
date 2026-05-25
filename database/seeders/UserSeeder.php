<?php

namespace Database\Seeders;

use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use App\Models\Person;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();
        $users = [
            [
                'person_id' => 'bd646c5d-5521-11ee-856c-04d4c477450f',
                'username' => 'admin',
                'email_verified_at' => NULL,
                'password' => Hash::make("@admin")
            ],
            [
                'person_id' => 'bd646db4-5521-11ee-856c-04d4c477450f',
                'username' => 'student',
                'email_verified_at' => NULL,
                'password' => Hash::make("@student")
            ],
            [
                'person_id' => 'bd646e12-5521-11ee-856c-04d4c477450f',
                'username' => 'adminakd',
                'email_verified_at' => NULL,
                'password' => Hash::make("@adminAKD")
            ],
            [
                'person_id' => 'bd646e70-5521-11ee-856c-04d4c477450f',
                'username' => 'adminkmhs',
                'email_verified_at' => NULL,
                'password' => Hash::make("@adminKMHS")
            ],
            [
                'person_id' => 'bd646ece-5521-11ee-856c-04d4c477450f',
                'username' => 'adminputi',
                'email_verified_at' => NULL,
                'password' => Hash::make("@adminPUTI")
            ],
            [
                'person_id' => 'bd646f2c-5521-11ee-856c-04d4c477450f',
                'username' => 'adminlog',
                'email_verified_at' => NULL,
                'password' => Hash::make("@adminLOG")
            ],
            [
                'person_id' => 'bd646f8a-5521-11ee-856c-04d4c477450f',
                'username' => 'adminkug',
                'email_verified_at' => NULL,
                'password' => Hash::make("@adminKUG")
            ]
        ];
       foreach ($users as $user) {
        User::create($user);
    }

        $path_mahasiswa = storage_path('app/seeds/250425_seeder_user_mahasiswa.xlsx');
        $path_pegawai = storage_path('app/seeds/210425_seeder_user_pegawai.xlsx');
        $data_mahasiswa = Excel::toCollection(null, $path_mahasiswa)[0];
        $data_pegawai = Excel::toCollection(null, $path_pegawai)[0];

        // Ambil semua Person yang sudah ada

        // Lewati baris header
        foreach ($data_mahasiswa->skip(1) as $row) {

            if (empty($row[4])) continue;

            $person = Person::where('per_email', $row[4])->first();

            User::create([
                'person_id' => $person->id,
                'username' => !empty($row[4]) ? Str::before($row[4], '@') : '',
                'email_verified_at' => NULL,
                'password' => Hash::make($row[2]),
            ]);
        }

        // Lewati baris header
        foreach ($data_pegawai->skip(1) as $row) {

            if (empty($row[5])) continue;

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