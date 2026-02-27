<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $documentTemplates = [
            [
                'id' => '29c82e2f-b5f9-11ef-b3cc-51c2da007135',
                'title' => 'Peminjaman Orbit',
                'content' => json_encode([
                    ["name" => "Nomor surat", "type" => "Text"],
                    ["name" => "Nama mahasiswa", "type" => "Text"],
                    ["name" => "NIM", "type" => "Text"],
                    ["name" => "Program studi", "type" => "Text"],
                    ["name" => "Perwakilan", "type" => "Text"]
                ]),
                'required_field' => json_encode([
                    ["name" => "Nama Kegiatan", "type" => "text"],
                    ["name" => "Tanggal Kegiatan", "type" => "date"],
                    ["name" => "Durasi (dalam hari)", "type" => "number"],
                    ["name" => "Nama UKM", "type" => "text"],
                    ["name" => "Dosen Pembina", "type" => "text"]
                ]),
                'approval' => json_encode([
                    ["name" => ["id" => "bd646ece-5521-11ee-856c-04d4c477450f", "name" => "Admin PUTI"]]
                ]),
                'active' => 'Y',
                'createdby' => '999',
            ],
            [
                'id' => '4b5c6d7e-e8f9-11ef-b3cc-51c2da007135',
                'title' => 'Pengajuan Aktif Kuliah Kembali',
                'content' => json_encode([
                    ["name" => "Nomor surat", "type" => "Text"],
                    ["name" => "Nama mahasiswa", "type" => "Text"],
                    ["name" => "NIM", "type" => "Text"],
                    ["name" => "Program studi", "type" => "Text"],
                    ["name" => "Semester", "type" => "Text"]
                ]),
                'required_field' => json_encode([
                    ["name" => "Alasan Pengajuan", "type" => "text"],
                    ["name" => "Tanggal Pengajuan", "type" => "date"],
                    ["name" => "Kontak", "type" => "text"]
                ]),
                'approval' => json_encode([
                    ["name" => ["id" => "bd646e12-5521-11ee-856c-04d4c477450f", "name" => "Admin AKD"]]
                ]),
                'active' => 'Y',
                'createdby' => '999',
            ],
            [
                'id' => '5c6d7e8f-e9fa-11ef-b3cc-51c2da007135',
                'title' => 'Layanan Kesehatan Fisik',
                'content' => json_encode([
                    ["name" => "Nomor surat", "type" => "Text"],
                    ["name" => "Nama pasien", "type" => "Text"],
                    ["name" => "NIK", "type" => "Text"],
                    ["name" => "Alamat", "type" => "Text"],
                    ["name" => "Jenis layanan", "type" => "Text"]
                ]),
                'required_field' => json_encode([
                    ["name" => "Keluhan", "type" => "text"],
                    ["name" => "Tanggal Layanan", "type" => "date"],
                    ["name" => "Kontak", "type" => "text"]
                ]),
                'approval' => json_encode([
                    ["name" => ["id" => "bd646e70-5521-11ee-856c-04d4c477450f", "name" => "Admin KMHS"]]
                ]),
                'active' => 'Y',
                'createdby' => '999',
            ],
            [
                'id' => '6d7e8f90-eafb-11ef-b3cc-51c2da007135',
                'title' => 'Pelaporan Kerusakan Asset',
                'content' => json_encode([
                    ["name" => "Nomor surat", "type" => "Text"],
                    ["name" => "Nama pelapor", "type" => "Text"],
                    ["name" => "NIP", "type" => "Text"],
                    ["name" => "Jabatan", "type" => "Text"],
                    ["name" => "Unit kerja", "type" => "Text"]
                ]),
                'required_field' => json_encode([
                    ["name" => "Deskripsi Kerusakan", "type" => "text"],
                    ["name" => "Tanggal Pelaporan", "type" => "date"],
                    ["name" => "Lokasi Asset", "type" => "text"],
                    ["name" => "Kontak", "type" => "text"]
                ]),
                'approval' => json_encode([
                    ["name" => ["id" => "bd646f2c-5521-11ee-856c-04d4c477450f", "name" => "Admin LOG"]]
                ]),
                'active' => 'Y',
                'createdby' => '999',
            ],
            [
                'id' => '7e8f90a1-ebfc-11ef-b3cc-51c2da007135',
                'title' => 'Permintaan Kwitansi Pembayaran',
                'content' => json_encode([
                    ["name" => "Nomor surat", "type" => "Text"],
                    ["name" => "Nama pemohon", "type" => "Text"],
                    ["name" => "NIP", "type" => "Text"],
                    ["name" => "Jabatan", "type" => "Text"],
                    ["name" => "Unit kerja", "type" => "Text"]
                ]),
                'required_field' => json_encode([
                    ["name" => "Jumlah Pembayaran", "type" => "number"],
                    ["name" => "Tanggal Pembayaran", "type" => "date"],
                    ["name" => "Deskripsi Pembayaran", "type" => "text"],
                    ["name" => "Kontak", "type" => "text"]
                ]),
                'approval' => json_encode([
                    ["name" => ["id" => "bd646f8a-5521-11ee-856c-04d4c477450f", "name" => "Admin KUG"]]
                ]),
                'active' => 'Y',
                'createdby' => '999',
            ]
        ];

        DB::table('document_templates')->insert($documentTemplates);
    }
}
