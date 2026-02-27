<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class UpdateCommandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $arr=[
            'Pengajuan Dana Himpunan Mahasiswa ',
            'Pengaduan Orang Tua'
        ];

        foreach ($arr as $a) {
            $s = Service::where('service', $a)->get();
            foreach($s as $x){
                $x->active = 'N';
                $x->save();
            }
        }
    }
}
