<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UnitPeople;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Person;
use Illuminate\Support\Str;
use App\Models\Unit;

class November2025UnitPeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('app/seeds/271125_seeder_add_user_dosen.xlsx');
        $data = Excel::toCollection(null, $path)[0];

        foreach ($data->skip(1) as $row) {

            if (empty($row[4])) continue;

            $person = Person::where('per_id', $row[2])->first();

            if (!$person) {
                info("Person dengan per_id {$row[2]} tidak ditemukan");
                continue;
            }

            $exists = UnitPeople::where('person_id', $person->id)->exists();

            if ($exists) {
                info("SKIP: {$person->per_name} sudah punya unit.");
                continue;
            }

            $unit = Unit::where('unit', $row[6])->first();

            UnitPeople::create([
                'id'         => Str::uuid(),
                'person_id'  => $person->id,
                'unit_id'    => $unit ? $unit->id : '000-000-000',
                'position'   => $row[7],
                'start_date' => '2025-11-28',
                'active'     => 'Y',
                'createdby'  => '999',
            ]);

            info("INSERT: {$person->per_name} berhasil dimasukkan ke unit {$row[6]}");
        }


    }
}
