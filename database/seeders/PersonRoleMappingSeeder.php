<?php

namespace Database\Seeders;

use App\Models\PersonRoleMapping;
use App\Models\Person;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class PersonRoleMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personRoleMapping = [
            [
            'person_id' => 'bd646c5d-5521-11ee-856c-04d4c477450f',
            'role_id' => '106',
            'createdby' => '999',
            'created_at' => date('Y-m-d H:i:s')
            ],
            [
            'person_id' => 'bd646db4-5521-11ee-856c-04d4c477450f',
            'role_id' => '101',
            'createdby' => '999',
            'created_at' => date('Y-m-d H:i:s')
            ],
            [
            'person_id' => 'bd646e12-5521-11ee-856c-04d4c477450f',
            'role_id' => '103',
            'createdby' => '999',
            'created_at' => date('Y-m-d H:i:s')
            ],
            [
            'person_id' => 'bd646e70-5521-11ee-856c-04d4c477450f',
            'role_id' => '103',
            'createdby' => '999',
            'created_at' => date('Y-m-d H:i:s')
            ],
            [
            'person_id' => 'bd646ece-5521-11ee-856c-04d4c477450f',
            'role_id' => '103',
            'createdby' => '999',
            'created_at' => date('Y-m-d H:i:s')
            ],
            [
            'person_id' => 'bd646f2c-5521-11ee-856c-04d4c477450f',
            'role_id' => '103',
            'createdby' => '999',
            'created_at' => date('Y-m-d H:i:s')
            ],
            [
            'person_id' => 'bd646f8a-5521-11ee-856c-04d4c477450f',
            'role_id' => '103',
            'createdby' => '999',
            'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        PersonRoleMapping::insert($personRoleMapping);

        $path_mahasiswa = storage_path('app/seeds/250425_seeder_user_mahasiswa.xlsx');
        $path_pegawai = storage_path('app/seeds/210425_seeder_user_pegawai.xlsx');

        $data_mahasiswa = Excel::toCollection(null, $path_mahasiswa)[0];
        $data_pegawai = Excel::toCollection(null, $path_pegawai)[0];

        // Ambil semua Person yang sudah ada

        // Lewati baris header
        foreach ($data_mahasiswa->skip(1) as $row) {

            if (empty($row[4])) continue;

            $person = Person::where('per_email', $row[4])->first();

            if ($person) {
                PersonRoleMapping::create([
                    'person_id' => $person->id,
                    'role_id' => '101',
                    'createdby' => '999',
                    'created_at' => now()
                ]);
            }
        }

        // Lewati baris header
        foreach ($data_pegawai->skip(1) as $row) {
            $roleName = $row[9]; // misalnya kolom role ada di indeks ke-1
            $roleIdPegawai = null;
            $person = Person::where('per_email', $row[4])->first();

            switch($roleName) {
                case 'Petugas':
                    $roleIdPegawai = '102';
                    break;
                case 'Pelaksana':
                    $roleIdPegawai = '103';
                    break;
                case 'Pemimpin':
                    $roleIdPegawai = '104';
                    break;
                case 'Pengamat':
                    $roleIdPegawai = '105';
                    break;
                case 'Pengurus':
                    $roleIdPegawai = '106';
                    break;
            }

            PersonRoleMapping::create([
                'person_id' =>$person->id,
                'role_id' => $roleIdPegawai,
                'createdby' => '999',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
