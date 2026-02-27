<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use App\Models\Person;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\PersonRoleMapping;

class Sept2025MahasiswaBaruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $path_mahasiswa = storage_path('app/seeds/150925_seeder_user_mahasiswa.xlsx');
        $data_mahasiswa = Excel::toCollection(null, $path_mahasiswa)[0];
        foreach ($data_mahasiswa->skip(1) as $row) {
            if (empty($row[4])) continue;

            Person::create([
                'id' => $id = Str::uuid(), // simpan id
                'person' => $row[0],
                'per_num' => $row[1],
                'per_id' => $row[2],
                'per_phone' => $row[3],
                'per_email' => $row[4],
                'per_group' => $row[5],
                'active' => 'Y',
                'per_major' => $row[7],
                'per_faculty' => 'Direktorat Kampus Surabaya',
                'per_years' => '2025',
            ]);

            // PersonRoleMapping
            PersonRoleMapping::create([
                'person_id' => $id,
                'role_id' => '101',
                'createdby' => '999',
                'created_at' => now()
            ]);

            // User
            User::create([
                'person_id' => $id,
                'username' => $row[2],
                'email_verified_at' => NULL,
                'password' => Hash::make($row[2]),
            ]);
        }

    }
}
