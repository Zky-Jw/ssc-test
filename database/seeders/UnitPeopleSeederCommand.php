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

class UnitPeopleSeederCommand extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unitPeople = [
            [
                'email' => 'amourepurba@student.telkomuniversity.ac.id',
                'unit' => 'Pusat Teknologi Informasi',
            ],
            [
                'email' => 'valentinocisa@student.telkomuniversity.ac.id',
                'unit' => 'Pusat Teknologi Informasi',
            ],
        ];

        foreach ($unitPeople as $up) {

            $person = Person::where('per_email', $up['email'])->first();
            $unit = Unit::where('unit', $up['unit'])->first();

            UnitPeople::create([
                    'id' => Str::uuid(),
                    'person_id' => $person->id,
                    'unit_id' => ($unit)?$unit->id:'000-000-000',
                    'position' => 'Pegawai',
                    'start_date' => '2023-01-01',
                    'active' => 'Y',
                    'createdby' => '999',
            ]);

        }
    }
}
