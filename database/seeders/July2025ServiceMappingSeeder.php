<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceMapping;
use App\Models\Person;
use Illuminate\Support\Facades\DB;

class July2025ServiceMappingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personMappings = [
            ['old_recipient' => 'Selfina Anggraini', 'new_recipient' => 'Eka Sari Oktarina'],
            ['old_recipient' => 'Achmad Alvi Rizqi Mutamam', 'new_recipient' => 'Achmad Muzakki'],
            ['old_recipient' => 'Dr. Mohammad Yanuar Hariyawan, S.T., M.T.', 'new_recipient' => 'Susijanto Tri Rasmana'],
            ['old_recipient' => 'Muhammad Adib Kamali, S.T., M.Sc.', 'new_recipient' => 'Achmad Muzakki'],
            ['old_recipient' => 'Bernadus Anggo Seno Aji', 'new_recipient' => 'Muhammad Adib Kamali, S.T., M.Sc.'],
            ['old_recipient' => 'Fidi Wincoko Putro', 'new_recipient' => 'Dewi Rahmawati'],
            ['old_recipient' => 'Fanda Lyta Suzanayanti', 'new_recipient' => 'Selfina Anggraini'],
            ['old_recipient' => 'Mochamad Nizar Palevi Maady', 'new_recipient' => 'Berlian Rahmy Lidiawaty']
        ];

        DB::transaction(function () use ($personMappings) {
            foreach ($personMappings as $mapping) {
                $oldPerson = Person::where('person', $mapping['old_recipient'])->first();
                $newPerson = Person::where('person', $mapping['new_recipient'])->first();

                if ($oldPerson && $newPerson) {
                    ServiceMapping::whereHas('person', function ($q) use ($mapping) {
                        $q->where('person', $mapping['old_recipient']);
                    })->update([
                        'person_id' => $newPerson->id
                    ]);
                } else {
                    $this->command->warn("Skipped: {$mapping['old_name']} or {$mapping['new_name']} not found.");
                }
            }
        });
    }
}
