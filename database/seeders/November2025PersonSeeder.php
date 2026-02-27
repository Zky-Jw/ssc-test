<?php

namespace Database\Seeders;

use App\Models\Person;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class November2025PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::enableForeignKeyConstraints();

        $path_pegawai = storage_path('app/seeds/271125_seeder_add_user_dosen.xlsx');
        $data_pegawai = Excel::toCollection(null, $path_pegawai)[0];

        foreach ($data_pegawai->skip(1) as $row) {
            Person::firstOrCreate(
                ['per_id' => $row[2]],
                [
                    'id' => Str::uuid(),
                    'person' => $row[0],
                    'per_num' => $row[1],
                    'per_phone' => $row[3],
                    'per_email' => $row[4],
                    'per_group' => $row[5],
                    'per_major' => $row[6],
                    'per_faculty' => 'Direktorat Kampus Surabaya',
                    'active' => 'Y',
                ]
            );
        }

    }
}
