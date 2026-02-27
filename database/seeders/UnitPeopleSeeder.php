<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UnitPeople;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Person;
use Illuminate\Support\Str;
use App\Models\Unit;


class UnitPeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        UnitPeople::truncate();
        Schema::enableForeignKeyConstraints();
        $unitPeople = [
            [
                'id' => 'bda36e12-5521-11ee-856c-04d4c477450f',
                'person_id' => 'bd646e12-5521-11ee-856c-04d4c477450f',
                'unit_id' => 'bd646c5d-5521-11ee-akd1-04d4c477450f',
                'position' => 'Kepala Bagian',
                'start_date' => '2023-01-01',
                'active' => 'Y',
                'createdby' => '999',
            ],
            [
                'id' => 'bd646e70-5521-11ee-856c-04d4c477450f',
                'person_id' => 'bd646e70-5521-11ee-856c-04d4c477450f',
                'unit_id' => 'bd646c5d-5521-11ee-kem1-04d4c477450f',
                'position' => 'Kepala Bagian',
                'start_date' => '2023-01-01',
                'active' => 'Y',
                'createdby' => '999',
            ],
            [
                'id' => 'bd646ece-5521-11ee-856c-04d4c477450f',
                'person_id' => 'bd646ece-5521-11ee-856c-04d4c477450f',
                'unit_id' => 'bd646c5d-5521-11ee-pti1-04d4c477450f',
                'position' => 'Kepala Bagian',
                'start_date' => '2023-01-01',
                'active' => 'Y',
                'createdby' => '999',
            ],
            [
                'id' => 'bd646f2c-5521-11ee-856c-04d4c477450f',
                'person_id' => 'bd646f2c-5521-11ee-856c-04d4c477450f',
                'unit_id' => 'bd646c5d-5521-11ee-log1-04d4c477450f',
                'position' => 'Kepala Bagian',
                'start_date' => '2023-01-01',
                'active' => 'Y',
                'createdby' => '999',
            ],
            [
                'id' => 'bd646f8a-5521-11ee-856c-04d4c477450f',
                'person_id' => 'bd646f8a-5521-11ee-856c-04d4c477450f',
                'unit_id' => 'bd646c5d-5521-11ee-keu1-04d4c477450f',
                'position' => 'Kepala Bagian',
                'start_date' => '2023-01-01',
                'active' => 'Y',
                'createdby' => '999',
            ]
        ];

        $path = storage_path('app/seeds/210425_seeder_user_pegawai.xlsx');
        $data = Excel::toCollection(null, $path)[0];

        // Lewati baris header
        foreach ($data->skip(1) as $row) {

            // $person = Person::all();
            // $unit = Unit::all();

            // Cek apakah $row[5] (per_email) kosong
            if (empty($row[5])) continue;

            $person = Person::where('per_email', $row[4])->first();
            $unit = Unit::where('unit', $row[7])->first();

            UnitPeople::create([
                    'id' => Str::uuid(),
                    'person_id' => $person->id,
                    'unit_id' => ($unit)?$unit->id:'000-000-000',
                    'position' => $row[8],
                    'start_date' => '2023-01-01',
                    'active' => $row[6],
                    'createdby' => '999',
            ]);
        }

        // UnitPeople::insert($unitPeople);
    }
}
