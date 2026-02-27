<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceAdditionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceAdditionals = [
            // Layanan Akademik
            [
                'id' => '1b11360f-b5ee-11ef-b3cc-51c2da007135',
                'description' => '<p>Ini adalah layanan untuk mahasiswa bisa mendapat KHS yang di legalisir oleh Wakil Direktur Akademik</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>KTM</li><li>KHS yang perlu dilegalisir</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '2b11360f-b5ee-11ef-b3cc-51c2da007136',
                'description' => '<p>Ini adalah layanan Validasi Laporan MBKM</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Laporan MBKM</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '3b11360f-b5ee-11ef-b3cc-51c2da007137',
                'description' => '<p>Ini adalah layanan Pengajuan SK Tugas Akhir</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '4b11360f-b5ee-11ef-b3cc-51c2da007138',
                'description' => '<p>Ini adalah layanan Pengajuan Aktif Kuliah Kembali</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '5b11360f-b5ee-11ef-b3cc-51c2da007139',
                'description' => '<p>Ini adalah layanan Pengurusan Berkas Yudisium</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '6b11360f-b5ee-11ef-b3cc-51c2da007140',
                'description' => '<p>Ini adalah layanan Pengajuan Perubahan Data</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '7b11360f-b5ee-11ef-b3cc-51c2da007141',
                'description' => '<p>Ini adalah layanan Administratif Wisuda</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '8b11360f-b5ee-11ef-b3cc-51c2da007142',
                'description' => '<p>Ini adalah layanan Surat Rekomendasi Magang</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            // Layanan Kemahasiswaan
            [
                'id' => '9b11360f-b5ee-11ef-b3cc-51c2da007143',
                'description' => '<p>Ini adalah layanan Proposal Pendanaan Kegiatan</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Proposal Kegiatan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '10b11360f-b5ee-11ef-b3cc-51c2da007144',
                'description' => '<p>Ini adalah layanan Proposal Pendanaan Kompetisi</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Proposal Kompetisi</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '11b11360f-b5ee-11ef-b3cc-51c2da007145',
                'description' => '<p>Ini adalah layanan Layanan Kesehatan Fisik</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Kartu Mahasiswa</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '12b11360f-b5ee-11ef-b3cc-51c2da007146',
                'description' => '<p>Ini adalah layanan Pelaporan Prestasi</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Bukti Prestasi</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '13b11360f-b5ee-11ef-b3cc-51c2da007147',
                'description' => '<p>Ini adalah layanan Informasi Pra-tracer & Tracer Studi</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Tracer</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '14b11360f-b5ee-11ef-b3cc-51c2da007148',
                'description' => '<p>Ini adalah layanan Layanan Pra-kerja</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '15b11360f-b5ee-11ef-b3cc-51c2da007149',
                'description' => '<p>Ini adalah layanan Pengajuan Layanan Kesehatan Mental</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '16b11360f-b5ee-11ef-b3cc-51c2da007150',
                'description' => '<p>Ini adalah layanan Layanan Self Improvement</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            // Layanan PUTI
            [
                'id' => '17b11360f-b5ee-11ef-b3cc-51c2da007151',
                'description' => '<p>Ini adalah layanan Reset 2FA SSO</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '18b11360f-b5ee-11ef-b3cc-51c2da007152',
                'description' => '<p>Ini adalah layanan Akses Internet</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '19b11360f-b5ee-11ef-b3cc-51c2da007153',
                'description' => '<p>Ini adalah layanan Bug Aplikasi</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '20b11360f-b5ee-11ef-b3cc-51c2da007154',
                'description' => '<p>Ini adalah layanan Shared Hosting</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '21b11360f-b5ee-11ef-b3cc-51c2da007155',
                'description' => '<p>Ini adalah layanan Peminjaman Orbit</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            // Layanan Logistik
            [
                'id' => '22b11360f-b5ee-11ef-b3cc-51c2da007156',
                'description' => '<p>Ini adalah layanan Paket Peminjaman</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '23b11360f-b5ee-11ef-b3cc-51c2da007157',
                'description' => '<p>Ini adalah layanan Pelaporan Kerusakan Asset</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            // Layanan Keuangan
            [
                'id' => '24b11360f-b5ee-11ef-b3cc-51c2da007158',
                'description' => '<p>Ini adalah layanan Informasi Penundaan dan Pembayaran BPP</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ],
            [
                'id' => '25b11360f-b5ee-11ef-b3cc-51c2da007159',
                'description' => '<p>Ini adalah layanan Permintaan Kwitansi Pembayaran</p>',
                'requirement' => '<p>Yang harus dipersiapkan adalah</p><ul><li>Formulir Pengajuan</li></ul><p>&nbsp;</p><p>Pengajuan minimal H-3</p>',
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ]
        ];

        DB::table('service_additionals')->insert($serviceAdditionals);
    }
}
