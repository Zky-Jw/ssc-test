<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PersonRoleMapping;
use App\Models\Person;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class November2025PersonRoleMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path_pegawai = storage_path('app/seeds/271125_seeder_add_user_dosen.xlsx');
        $data_pegawai = Excel::toCollection(null, $path_pegawai)[0];

        foreach ($data_pegawai->skip(1) as $row) {
            $roleName = $row[8];
            $roleIdPegawai = null;
            $person = Person::where('per_email', $row[4])->first();

            switch($roleName) {
                case 'Pengguna':
                    $roleIdPegawai = '101';
                    break;
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

            PersonRoleMapping::firstOrCreate(
            [
                'person_id' =>$person->id,
            ],
            [
                'role_id' => $roleIdPegawai,
                'createdby' => '999',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
