<?php

namespace Database\Seeders;

use App\Models\Person;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;

class Desember2025UpdatePhonePersonSeeder extends Seeder
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
            Person::updateOrCreate(
                ['per_id' => $row[2]],
                [
                    'per_phone' => $row[3],
                ]
            );
        }
    }
}
