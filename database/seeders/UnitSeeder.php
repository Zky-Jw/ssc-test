<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Unit::truncate();
        Schema::enableForeignKeyConstraints();
        $units = [
            [
                'id' => 'bd646c5d-5521-11ee-sekre1-04d4c477450f',
                'unit' => 'Sekretariat',
                'icons' => 'icon-park-solid:degree-hat',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa0000", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-akd1-04d4c477450f',
                'unit' => 'Akademik',
                'icons' => 'icon-park-solid:degree-hat',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa0000", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-kem1-04d4c477450f',
                'unit' => 'Kemahasiswaan',
                'icons' => 'ph:student-fill',
                'icon' => Str::random(8),
                'colors' => json_encode(["#00aa00", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-pti1-04d4c477450f',
                'unit' => 'Pusat Teknologi Informasi',
                'icons' => 'material-symbols:computer-outline-rounded',
                'icon' => Str::random(8),
                'colors' => json_encode(["#0000aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-log1-04d4c477450f',
                'unit' => 'Logistik',
                'icons' => 'mynaui:package-solid',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aaaa00", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-keu1-04d4c477450f',
                'unit' => 'Keuangan',
                'icons' => 'ph:money-wavy-bold',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa00aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-labpusbas1-04d4c477450f',
                'unit' => 'Laboratorium dan Pusat Bahasa',
                'icons' => 'ph:money-wavy-bold',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa00aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-bce1-04d4c477450f',
                'unit' => 'S1 Teknik Komputer - Kampus Surabaya',
                'icons' => 'ph:money-wavy-bold',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa00aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-bee1-04d4c477450f',
                'unit' => 'S1 Teknik Elektro - Kampus Surabaya',
                'icons' => 'ph:money-wavy-bold',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa00aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-bse1-04d4c477450f',
                'unit' => 'S1 Rekayasa Perangkat Lunak - Kampus Surabaya',
                'icons' => 'ph:money-wavy-bold',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa00aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-bte1-04d4c477450f',
                'unit' => 'S1 Teknik Telekomunikasi - Kampus Surabaya',
                'icons' => 'ph:money-wavy-bold',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa00aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-bis1-04d4c477450f',
                'unit' => 'S1 Sistem Informasi - Kampus Surabaya',
                'icons' => 'ph:money-wavy-bold',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa00aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-bie1-04d4c477450f',
                'unit' => 'S1 Teknik Industri - Kampus Surabaya',
                'icons' => 'ph:money-wavy-bold',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa00aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-bit1-04d4c477450f',
                'unit' => 'S1 Teknologi Informasi - Kampus Surabaya',
                'icons' => 'ph:money-wavy-bold',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa00aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-bdb1-04d4c477450f',
                'unit' => 'S1 Bisnis Digital - Kampus Surabaya',
                'icons' => 'ph:money-wavy-bold',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa00aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-bif1-04d4c477450f',
                'unit' => 'S1 Informatika - Kampus Surabaya',
                'icons' => 'ph:money-wavy-bold',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa00aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-bds1-04d4c477450f',
                'unit' => 'S1 Sains Data - Kampus Surabaya',
                'icons' => 'ph:money-wavy-bold',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa00aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => 'bd646c5d-5521-11ee-ble1-04d4c477450f',
                'unit' => 'S1 Teknik Logistik - Kampus Surabaya',
                'icons' => 'ph:money-wavy-bold',
                'icon' => Str::random(8),
                'colors' => json_encode(["#aa00aa", "#000000"]),
                'unit_parent' => '',
                'show' => 'Y',
                'active' => 'Y',
                'createdby' => '999'
            ],
        ];

        DB::table('units')->insert($units);
    }
}
