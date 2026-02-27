<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\PersonRoleMapping;

class SSCFrontDeskAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fdArr = [
                    '1101230018',
                    '1205230014',
                    '1206220008',
                    '1206230015',
                ];   

        foreach ($fdArr as $f) {
            $p = Person::where('per_num',$f)->first();

            if($p){
                $m = PersonRoleMapping::where('person_id', $p->id)->first();

                if($m){
                    $m->role_id = 102;
                    $m->update();
                }
            }
        }
    }
}
