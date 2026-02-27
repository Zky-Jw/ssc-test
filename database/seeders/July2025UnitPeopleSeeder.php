<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UnitPeople;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Person;
use Illuminate\Support\Str;
use App\Models\Unit;

class July2025UnitPeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('app/seeds/010725_seeder_add_user_pegawai.xlsx');
        $data = Excel::toCollection(null, $path)[0];

        // Lewati baris header
        foreach ($data->skip(1) as $row) {

            // Cek apakah $row[5] (per_email) kosong
            if (empty($row[4])) continue;

            $person = Person::where('per_email', $row[4])->first();
            $unit = Unit::where('unit', $row[7])->first();

            UnitPeople::create([
                    'id' => Str::uuid(),
                    'person_id' => $person->id,
                    'unit_id' => ($unit)?$unit->id:'000-000-000',
                    'position' => $row[8],
                    'start_date' => '2025-07-01',
                    'active' => $row[6],
                    'createdby' => '999',
            ]);
        }

    }
}
