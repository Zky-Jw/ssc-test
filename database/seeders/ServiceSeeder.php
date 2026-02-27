<?php

namespace Database\Seeders;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Service::truncate();
        Schema::enableForeignKeyConstraints();
        $services = [
            // Layanan Akademik
            [
                'id' => '1b0ae7e7-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Legalisir KHS Mahasiswa',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7e8-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Validasi Laporan MBKM',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7e9-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Pengajuan SK Tugas Akhir',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7ea-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Pengajuan Aktif Kuliah Kembali',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7eb-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Pengurusan Berkas Yudisium',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7ec-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Pengajuan Perubahan Data',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7ed-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Administratif Wisuda',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7ee-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Surat Rekomendasi Magang',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            // Layanan Kemahasiswaan
            [
                'id' => '1b0ae7ef-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Proposal Pendanaan Kegiatan',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7f0-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Proposal Pendanaan Kompetisi',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7f1-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Layanan Kesehatan Fisik',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7f2-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Pelaporan Prestasi',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7f3-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Pra-tracer & Tracer Studi',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7f4-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Layanan Pra-kerja',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7f5-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Pengajuan Layanan Kesehatan Mental',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7f6-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Layanan Self Improvement',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            // Layanan Pusat Teknologi Informasi
            [
                'id' => '1b0ae7f7-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Reset 2FA SSO',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7f8-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Akses Internet',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7f9-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Bug Aplikasi',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7fa-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Shared Hosting',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7fb-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Peminjaman Orbit',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            // Layanan Logistik
            [
                'id' => '1b0ae7fc-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Paket Peminjaman',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7fd-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Pelaporan Kerusakan Asset',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            // Layanan Keuangan
            [
                'id' => '1b0ae7fe-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Penundaan dan Pembayaran BPP',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
            [
                'id' => '1b0ae7ff-b5ee-11ef-b3cc-51c2da007135',
                'service' => 'Permintaan Kwitansi Pembayaran',
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ],
        ];

        DB::table('services')->insert($services);
    }
}
