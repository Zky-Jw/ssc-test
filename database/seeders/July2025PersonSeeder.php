<?php

namespace Database\Seeders;

use App\Models\Person;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class July2025PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::enableForeignKeyConstraints();

        $path_pegawai = storage_path('app/seeds/010725_seeder_add_user_pegawai.xlsx');
        $data_pegawai = Excel::toCollection(null, $path_pegawai)[0];


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
