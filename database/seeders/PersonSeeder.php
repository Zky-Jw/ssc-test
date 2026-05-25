<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Person::truncate();
        Schema::enableForeignKeyConstraints();

        $person = [
            [
                'id' => 'bd646c5d-5521-11ee-856c-04d4c477450f',
                'person' => 'Admin',
                'per_num' => '000000',
                'per_id' => '000000',
                'per_phone' => '0800000000',
                'per_email' => '',
                'per_group' => 'SUPERADMIN',
                'active' => 'Y'
            ],
            [
                'id' => 'bd646db4-5521-11ee-856c-04d4c477450f',
                'person' => 'Student',
                'per_num' => '111111',
                'per_id' => '111111',
                'per_phone' => '081111223311',
                'per_email' => 'student@student.com',
                'per_group' => 'MAHASISWA',
                'active' => 'Y'
            ],
            [
                'id' => 'bd646e12-5521-11ee-856c-04d4c477450f',
                'person' => 'Admin AKD',
                'per_num' => '400001',
                'per_id' => '400001',
                'per_phone' => '0840000001',
                'per_email' => 'admin-akd@tus.com',
                'per_group' => 'PEGAWAI',
                'active' => 'Y'
            ],
            [
                'id' => 'bd646e70-5521-11ee-856c-04d4c477450f',
                'person' => 'Admin KMHS',
                'per_num' => '500001',
                'per_id' => '500001',
                'per_phone' => '0850000002',
                'per_email' => 'admin-kmhs@tus.com',
                'per_group' => 'PEGAWAI',
                'active' => 'Y'
            ],
            [
                'id' => 'bd646ece-5521-11ee-856c-04d4c477450f',
                'person' => 'Admin PUTI',
                'per_num' => '300001',
                'per_id' => '300001',
                'per_phone' => '0830000003',
                'per_email' => 'admin-pti@tus.com',
                'per_group' => 'PEGAWAI',
                'active' => 'Y'
            ],
            [
                'id' => 'bd646f2c-5521-11ee-856c-04d4c477450f',
                'person' => 'Admin LOG',
                'per_num' => '600001',
                'per_id' => '600001',
                'per_phone' => '0860000004',
                'per_email' => 'admin-log@tus.com',
                'per_group' => 'PEGAWAI',
                'active' => 'Y'
            ],
            [
                'id' => 'bd646f8a-5521-11ee-856c-04d4c477450f',
                'person' => 'Admin KUG',
                'per_num' => '700001',
                'per_id' => '700001',
                'per_phone' => '0870000005',
                'per_email' => 'admin-kug@tus.com',
                'per_group' => 'PEGAWAI',
                'active' => 'Y'
            ],
        ];

       foreach ($person as $p) {
    Person::create($p);
}

        $path_mahasiswa = storage_path('app/seeds/250425_seeder_user_mahasiswa.xlsx');
        $path_pegawai = storage_path('app/seeds/210425_seeder_user_pegawai.xlsx');
        $data_mahasiswa = Excel::toCollection(null, $path_mahasiswa)[0];
        $data_pegawai = Excel::toCollection(null, $path_pegawai)[0];

        // Lewati baris header
        foreach ($data_mahasiswa->skip(1) as $row) {
            // Cek apakah $row[5] (per_email) kosong
            if (empty($row[4])) continue;

            Person::create([
                'id' => Str::uuid(),
                'person' => $row[0],
                'per_num' => $row[1],
                'per_id' => !empty($row[4]) ? Str::before($row[4], '@') : '',
                'per_phone' => $row[3],
                'per_email' => $row[4],
                'per_group' => $row[5],
                'active' => $row[6],
                'per_major' => $row[7],
                'per_faculty' => $row[8],
                'per_years' => $row[9],
            ]);
        }

        // Lewati baris header
        foreach ($data_pegawai->skip(1) as $row) {
                // Cek apakah $row[5] (per_email) kosong

        if (empty($row[5])) continue;

                            Person::create([
                                'id' => Str::uuid(),
                                'person' => $row[0],
                                'per_num' => $row[1],
                                'per_id' => $row[3],
                                'per_phone' => $row[2],
                                'per_email' => $row[4],
                                'per_group' => $row[5],
                                'active' => $row[6],
                            ]);
                    }
}
}
