<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\Service;
use App\Models\ServiceMapping;
use App\Models\ServiceCategory;
use App\Models\ServiceAdditional;
use App\Models\Unit;
use App\Models\Ticket;
use App\Models\TicketProgress;
use App\Models\TicketLog;
use App\Models\Resolution;

class BackdateTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = [
            ['closed_date'=>'23/04/25','student_id'=>'1103228037','service'=>'Permohonan Transkrip Nilai Sementara', 'content'=>'Transkip Nilai Sementara untuk lamaran Kerja.', 'ticket_num'=> '12000422', 'phone'=>'082132100540'],
            ['closed_date'=>'02/01/24','student_id'=>'1202220028','service'=>'Paket Peminjaman', 'content'=>'Kode : 750
            Tgl pengajuan : 2 Januari 2025
            Nama Peminjam : Adryan Dimaz Pratama Tarigan
            No HP :083130133273
            Waktu Peminjaman : 11-13 Januari 2025 (07.00-22.00)
            Oleh : Keluarga Mahasiswa Katolik
            Untuk : HUT KMK Telkom University Surabaya
            List yang dipinjam :
            - Paket Kelas 1
            - Paket Listrik 1', 'ticket_num'=> '12000002', 'phone'=>'083130133273'],
            ['closed_date'=>'03/01/25','student_id'=>'1104220012','service'=>'Paket Peminjaman', 'content'=>'Kode : 752
            Tgl pengajuan : 3 Januari 2025
            Nama Peminjam : Ahmad Maulana M.
            No HP :08814977192
            Waktu Peminjaman : 10-11 Januari 2025 (09.00-17.00)
            Oleh : Himpunan Mahasiswa Teknik Industri 
            Untuk : Open Recruitment HMTI
            List yang dipinjam :
            - Paket Kelas 1 (Request Ruangan Kelas Sekat )', 'ticket_num'=> '12000004', 'phone'=>'08814977192'],
            ['closed_date'=>'03/01/25','student_id'=>'1103230002','service'=>'Paket Peminjaman', 'content'=>'Kode : 753
            Tgl pengajuan : 03 Januari 2025
            Nama Peminjam : Pedro Bernadus B        
            No HP : 085159886064    
            Waktu Peminjaman : 11 - 13 Januari 2025 (07.00-22.00)
            Oleh : DPM
            Untuk : Serah Terima Jabatan
            List yang dipinjam :
            - 1 Paket Audio Lapangan
            - 2 Paket Komunikasi
            - 1 Paket Visual
            - 1 Paket Musyawarah
            - 1 Paket Kelas (Basecamp Panitia)
            - 1 Paket Listrik ', 'ticket_num'=> '12000005', 'phone'=>'085159886064'],
            ['closed_date'=>'03/01/25','student_id'=>'1206220035','service'=>'Paket Peminjaman', 'content'=>'Kode : 754
            Tgl pengajuan : 03 Januari 2025
            Nama Peminjam : Ferdyan Paskah Dyka Wahyudi
            No HP : 082132777310    
            Waktu Peminjaman : 11 Januari 2025 (08.00-13.00)
            Oleh : HIMASDATA
            Untuk : Foto Himasdata Periode 2024
            List yang dipinjam :
            - 1 Paket Lighting', 'ticket_num'=> '12000006', 'phone'=>'082132777310'],
            ['closed_date'=>'03/01/25','student_id'=>'1101230030','service'=>'Paket Peminjaman', 'content'=>'Kode : 755
            Tgl pengajuan : 03 Januari 2025
            Nama Peminjam : M. Khoirur Rizqi
            No HP : 0882077296172   
            Waktu Peminjaman : 20 Januari 2025 (06.00-20.00)
            Oleh : HIMA TESLA
            Untuk : PEMIRA HIMA TESLA
            List yang dipinjam :
            - 1 Paket Kelas 2.25-2.26 
            - 1 Paket Audio Portable
            - 1 Paket Komunikasi
            - 2 Kabel Olor
            - 1 Kamera a6400
            - 1 Lensa Sigma 24-70mm
            - 1 Baterai Kamera Sony NP-FW50
            - 1 Charger Baterai Sony NP-FW50', 'ticket_num'=> '12000007', 'phone'=>'0882077296172'],
            ['closed_date'=>'03/01/25','student_id'=>'1101230030','service'=>'Paket Peminjaman', 'content'=>'Kode : 756
            Tgl pengajuan : 03 Januari 2025
            Nama Peminjam : M. Khoirur Rizqi
            No HP : 0882077296172   
            Waktu Peminjaman : 25 Januari 2025 (06.00-20.00)
            Oleh : HIMA TESLA
            Untuk : PEMIRA HIMA TESLA
            List yang dipinjam :
            - 1 Paket Kelas 2.25-2.26 
            - 1 Paket Audio Portable
            - 1 Paket Komunikasi
            - 2 Kabel Olor
            - 1 Kamera a6400
            - 1 Lensa Sigma 24-70mm
            - 1 Baterai Kamera Sony NP-FW50
            - 1 Charger Baterai Sony NP-FW50
            - 1 Mic wireless', 'ticket_num'=> '12000008', 'phone'=>'0882077296172'],
            ['closed_date'=>'06/01/25','student_id'=>'1206230018','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab. 1.30 untuk INCREMENT pada tanggal 5 Februari 2025 (06.00-19.00), 8 & 22 Februari 2025 (06.00-15.00) dan 21 Februari 2025 (06.00-20.00)', 'ticket_num'=> '12000009', 'phone'=>'087855149236'],
            ['closed_date'=>'08/01/25','student_id'=>'1202220028','service'=>'Paket Peminjaman', 'content'=>'Kode : 757
            Tgl pengajuan : 06 Januari 2025
            Nama Peminjam : Adryan Dimaz Pratama Tarigan
            No HP : 083130133273
            Waktu Peminjaman : 23 Januari 2025 (07.00-22.00)
            Oleh : KMK
            Untuk : HUT KMK Telkom University Surabaya
            List yang dipinjam :
            - 1 Paket kelas ( Request Kelas Sekat ) ', 'ticket_num'=> '12000010', 'phone'=>'083130133273'],
            ['closed_date'=>'23/04/25','student_id'=>'1103238028','service'=>'Permohonan Transkrip Nilai Sementara', 'content'=>'Transkip Nilai Sementara untuk lamaran Kerja.', 'ticket_num'=> '12000423', 'phone'=>'0895638014655'],
            ['closed_date'=>'08/01/25','student_id'=>'102072400021','service'=>'Paket Peminjaman', 'content'=>'Kode : 758
            Tgl pengajuan : 08 Januari 2025
            Nama Peminjam : M Hujjatvi R
            No HP : 081295987221
            Waktu Peminjaman : 21 Februari 2025 (09.00-15.00)
            Oleh : HIMA Teknik Logistik 
            Untuk : Lomba Desain Poster
            List yang dipinjam :
            - Paket Aula 1
            - Paket komunikasi 2
            - Paket Audio portabel 1
            - Paket Listrik 1
            - Paket Duduk 2', 'ticket_num'=> '12000012', 'phone'=>'081295987221'],
            ['closed_date'=>'08/01/25','student_id'=>'1101230003','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman LAB , Untuk Rapat HIMA, Tanggal 17 januari 2025, Hari Jumat (pagi-sore)', 'ticket_num'=> '12000013', 'phone'=>'085888144207'],
            ['closed_date'=>'08/01/25','student_id'=>'1203220121','service'=>'Paket Peminjaman', 'content'=>'Kode : 759
            Tgl pengajuan : 08 Januari 2025
            Nama Peminjam : Sherly Faradilla Safitri
            No HP : 085755568992
            Waktu Peminjaman : 19 Februari 2025 (16.00-22.00)
            Oleh : HIMA Informatika 
            Untuk : Serah Terima Jabatan Kepengurusan Baru HMIF
            List yang dipinjam :
            - Paket Aula 1
            - Paket Musyawarah 1
            - Paket Audio portabel 1
            - Paket Visual 1
            - Paket Duduk 2
            - Paket HDMI 1', 'ticket_num'=> '12000014', 'phone'=>'085755568992'],
            ['closed_date'=>'08/01/25','student_id'=>'1101230017','service'=>'Paket Peminjaman', 'content'=>'Kode : 760
            Tgl pengajuan : 08 Januari 2025
            Nama Peminjam : Martin A. F. Sinaga
            No HP : 082283902236
            Waktu Peminjaman : 20 Januari 2025 (06.00-17.00)
            Oleh : HIMA TESLA
            Untuk : Pemira HIMA TESLA
            List yang dipinjam :
            - Paket Musyawarah 1', 'ticket_num'=> '12000015', 'phone'=>'082283902236'],
            ['closed_date'=>'08/01/25','student_id'=>'1101230017','service'=>'Paket Peminjaman', 'content'=>'Kode : 761
            Tgl pengajuan : 08 Januari 2025
            Nama Peminjam : Martin A. F. Sinaga
            No HP : 082283902236
            Waktu Peminjaman : 25 Januari 2025 (06.00-17.00)
            Oleh : HIMA TESLA
            Untuk : Pemira HIMA TESLA
            List yang dipinjam :
            - Paket Musyawarah 1', 'ticket_num'=> '12000016', 'phone'=>'082283902236'],
            ['closed_date'=>'08/01/25','student_id'=>'1101230017','service'=>'Paket Peminjaman', 'content'=>'Kode : 762
            Tgl pengajuan : 08 Januari 2025
            Nama Peminjam : Martin A. F. Sinaga
            No HP : 082283902236
            Waktu Peminjaman : 17 Januari 2025 (06.00-17.00)
            Oleh : HIMA TESLA
            Untuk : Pemira HIMA TESLA
            List yang dipinjam :
            - Paket HDMI 1
            - Paket Audio Portable 1 
            - Paket komunikasi 1 
            - Paket Listrik 1 
            - Paket Musyawarah 1 ', 'ticket_num'=> '12000017', 'phone'=>'082283902236'],
            ['closed_date'=>'09/01/25','student_id'=>'1103230018','service'=>'Legalisir KHS Mahasiswa', 'content'=>'permintaan ttd pak nasrul ', 'ticket_num'=> '12000018', 'phone'=>'082229559857'],
            ['closed_date'=>'09/01/25','student_id'=>'1202220028','service'=>'Paket Peminjaman', 'content'=>'Kode : 763
            Tgl pengajuan : 30 Desember 2024
            Nama Peminjam : Adryan Dimaz Pratama Tarigan
            No HP :083130133273
            Waktu Peminjaman : 15-18 Januari 2025 (07.00-22.00)
            Oleh : Keluarga Mahasiswa Katolik
            Untuk : HUT KMK Telkom University Surabaya
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000019', 'phone'=>'083130133273'],
            ['closed_date'=>'09/01/25','student_id'=>'1101230051','service'=>'Pengajuan Surat keterangan Tidak Menerima Beasiswa', 'content'=>'Menanyakan status beasiswa ', 'ticket_num'=> '12000020', 'phone'=>'081249709473'],
            ['closed_date'=>'09/01/25','student_id'=>'1105230006','service'=>'Paket Peminjaman', 'content'=>'Kode : 764
            Tgl pengajuan : 9 Januari 2025
            Nama Peminjam : Rengganis Puspa G.
            No HP : 082175136249
            Waktu Peminjaman : 15 Februari 2025 (08.00-16.00)
            Oleh : Telkom Art
            Untuk : Photoshoot BPH Baru
            List yang dipinjam :
            - Paket Lighting 1
            - Paket Listrik 1 ', 'ticket_num'=> '12000021', 'phone'=>'082175136249'],
            ['closed_date'=>'09/01/25','student_id'=>'1105230006','service'=>'Paket Peminjaman', 'content'=>'Kode : 765
            Tgl pengajuan : 9 Januari 2025
            Nama Peminjam : Rengganis Puspa G.
            No HP : 082175136249
            Waktu Peminjaman : 22-23 Februari 2025 (06.30-16.00)
            Oleh : Telkom Art
            Untuk : Interview & Audisi Anggota Telkom Art
            List yang dipinjam :
            - Paket Kelas 8
            - Paket Audio Portable 2
            - Paket Audio Lapangan 1 ', 'ticket_num'=> '12000022', 'phone'=>'082175136249'],
            ['closed_date'=>'09/01/25','student_id'=>'1201230032','service'=>'Peminjaman Orbit', 'content'=>'Peminjaman 1 orbit pada tanggal, 22-24 Februari 2025. Untuk kegiatan SAFEST Himse. Tempat Aula Lt.G Telkom University Surabaya.', 'ticket_num'=> '12000023', 'phone'=>'085334826169'],
            ['closed_date'=>'09/01/25','student_id'=>'1201230032','service'=>'Paket Peminjaman', 'content'=>'Kode : 766
            Tgl pengajuan : 9 Januari 2025
            Nama Peminjam : Alvian Novi R.
            No HP : 085334826169
            Waktu Peminjaman : 22-24 Januari 2025 (07.00-17.00)
            Oleh : RPL
            Untuk : SEFEST
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000024', 'phone'=>'085334826169'],
            ['closed_date'=>'10/01/25','student_id'=>'1103230020','service'=>'Pengajuan Surat keterangan Tidak Menerima Beasiswa', 'content'=>'Surat Keterangan Tidak Menerima Beasiswa', 'ticket_num'=> '12000025', 'phone'=>'088970763337'],
            ['closed_date'=>'13/01/25','student_id'=>'1103230043','service'=>'Paket Peminjaman', 'content'=>'Kode : 767
            Tgl pengajuan : 13 Januari 2025
            Nama Peminjam : Achmad Syihama.
            No HP : 082338624535
            Waktu Peminjaman : 12-13 Februari 2025 (06.00-21.00)
            Oleh : HME
            Untuk : Serah Terima Jabatan (Sertijab)
            List yang dipinjam :
            - Paket Kelas 3 (Ruang kelas sekat dan 1 Ruang kelas reguler)
            - Paket Audio Lapangan 1
            - Paket HDMI 1
            - Paket Listrik 1
            - Paket Streaming 1
            - Paket Musyawarah 1
            - Paket Visual 1', 'ticket_num'=> '12000026', 'phone'=>'082338624535'],
            ['closed_date'=>'14/01/25','student_id'=>'1206230024','service'=>'Paket Peminjaman', 'content'=>'Kode : 768
            Tgl pengajuan : 14 Januari 2025
            Nama Peminjam : Jonathan Sihombing 
            No HP : 087728035643
            Waktu Peminjaman : 1-7 Februari 2025 (07.00-22.00)
            Oleh : Himasdata
            Untuk : Latihan pensin event gathering mahasiswa sains data
            List yang dipinjam :
            - Paket Kelas 3 ', 'ticket_num'=> '12000027', 'phone'=>'087728035643'],
            ['closed_date'=>'14/01/25','student_id'=>'1206230025','service'=>'Paket Peminjaman', 'content'=>'Kode : 769
            Tgl pengajuan : 14 Januari 2025
            Nama Peminjam : Jonathan Sihombing 
            No HP : 087728035643
            Waktu Peminjaman : 9-12 Februari 2025 (07.00-22.00)
            Oleh : Himasdata
            Untuk : Latihan pensin event gathering mahasiswa sains data
            List yang dipinjam :
            - Paket Kelas 3', 'ticket_num'=> '12000028', 'phone'=>'087728035643'],
            ['closed_date'=>'14/01/25','student_id'=>'1206230026','service'=>'Paket Peminjaman', 'content'=>'Kode : 770
            Tgl pengajuan : 14 Januari 2025
            Nama Peminjam : Jonathan Sihombing 
            No HP : 087728035643
            Waktu Peminjaman : 14 Februari 2025 (07.00-22.00)
            Oleh : Himasdata
            Untuk : Latihan pensin event gathering mahasiswa sains data
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000029', 'phone'=>'087728035643'],
            ['closed_date'=>'14/01/25','student_id'=>'1206230027','service'=>'Paket Peminjaman', 'content'=>'Kode : 771
            Tgl pengajuan : 14 Januari 2025
            Nama Peminjam : Jonathan Sihombing 
            No HP : 087728035643
            Waktu Peminjaman : 15-16 Februari 2025 (07.00-22.00)
            Oleh : Himasdata
            Untuk : Latihan pensin event gathering mahasiswa sains data
            List yang dipinjam :
            - Paket Aula 
            - Paket kelas 2
            - Paket Audio Portable
            - Paket visual 2
            - Paket komunikasi 2
            - Toa 1
            - Paket Listrik 1
            - Paket Musyawarah 1', 'ticket_num'=> '12000030', 'phone'=>'087728035643'],
            ['closed_date'=>'15/01/25','student_id'=>'103082400019','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman LAB Digital Star-Up, Untuk Pelatihan Umum HIMSE, Tanggal 18-23 januari 2025, Hari Sabtu-Kamis (06.00 - 22.00)', 'ticket_num'=> '12000031', 'phone'=>'0895383166981'],
            ['closed_date'=>'15/01/25','student_id'=>'1203220020','service'=>'Paket Peminjaman', 'content'=>'Kode : 772
            Tgl pengajuan : 15 Januari 2025
            Nama Peminjam : Tiara Luthfiana P. 
            No HP : 082337952231
            Waktu Peminjaman : 23 Januari 2025 (13.00-15.00)
            Oleh : Paduan Suara Vox Auream
            Untuk : Serah terima Jabatan Vox Auream 2025
            List yang dipinjam :
            - Paket Kelas 1 (kelas bersekat)
            - Paket Audio Portable 1', 'ticket_num'=> '12000032', 'phone'=>'082337952231'],
            ['closed_date'=>'16/01/25','student_id'=>'1101230030','service'=>'Paket Peminjaman', 'content'=>'Kode : 773
            Tgl pengajuan : 16 Januari 2025
            Nama Peminjam : M. Khoirur Rizqi
            No HP : 0882007296172
            Waktu Peminjaman : 24 Januari 2025 (07.00-22.00)
            Oleh : HIMA TESLA
            Untuk : Pemira HIMA TESLA
            List yang dipinjam :
            - Paket Kelas 3 (kelas bersekat + kelas reguler)
            ', 'ticket_num'=> '12000033', 'phone'=>'0882007296172'],
            ['closed_date'=>'17/01/25','student_id'=>'1206220028','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'proposal dana kegiatan DS Orientation 2025', 'ticket_num'=> '12000034', 'phone'=>'0895370686939'],
            ['closed_date'=>'27/02/25','student_id'=>'1103210002','service'=>'Pengajuan Surat Pengantar Mata Kuliah', 'content'=>'Surat untuk non-active mata kuliah unutk KP, karena di igracias mata kuliah yang mengulang (namun sekarang sudah lulus) masih di nyatakan tidak lulus. Jadi tidak bisa lolos pesyaratan KP.', 'ticket_num'=> '12000290', 'phone'=>'081317208519'],
            ['closed_date'=>'17/01/25','student_id'=>'1103230043','service'=>'Paket Peminjaman', 'content'=>'Kode : 774
            Tgl pengajuan : 17 Januari 2025
            Nama Peminjam : Khosyi Kafi Kirdiat
            No HP : 08970697248
            Waktu Peminjaman : 1 Februari 2025 (06.00-17.00)
            Oleh : HIMASDATA
            Untuk : Live QnA Open Recruitment
            List yang dipinjam :
            - Paket Kelas 1 
            ', 'ticket_num'=> '12000036', 'phone'=>'08970697248'],
            ['closed_date'=>'17/01/25','student_id'=>'1103230044','service'=>'Paket Peminjaman', 'content'=>'Kode : 775
            Tgl pengajuan : 17 Januari 2025
            Nama Peminjam : Khosyi Kafi Kirdiat
            No HP : 08970697248
            Waktu Peminjaman : 8 - 9 Februari 2025 (06.00-17.00)
            Oleh : HIMASDATA
            Untuk : Open Recruitment Pengurus HIMASDATA 2025
            List yang dipinjam :
            - Paket Kelas 4 ( Request Ruang Bersekat 2.23 - 2.26 ) 
            - Paket Listrik 1 ', 'ticket_num'=> '12000037', 'phone'=>'08970697248'],
            ['closed_date'=>'17/01/25','student_id'=>'1103230045','service'=>'Paket Peminjaman', 'content'=>'Kode : 776
            Tgl pengajuan : 17 Januari 2025
            Nama Peminjam : Khosyi Kafi Kirdiat
            No HP : 08970697248
            Waktu Peminjaman : 22 Februari 2025 (06.00-17.00)
            Oleh : HIMASDATA
            Untuk : Forum Diskusi BRAYA 24
            List yang dipinjam :
            - Paket Kelas 1 
            ', 'ticket_num'=> '12000038', 'phone'=>'08970697248'],
            ['closed_date'=>'17/01/25','student_id'=>'1204220058','service'=>'Paket Peminjaman', 'content'=>'Kode : 777
            Tgl pengajuan : 17 Januari 2025
            Nama Peminjam : Dimas Nabil Arlia
            No HP : 085155156382
            Waktu Peminjaman : 3 Februari 2025 (07.00-18.00)
            Oleh : HMSI
            Untuk : Upgrading Staff HMSI
            List yang dipinjam :
            - Paket Kelas 4 (ruang kelas bersekat 2.23-2.26) 
            ', 'ticket_num'=> '12000039', 'phone'=>'085155156382'],
            ['closed_date'=>'17/01/25','student_id'=>'1204220059','service'=>'Paket Peminjaman', 'content'=>'Kode : 778
            Tgl pengajuan : 17 Januari 2025
            Nama Peminjam : Dimas Nabil Arlia
            No HP : 085155156382
            Waktu Peminjaman : 27 Januari 2025 (07.00-18.00)
            Oleh : HMSI
            Untuk : Wawancara Open Recuirtment Staff HMSI
            List yang dipinjam :
            - Paket Kelas 6 (ruang kelas bersekat) 
            - Paket Listrik 2 ', 'ticket_num'=> '12000040', 'phone'=>'085155156382'],
            ['closed_date'=>'17/01/25','student_id'=>'1206230042','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'Proposal Dana Kegiatan INCREMENT 2025', 'ticket_num'=> '12000041', 'phone'=>'081330812931'],
            ['closed_date'=>'17/01/25','student_id'=>'1206230044','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'Proposal Dana Kegiatan Open Recruitment dan Gathering', 'ticket_num'=> '12000042', 'phone'=>'085604106902'],
            ['closed_date'=>'20/01/25','student_id'=>'1201220445','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'pinjam lab untuk tanggal 20 ', 'ticket_num'=> '12000043', 'phone'=>'08817028161'],
            ['closed_date'=>'20/01/25','student_id'=>'1203220079','service'=>'Peminjaman Orbit', 'content'=>'Peminjaman Orbit untuk kegiatan HUT KMK ST. Filegon (Lomba Mobile Legends) pada Kamis, 23 Januari 2025 - Rabu, 29 Januari 2025', 'ticket_num'=> '12000044', 'phone'=>'087854726516'],
            ['closed_date'=>'20/01/25','student_id'=>'1202220028','service'=>'Paket Peminjaman', 'content'=>'Kode : 779
            Tgl pengajuan : 20 Januari 2025
            Nama Peminjam : Adryan Dimaz Pratama Tarigan
            No HP : 083130133273
            Waktu Peminjaman : 27 Januari 2025 - 29 Januari 2025 (08.00-22.00)
            Oleh : kmk
            Untuk : Perlombaan Mobile Legend Glorificon
            List yang dipinjam :
            - Paket Aula 1
            - Paket Listrik 2
            - Paket Streaming 1 
            - Paket HDMI 2
            - Paket komunikasi 3 
            - Paket kursi 1 ( add ons meja 2 ) ', 'ticket_num'=> '12000045', 'phone'=>'083130133273'],
            ['closed_date'=>'21/01/25','student_id'=>'1104210050','service'=>'Legalisir KHS Mahasiswa', 'content'=>'Meminta legalisisr beasiswa bpjs', 'ticket_num'=> '12000046', 'phone'=>'087761227072'],
            ['closed_date'=>'23/01/25','student_id'=>'1103230043','service'=>'Paket Peminjaman', 'content'=>'Kode : 780
            Tgl pengajuan : 23 Januari 2025
            Nama Peminjam : Achmad Syiham A.
            No HP : 082338624535
            Waktu Peminjaman : 13 Februari 2025 (06.00-22.00)
            Oleh : HME
            Untuk : SERTIJAB dan FHME
            List yang dipinjam :
            - Paket Kelas 4 set ( Request Ruang Kelas Sekat ) 
            - Paket Audio Lapangan 1 Set
            - Paket HDMI 1 Set
            - Paket Listrik 1 Set
            - Paket Streaming 1 Set
            - Paket Musyawarah 1 Set
            - Paket Visual 1 Set', 'ticket_num'=> '12000047', 'phone'=>'082338624535'],
            ['closed_date'=>'23/01/25','student_id'=>'1206230024','service'=>'Peminjaman Orbit', 'content'=>'Peminjaman Orbit untuk kegiatan INCREMENT Sains Data pada Rabu, 5 Februari 2025 - Sabtu, 8 Februari 2025', 'ticket_num'=> '12000048', 'phone'=>'087728035643'],
            ['closed_date'=>'23/01/25','student_id'=>'1206230024','service'=>'Peminjaman Orbit', 'content'=>'Peminjaman Orbit untuk kegiatan INCREMENT Sains Data pada Sabtu, 22 Februari 2025', 'ticket_num'=> '12000049', 'phone'=>'087728035643'],
            ['closed_date'=>'28/02/25','student_id'=>'1103220025','service'=>'Pengajuan Surat Pengantar Mata Kuliah', 'content'=>'Surat untuk non-active mata kuliah di mba defi', 'ticket_num'=> '12000317', 'phone'=>'081335807256'],
            ['closed_date'=>'30/01/25','student_id'=>'1203220079','service'=>'Paket Peminjaman', 'content'=>'Kode : 783 
            Tgl pengajuan : 30 Januari 2025
            Nama Peminjam : Michael Leonardo
            No HP : 087854726516
            Waktu Peminjaman : 1-2 Maret 2025 (08.00-22.00)
            Oleh : BEM
            Untuk : Wawancara Staff Baru BEM TEL-U 2025
            List yang dipinjam :
            - Paket Ruang Kelas ( Ruang Bersekat dan Reguler)
             ', 'ticket_num'=> '12000054', 'phone'=>'087854726516'],
            ['closed_date'=>'30/01/25','student_id'=>'1203220079','service'=>'Paket Peminjaman', 'content'=>'Kode : 784
            Tgl pengajuan : 30 Januari 2025
            Nama Peminjam : Michael Leonardo
            No HP : 087854726516
            Waktu Peminjaman : 8 Maret 2025 (08.00-22.00)
            Oleh : BEM
            Untuk : First Meet Seluruh Anggota BEM KEMA TEL-U SBY
            List yang dipinjam :
            - Paket HDMI 1
            - Paket Aula 1
            - Paket Duduk 2
            - Paket Musyawarah 1
             ', 'ticket_num'=> '12000055', 'phone'=>'087854726516'],
            ['closed_date'=>'30/01/25','student_id'=>'1203220079','service'=>'Paket Peminjaman', 'content'=>'Kode : 785
            Tgl pengajuan : 30 Januari 2025
            Nama Peminjam : Michael Leonardo
            No HP : 087854726516
            Waktu Peminjaman : 15-16 Maret 2025 (08.00-22.00)
            Oleh : BEM
            Untuk : SIDANG PLENO DAN RAKER BEM KEMA TEL-U SBY
            List yang dipinjam :
            - Paket HDMI 1
            - Paket Aula 1
            - Paket Duduk 2
            - Paket Musyawarah 1', 'ticket_num'=> '12000056', 'phone'=>'087854726516'],
            ['closed_date'=>'30/01/25','student_id'=>'1203220079','service'=>'Paket Peminjaman', 'content'=>'Kode : 786
            Tgl pengajuan : 30 Januari 2025
            Nama Peminjam : Michael Leonardo
            No HP : 087854726516
            Waktu Peminjaman : 22 Maret 2025 (08.00-22.00)
            Oleh : BEM
            Untuk : Diklat Staff BEM KEMA TEL-U SBY 2025
            List yang dipinjam :
            - Paket Aula 1
            - Paket HDMI 1
            - Paket Duduk 2 ', 'ticket_num'=> '12000057', 'phone'=>'087854726516'],
            ['closed_date'=>'21/04/25','student_id'=>'1202230023','service'=>'Pengajuan Surat Keterangan Aktif Mahasiswa', 'content'=>'surat keterangan ', 'ticket_num'=> '12000392', 'phone'=>'081272064805'],
            ['closed_date'=>'30/01/25','student_id'=>'1201220003','service'=>'Paket Peminjaman', 'content'=>'Kode : 788
            Tgl pengajuan : 30 Januari 2025
            Nama Peminjam : Zidan Irfan Z.
            No HP : Zidan Irfan Z.
            Waktu Peminjaman : 14 Februari 2025 (13.00- Selesai)
            Oleh : E-Sport
            Untuk : Honor Of Kings 
            List yang dipinjam :
            - Paket kelas 2 ( Request ruangan bersekat )
            - Paket Visual 2 
            - Paket Listrik 2 ', 'ticket_num'=> '12000060', 'phone'=>'088989694349'],
            ['closed_date'=>'21/04/25','student_id'=>'1202230008','service'=>'Pengajuan Surat Keterangan Aktif Mahasiswa', 'content'=>'surat keterangan ', 'ticket_num'=> '12000393', 'phone'=>'082188467793'],
            ['closed_date'=>'31/01/25','student_id'=>'1204220058','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'Proposal Pengajuan Dana ; Kegiatan Upgrading Staf Resmi Himpunan Mahasiswa Sistem Informasi Periode 2024/2025GSM', 'ticket_num'=> '12000063', 'phone'=>'085155156382'],
            ['closed_date'=>'31/01/25','student_id'=>'1206230024','service'=>'Paket Peminjaman', 'content'=>'Kode : 790
            Tgl pengajuan : 31 Januari 2025
            Nama Peminjam : Jonatan S.
            No HP : 087728035643
            Waktu Peminjaman : 28 Februari 2025 (18.00-20.00)
            Oleh : Hima Sains Data
            Untuk : Rapat Panitia AFTER PARTY : ORIENTASI DS 2025
            List yang dipinjam :
            - Paket Kelas 1
             ', 'ticket_num'=> '12000064', 'phone'=>'087728035643'],
            ['closed_date'=>'31/01/25','student_id'=>'1206230024','service'=>'Paket Peminjaman', 'content'=>'Kode : 791
            Tgl pengajuan : 31 Januari 2025
            Nama Peminjam : Jonatan S.
            No HP : 087728035643
            Waktu Peminjaman : 5 - 6 April 2025 (10.00-17.00)
            Oleh : Hima Sains Data
            Untuk : Latihan Pensi AFTER PARTY : ORIENTASI DS 2025
            List yang dipinjam :
            - Paket Kelas 3 (Kelas Bersekat & Reguler)
            - Paket Listrik 1', 'ticket_num'=> '12000065', 'phone'=>'087728035643'],
            ['closed_date'=>'31/01/25','student_id'=>'1206230024','service'=>'Paket Peminjaman', 'content'=>'Kode : 792
            Tgl pengajuan : 31 Januari 2025
            Nama Peminjam : Jonatan S.
            No HP : 087728035643
            Waktu Peminjaman : 7 - 11 April 2025 (18.00-20.00)
            Oleh : Hima Sains Data
            Untuk : Latihan Pensi AFTER PARTY : ORIENTASI DS 2025
            List yang dipinjam :
            - Paket Kelas 3 (Kelas Bersekat & Reguler)
            - Paket Listrik 1', 'ticket_num'=> '12000066', 'phone'=>'087728035643'],
            ['closed_date'=>'31/01/25','student_id'=>'1206230024','service'=>'Paket Peminjaman', 'content'=>'Kode : 793
            Tgl pengajuan : 31 Januari 2025
            Nama Peminjam : Jonatan S.
            No HP : 087728035643
            Waktu Peminjaman : 12 - 13 April 2025 (10.00-17.00)
            Oleh : Hima Sains Data
            Untuk : Latihan Pensi AFTER PARTY : ORIENTASI DS 2025
            List yang dipinjam :
            - Paket Kelas 3 (Kelas Bersekat & Reguler)
            - Paket Listrik 1', 'ticket_num'=> '12000067', 'phone'=>'087728035643'],
            ['closed_date'=>'31/01/25','student_id'=>'1206230024','service'=>'Paket Peminjaman', 'content'=>'Kode : 794
            Tgl pengajuan : 31 Januari 2025
            Nama Peminjam : Jonatan S.
            No HP : 087728035643
            Waktu Peminjaman : 14 - 15 April 2025 (18.00-20.00)
            Oleh : Hima Sains Data
            Untuk : Latihan Pensi AFTER PARTY : ORIENTASI DS 2025
            List yang dipinjam :
            - Paket Kelas 3 (Kelas Bersekat & Reguler)
            - Paket Listrik 1', 'ticket_num'=> '12000068', 'phone'=>'087728035643'],
            ['closed_date'=>'31/01/25','student_id'=>'1206230024','service'=>'Paket Peminjaman', 'content'=>'Kode : 795
            Tgl pengajuan : 31 Januari 2025
            Nama Peminjam : Jonatan S.
            No HP : 087728035643
            Waktu Peminjaman : 18 - 19 April 2025 (07.00-22.00)
            Oleh : Hima Sains Data
            Untuk : AFTER PARTY : ORIENTASI DS 2025
            List yang dipinjam :
            - Paket Kelas 2 (Kelas Bersebelahan)
            - Paket Listrik 2
            - Paket Aula 1
            - Paket Audio Portable 1
            - Paket Visual 2
            - Paket Komunikasi 2
            - Paket Musyawarah 1
            - TOA 1
            - Lapangan Hybrid 
            - Lapangan Utama ', 'ticket_num'=> '12000069', 'phone'=>'087728035643'],
            ['closed_date'=>'31/01/25','student_id'=>'1204220100','service'=>'Paket Peminjaman', 'content'=>'Kode : 796
            Tgl pengajuan : 31 Januari 2025
            Nama Peminjam : Zaza Syach Zayyaan
            No HP : 085174366076
            Waktu Peminjaman : 8-9 Februari 2025 (07.00 - 18.00)
            Oleh : HMSI
            Untuk : Upgrading Staf HMSI 
            List yang dipinjam :
            - Paket kelas 4 ( Request 2 ruangan bersekat )
            - Paket Audio Portabel 1 ', 'ticket_num'=> '12000070', 'phone'=>'085174366076'],
            ['closed_date'=>'31/01/25','student_id'=>'1201230034','service'=>'Pengajuan Cuti', 'content'=>'Pengajuan cuti semester genap (Semester 4)', 'ticket_num'=> '12000071', 'phone'=>'082142387119'],
            ['closed_date'=>'03/02/25','student_id'=>'1103238046','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab untuk kegiatan Riset BMS (Battery Management Ststem) pada Senin s.d Jumat, tanggal 30 Januari - 28 Februari 2025 ', 'ticket_num'=> '12000072', 'phone'=>'081246182313'],
            ['closed_date'=>'21/04/25','student_id'=>'1203220161','service'=>'Pengajuan Surat Keterangan Aktif Mahasiswa', 'content'=>'surat keterangan ', 'ticket_num'=> '12000395', 'phone'=>'082331163077'],
            ['closed_date'=>'03/02/25','student_id'=>'101092400006','service'=>'Paket Peminjaman', 'content'=>'Kode : 797
            Tgl pengajuan : 3 Februari 2025
            Nama Peminjam : Muhammad Sidiq
            No HP : 082198701827
            Waktu Peminjaman : 20 Februari 2025 (08.00 - 22.00)
            Oleh : IMS
            Untuk : Sertijab Pengurus IMS 
            List yang dipinjam :
            - Paket aula
            - paket duduk 
            - paket musyawarah 
            - paket komunikasi ', 'ticket_num'=> '12000074', 'phone'=>'082198701827'],
            ['closed_date'=>'03/02/25','student_id'=>'1103230026','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab. Power dan Electronics untuk kegiatan Rapat Fiksasi Sertijab dan FHME oleh Himpunan Mahasiswa Elektro pada 08 Februari 2025 (07.00-20.00)', 'ticket_num'=> '12000075', 'phone'=>'082238102557'],
            ['closed_date'=>'21/04/25','student_id'=>'1206230036','service'=>'Pengajuan Surat Keterangan Aktif Mahasiswa', 'content'=>'surat keterangan ', 'ticket_num'=> '12000396', 'phone'=>'085806273971'],
            ['closed_date'=>'03/02/25','student_id'=>'1201210509','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab. Machine Learning untuk Pengerjaan Tugas Akhir pada 10 Februari 2025 s/d 29 Juni 2025 (07.00-18.00)', 'ticket_num'=> '12000077', 'phone'=>'081234550074'],
            ['closed_date'=>'22/04/25','student_id'=>'1202230030','service'=>'Pengajuan Surat Keterangan Aktif Mahasiswa', 'content'=>'surat keterangan ', 'ticket_num'=> '12000404', 'phone'=>'085234754442'],
            ['closed_date'=>'04/02/25','student_id'=>'1103230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 798
            Tgl pengajuan : 4 Februari 2025
            Nama Peminjam : Mario Prince Parhusip
            No HP : 082229559857
            Waktu Peminjaman : 14 Februari 2025 (16.00 - 20.00)
            Oleh : Teknik Elektro
            Untuk : GR kegiatan Open Recruitment Keluarga Mahasiswa Sumatera  
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000079', 'phone'=>'082229559857'],
            ['closed_date'=>'04/02/25','student_id'=>'1102230002','service'=>'Paket Peminjaman', 'content'=>'Kode : 799
            Tgl pengajuan : 4 Februari 2025
            Nama Peminjam : Mario Prince Parhusip
            No HP : 082229559857
            Waktu Peminjaman : 14 Februari 2025 (16.00 - 20.00)
            Oleh : Teknik Elektro
            Untuk : GR kegiatan Open Recruitment Keluarga Mahasiswa Sumatera  
            List yang dipinjam :
            - Paket Kelas 2 ( Request ruangan bersekat )
            - Paket Audio Portable 1
            ', 'ticket_num'=> '12000080', 'phone'=>'085334985855'],
            ['closed_date'=>'22/04/25','student_id'=>'1202230035','service'=>'Pengajuan Surat Keterangan Aktif Mahasiswa', 'content'=>'surat keterangan', 'ticket_num'=> '12000402', 'phone'=>'081459125873'],
            ['closed_date'=>'08/01/25','student_id'=>'1202200411','service'=>'Pengajuan SK Tugas Akhir', 'content'=>'perpanjangan SKTA', 'ticket_num'=> '12000011', 'phone'=>'082124626986'],
            ['closed_date'=>'04/02/25','student_id'=>'1204210041','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab. Pemodelan Dan Komputasi Terapan untuk kegiatan Belajar Mandiri oleh Mahasiswa Sistem Informasi pada 09 Februari s/d 28 februari 2025. Pada hari Senin s/d Jumat 10.00-22.00 dan Sabtu s.d Minggu ', 'ticket_num'=> '12000083', 'phone'=>'085161907133'],
            ['closed_date'=>'03/02/25','student_id'=>'1203200001','service'=>'Legalisir KHS Mahasiswa', 'content'=>'Permintaan legalisir KHS untuk keperluan beasiswa', 'ticket_num'=> '12000073', 'phone'=>'089612723218'],
            ['closed_date'=>'23/01/25','student_id'=>'1204230063','service'=>'Legalisir KHS Mahasiswa', 'content'=>'Permintaan Legalisir KHS', 'ticket_num'=> '12000051', 'phone'=>'085708466400'],
            ['closed_date'=>'04/02/25','student_id'=>'1105230006','service'=>'Paket Peminjaman', 'content'=>'Kode : 800
            Tgl pengajuan :  4 Februari 2025
            Nama Peminjam : Rengganis Puspa G.
            No HP : 082175136249
            Waktu Peminjaman : 15 Februari 2025 (07.00-16.00)
            Oleh : Telkom Art
            Untuk : Photoshoot Pengurus Baru
            List yang dipinjam :
            - Studio lt 4', 'ticket_num'=> '12000086', 'phone'=>'082175136249'],
            ['closed_date'=>'05/02/25','student_id'=>'103072400118','service'=>'Pengajuan Cuti', 'content'=>'Pengajuan cuti semester genap', 'ticket_num'=> '12000087', 'phone'=>'081239725520'],
            ['closed_date'=>'05/02/25','student_id'=>'1204220101','service'=>'Legalisir KHS Mahasiswa', 'content'=>'Legalisir untuk beasiswa', 'ticket_num'=> '12000088', 'phone'=>'085754913563'],
            ['closed_date'=>'06/02/25','student_id'=>'1206230042','service'=>'Paket Peminjaman', 'content'=>'Kode : 801
            Tgl pengajuan :  6 Februari 2025
            Nama Peminjam : Ardini Aprilya P.
            No HP : 081330812931
            Waktu Peminjaman : 15 Februari - 16 Februari 2025 (06.30-16.00)
            Oleh : Telkom Art
            Untuk : Photoshoot dan Technical Meeting UKM Telkm Art
            List yang dipinjam :
            - Paket kelas 1 ', 'ticket_num'=> '12000089', 'phone'=>'081330812931'],
            ['closed_date'=>'06/02/25','student_id'=>'1201220003','service'=>'Paket Peminjaman', 'content'=>'Kode : 802
            Tgl pengajuan :  6 Februari 2025
            Nama Peminjam : Zidan Irfan Zaky
            No HP : 088989694349
            Waktu Peminjaman : 22 Februari 2025 (08.00-22.00)
            Oleh : UKM E-Sport
            Untuk : Tel-U SBY Selection League
            List yang dipinjam :
            - Paket kelas 2
            - Paket Visual 2
            - Paket Listrik 2', 'ticket_num'=> '12000090', 'phone'=>'088989694349'],
            ['closed_date'=>'06/02/25','student_id'=>'1202220432','service'=>'Paket Peminjaman', 'content'=>'Kode : 803
            Tgl pengajuan :  6 Februari 2025
            Nama Peminjam : Liobaldo Danielo A.
            No HP : 082144761443
            Waktu Peminjaman : 
            Oleh : UKM IM NTT
            Untuk : 
            List yang dipinjam :
            - Paket kelas 3', 'ticket_num'=> '12000091', 'phone'=>'082144761443'],
            ['closed_date'=>'06/02/25','student_id'=>'1202220432','service'=>'Paket Peminjaman', 'content'=>'Kode : 804
            Tgl pengajuan :  6 Februari 2025
            Nama Peminjam : Liobaldo Danielo A.
            No HP : 082144761443
            Waktu Peminjaman : 24 Februari 2025 (7.30 -22.00)
            Oleh : UKM IM NTT
            Untuk : Mubes UKM IM NTT
            List yang dipinjam :
            - Paket kelas 2 (ruang kelas bersekat yang bisa digabung)', 'ticket_num'=> '12000092', 'phone'=>'082144761443'],
            ['closed_date'=>'06/02/25','student_id'=>'1103230026','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab. Power dan Electronics untuk kegiatan Rapat Fiksasi Sertijab dan FHME oleh Himpunan Mahasiswa Elektro pada 08 Februari 2025 (07.00-20.00)', 'ticket_num'=> '12000093', 'phone'=>'082238102557'],
            ['closed_date'=>'06/02/25','student_id'=>'1201210511','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'From Permohonan aktif kuliah ', 'ticket_num'=> '12000094', 'phone'=>'081233421064'],
            ['closed_date'=>'07/02/25','student_id'=>'1201200001','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'Surat keterangan bebas peminjaman alat lab untuk yudisium', 'ticket_num'=> '12000095', 'phone'=>'082132630452'],
            ['closed_date'=>'07/02/25','student_id'=>'1104230031','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'Form permohonan aktif ', 'ticket_num'=> '12000096', 'phone'=>'085235855656'],
            ['closed_date'=>'07/02/25','student_id'=>'1103230016','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'Proposal HME - Sertijab HME dan FHME 2025', 'ticket_num'=> '12000097', 'phone'=>'085607368693'],
            ['closed_date'=>'10/02/25','student_id'=>'1101220020','service'=>'Paket Peminjaman', 'content'=>'Kode : 805
            Tgl pengajuan :  7 Februari 2025
            Nama Peminjam : Naufal Aditya N. 
            No HP : 085343979965
            Waktu Peminjaman : 15 Februari 2025 (07.00 - 18.00)
            Oleh : HIMA TESLA
            Untuk : Rapat Kerja Awal Periode
            List yang dipinjam :
            - Paket kelas 2 (Request Connecting Room)
            - Paket Audio Portable 1
            - Paket Musyawarah 1', 'ticket_num'=> '12000098', 'phone'=>'085343979965'],
            ['closed_date'=>'10/02/25','student_id'=>'1204200077','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a.n chafidz dan hasan ', 'ticket_num'=> '12000100', 'phone'=>'081216715353'],
            ['closed_date'=>'10/02/25','student_id'=>'1205210081','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000101', 'phone'=>'081217337750'],
            ['closed_date'=>'10/02/25','student_id'=>'1204210020','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000102', 'phone'=>'081216447055'],
            ['closed_date'=>'10/02/25','student_id'=>'1101210002','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a.n Vian,Regina,First', 'ticket_num'=> '12000103', 'phone'=>'082231429452'],
            ['closed_date'=>'10/02/25','student_id'=>'1201202040','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000104', 'phone'=>'089529456271'],
            ['closed_date'=>'10/02/25','student_id'=>'1204200160','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan, rivaldo dan prasastio giri ', 'ticket_num'=> '12000105', 'phone'=>'081332888588'],
            ['closed_date'=>'10/02/25','student_id'=>'1101212015','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a.n Wildan, Elsa, Haidar, Wafiqoh, Erwin, Wahyu, Hidayat', 'ticket_num'=> '12000106', 'phone'=>'085174150422'],
            ['closed_date'=>'10/02/25','student_id'=>'1205210024','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000107', 'phone'=>'081338636615'],
            ['closed_date'=>'10/02/25','student_id'=>'1205210007','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a.d RA mentari dan Nada ', 'ticket_num'=> '12000108', 'phone'=>'087852691214'],
            ['closed_date'=>'10/02/25','student_id'=>'103072430009','service'=>'Pengajuan Undur Diri', 'content'=>'Pengajuan Undur Diri ', 'ticket_num'=> '12000109', 'phone'=>'081233962278'],
            ['closed_date'=>'10/02/25','student_id'=>'1204210001','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'bebas keuangan putri dan adzro ', 'ticket_num'=> '12000110', 'phone'=>'082196951985'],
            ['closed_date'=>'10/02/25','student_id'=>'1201230001','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab. Machine Learning untuk kegiatan Pelatihan Umum yang diselenggarakan oleh Himpunan Mahasiswa Software Engineering Telkom University Suerabaya pada 21 Februari 2025 - 24 Februari 2025  (06.00-22.00)', 'ticket_num'=> '12000111', 'phone'=>'08973809698'],
            ['closed_date'=>'10/02/25','student_id'=>'1202230003','service'=>'Paket Peminjaman', 'content'=>'Kode : 809
            Tgl pengajuan :  10 Februari 2025
            Nama Peminjam : Kevin Imanuel S.
            No HP : 082236039191
            Waktu Peminjaman : 19 Februari 2025 (18.00 - 22.00)
            Oleh : UKKK
            Untuk : Rapat panitia Ibadah Perayaan Paskah UK3 2025
            List yang dipinjam :
            - Paket kelas 1

            ', 'ticket_num'=> '12000113', 'phone'=>'082236039191'],
            ['closed_date'=>'10/02/25','student_id'=>'1101210026','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'bebas  keuangan ', 'ticket_num'=> '12000114', 'phone'=>'082132205421'],
            ['closed_date'=>'10/02/25','student_id'=>'1101212005','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a.n Moh. Anas dan Athallah', 'ticket_num'=> '12000115', 'phone'=>'089696039944'],
            ['closed_date'=>'10/02/25','student_id'=>'1103210268','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'bebas  keuangan ', 'ticket_num'=> '12000116', 'phone'=>'085784787376'],
            ['closed_date'=>'10/02/25','student_id'=>'1202230003','service'=>'Paket Peminjaman', 'content'=>'Kode : 806
            Tgl pengajuan :  10 Februari 2025
            Nama Peminjam : Kevin Imanuel S.
            No HP : 082236039191
            Waktu Peminjaman : 22 April - 23 April 2025 (06.00 - 22.00)
            Oleh : UKKK
            Untuk : Ibadah Perayaan Paskah UK3 2025
            List yang dipinjam :
            - Paket Aula 1
            - Paket Visual 1
            - Paket Listrik 1
            - paket Duduk 3

            ', 'ticket_num'=> '12000117', 'phone'=>'082236039191'],
            ['closed_date'=>'10/02/25','student_id'=>'1204210101','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000118', 'phone'=>'085336346964'],
            ['closed_date'=>'10/02/25','student_id'=>'1101212034','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keungan Alifvian, Bima Pancara, Qaanitah Salwa, Arya Prayoga, Inta Anggreita', 'ticket_num'=> '12000119', 'phone'=>'085785095924'],
            ['closed_date'=>'10/02/25','student_id'=>'1204210015','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'Surat bebas keuangan Taufikurahman, Rendy Adi, Irsyad Rahmadhani, Anggi Aulia, Novi Monica, Moh. Fahri, Ansar Nur, Rhido Rahmattulloh,', 'ticket_num'=> '12000120', 'phone'=>'082139930263'],
            ['closed_date'=>'10/02/25','student_id'=>'1101212018','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keungan', 'ticket_num'=> '12000121', 'phone'=>'083849948276'],
            ['closed_date'=>'10/02/25','student_id'=>'1101210009','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keungan atas nama Rifka & Nadiva', 'ticket_num'=> '12000122', 'phone'=>'085704020438'],
            ['closed_date'=>'10/02/25','student_id'=>'1104220162','service'=>'Paket Peminjaman', 'content'=>'Kode : 807
            Tgl pengajuan :  10 Februari 2025
            Nama Peminjam : Muhammad Ubaidillah D. U.  
            No HP : 081249097499
            Waktu Peminjaman : 28 Februari 2025 (10.00 - 16.00)
            Oleh : HMTI
            Untuk : Workshop KTI
            List yang dipinjam :
            - Paket Aula 1
            - Paket Listrik 1
            - Paket Musyawarah 1
            - Paket HDMI 1
            - Paket Duduk 2
            - Paket Komunikasi 1
            - Paket Visual 1', 'ticket_num'=> '12000123', 'phone'=>'081249097499'],
            ['closed_date'=>'10/02/25','student_id'=>'1103210013','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000124', 'phone'=>'085655955968'],
            ['closed_date'=>'10/02/25','student_id'=>'1205230014','service'=>'Paket Peminjaman', 'content'=>'Kode : 808
            Tgl pengajuan :  10 Februari 2025
            Nama Peminjam : Gracela Sri Monita
            No HP : 082286635140
            Waktu Peminjaman : 22 Februari 2025 (11.00 - 16.00)
            Oleh : Keluarga Mahasiswa Sumatera
            Untuk : Wawancara pengurus baru KMS
            List yang dipinjam :
            - Paket Kelas (Request ruangan bersekat)

            ', 'ticket_num'=> '12000125', 'phone'=>'082286635140'],
            ['closed_date'=>'10/02/25','student_id'=>'1103210003','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000126', 'phone'=>'089521761815'],
            ['closed_date'=>'10/02/25','student_id'=>'1205210031','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a/n Rizki Putra, Maulana Naufal', 'ticket_num'=> '12000127', 'phone'=>'081238951489'],
            ['closed_date'=>'10/02/25','student_id'=>'1203210136','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan Tita, Qori, Zafir', 'ticket_num'=> '12000128', 'phone'=>'081234853900'],
            ['closed_date'=>'10/02/25','student_id'=>'1205210035','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a/n Valencia, Tracy, Jenny Ghifrina, Jingga, Vagnes', 'ticket_num'=> '12000129', 'phone'=>'082233379945'],
            ['closed_date'=>'10/02/25','student_id'=>'1202202085','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'Form permohonan aktif', 'ticket_num'=> '12000130', 'phone'=>'081216132926'],
            ['closed_date'=>'10/02/25','student_id'=>'1101210526','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan ', 'ticket_num'=> '12000131', 'phone'=>'085216114587'],
            ['closed_date'=>'10/02/25','student_id'=>'1203200085','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a/n Hanif, Shabiya', 'ticket_num'=> '12000132', 'phone'=>'081935366677'],
            ['closed_date'=>'10/02/25','student_id'=>'1101210526','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a/n Rizky & Gabriel', 'ticket_num'=> '12000133', 'phone'=>'082132100540'],
            ['closed_date'=>'10/02/25','student_id'=>'1101210527','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a/n Gempar & Mujahidin', 'ticket_num'=> '12000134', 'phone'=>'082359593830'],
            ['closed_date'=>'24/02/25','student_id'=>'1105220004','service'=>'Pengajuan Undur Diri', 'content'=>'pengajuan undur diri ', 'ticket_num'=> '12000270', 'phone'=>'0882009667333'],
            ['closed_date'=>'17/01/25','student_id'=>'1205210023','service'=>'Pengajuan Undur Diri', 'content'=>'Pengajuan Undur Diri', 'ticket_num'=> '12000035', 'phone'=>'08113422118'],
            ['closed_date'=>'10/02/25','student_id'=>'1204200089','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan ', 'ticket_num'=> '12000137', 'phone'=>'085230347763'],
            ['closed_date'=>'10/02/25','student_id'=>'1205210002','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a/n Cita & Nabila', 'ticket_num'=> '12000138', 'phone'=>'085791285203'],
            ['closed_date'=>'10/02/25','student_id'=>'1104210026','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000139', 'phone'=>'082335742130'],
            ['closed_date'=>'10/02/25','student_id'=>'1103210274','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a.n raihan dan ramsa', 'ticket_num'=> '12000140', 'phone'=>'081230474171'],
            ['closed_date'=>'11/02/25','student_id'=>'1204200226','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan Rizky', 'ticket_num'=> '12000142', 'phone'=>'085106154500'],
            ['closed_date'=>'11/02/25','student_id'=>'1102210329','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas pinjam lab untuk yudisium', 'ticket_num'=> '12000143', 'phone'=>'082359593830'],
            ['closed_date'=>'11/02/25','student_id'=>'1104210015','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan Pinkkan', 'ticket_num'=> '12000144', 'phone'=>'085850426563'],
            ['closed_date'=>'11/02/25','student_id'=>'1101200056','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan sawung, Alfian, Opal', 'ticket_num'=> '12000145', 'phone'=>'081234619760'],
            ['closed_date'=>'11/02/25','student_id'=>'1205210061','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan Reinazhar', 'ticket_num'=> '12000146', 'phone'=>'081217963640'],
            ['closed_date'=>'11/02/25','student_id'=>'1103210277','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000148', 'phone'=>'081391291145'],
            ['closed_date'=>'11/02/25','student_id'=>'1102210008','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a/n Firman Ahmad, Faiz Amsyari', 'ticket_num'=> '12000149', 'phone'=>'082331726665'],
            ['closed_date'=>'11/02/25','student_id'=>'1103210272','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000150', 'phone'=>'0895703320405'],
            ['closed_date'=>'11/02/25','student_id'=>'1102202021','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a/n Ari Musawa, Risyad Maulana', 'ticket_num'=> '12000151', 'phone'=>'085236782566'],
            ['closed_date'=>'11/02/25','student_id'=>'1203210114','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a/n Ryu, Dharma, Feiticeira', 'ticket_num'=> '12000152', 'phone'=>'082112065957'],
            ['closed_date'=>'11/02/25','student_id'=>'1103200035','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a/n Aulia Maharani, Rifansyah Fitrah', 'ticket_num'=> '12000153', 'phone'=>'082293918022'],
            ['closed_date'=>'11/02/25','student_id'=>'1101210529','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000154', 'phone'=>'083151860790'],
            ['closed_date'=>'11/02/25','student_id'=>'1204200091','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a/n Salma, Nabila, Rizky', 'ticket_num'=> '12000155', 'phone'=>'089628832732'],
            ['closed_date'=>'11/02/25','student_id'=>'1203200004','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan a/n Amarrangga, Nur Afifah, Donita Desi', 'ticket_num'=> '12000156', 'phone'=>'081233310531'],
            ['closed_date'=>'11/02/25','student_id'=>'1203200045','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000157', 'phone'=>'082223445115'],
            ['closed_date'=>'11/02/25','student_id'=>'1204200051','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000158', 'phone'=>'088216918086'],
            ['closed_date'=>'11/02/25','student_id'=>'1104210026','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas pinjam lab untuk yudisium', 'ticket_num'=> '12000159', 'phone'=>'082335742130'],
            ['closed_date'=>'11/02/25','student_id'=>'1102210012','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan Haykal', 'ticket_num'=> '12000160', 'phone'=>'081216378107'],
            ['closed_date'=>'11/02/25','student_id'=>'1102210012','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas pinjam lab Faiz, Mujahidin,Haykal,Firman', 'ticket_num'=> '12000161', 'phone'=>'081216378107'],
            ['closed_date'=>'11/02/25','student_id'=>'1203210094','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan ', 'ticket_num'=> '12000163', 'phone'=>'0881036519619'],
            ['closed_date'=>'11/02/25','student_id'=>'1104210051','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan ', 'ticket_num'=> '12000164', 'phone'=>'089629904453'],
            ['closed_date'=>'12/02/25','student_id'=>'1204238084','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000165', 'phone'=>'087794017565'],
            ['closed_date'=>'12/02/25','student_id'=>'1204210120','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas pinjam lab, Novita Simanjurtak', 'ticket_num'=> '12000166', 'phone'=>'085664055614'],
            ['closed_date'=>'12/02/25','student_id'=>'1204210015','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab A/N Taufik dan Rendy ', 'ticket_num'=> '12000167', 'phone'=>'082139930263'],
            ['closed_date'=>'12/02/25','student_id'=>'1101210033','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan A/N Bintang dan Bramantya ', 'ticket_num'=> '12000168', 'phone'=>'085235712192'],
            ['closed_date'=>'12/02/25','student_id'=>'1204200123','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab A/N Prasastio dan Ahmad Hasan ', 'ticket_num'=> '12000169', 'phone'=>'081332888588'],
            ['closed_date'=>'12/02/25','student_id'=>'1102210331','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab A/N Mujahidin,Risyad, Ari', 'ticket_num'=> '12000170', 'phone'=>'081553833599'],
            ['closed_date'=>'12/02/25','student_id'=>'1203200047','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan ', 'ticket_num'=> '12000171', 'phone'=>'081235851307'],
            ['closed_date'=>'12/02/25','student_id'=>'1205210031','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab', 'ticket_num'=> '12000172', 'phone'=>'081238951489'],
            ['closed_date'=>'12/02/25','student_id'=>'1204210002','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'bebas lab a.n anggi dan hafida', 'ticket_num'=> '12000173', 'phone'=>'085732206455'],
            ['closed_date'=>'12/02/25','student_id'=>'1204210001','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'bebas lab A/N Putri dan Adzro', 'ticket_num'=> '12000174', 'phone'=>'082196951985'],
            ['closed_date'=>'12/02/25','student_id'=>'1104210015','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'bebas lab pinkkan ', 'ticket_num'=> '12000175', 'phone'=>'085850426563'],
            ['closed_date'=>'12/02/25','student_id'=>'1204200089','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'bebas lab ', 'ticket_num'=> '12000176', 'phone'=>'085230347763'],
            ['closed_date'=>'12/02/25','student_id'=>'1205210030','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan ', 'ticket_num'=> '12000177', 'phone'=>'081332944298'],
            ['closed_date'=>'12/02/25','student_id'=>'1203200067','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan ', 'ticket_num'=> '12000178', 'phone'=>'083114158272'],
            ['closed_date'=>'12/02/25','student_id'=>'1204210103','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab ', 'ticket_num'=> '12000180', 'phone'=>'082136736166'],
            ['closed_date'=>'12/02/25','student_id'=>'1102210002','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab ', 'ticket_num'=> '12000181', 'phone'=>'081252323420'],
            ['closed_date'=>'12/02/25','student_id'=>'1203200045','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab  a.n Syahril dan haidar', 'ticket_num'=> '12000182', 'phone'=>'082223445115'],
            ['closed_date'=>'12/02/25','student_id'=>'1203200067','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000183', 'phone'=>'083114158272'],
            ['closed_date'=>'12/02/25','student_id'=>'1101200567','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000184', 'phone'=>'081329229833'],
            ['closed_date'=>'12/02/25','student_id'=>'1203200047','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab', 'ticket_num'=> '12000185', 'phone'=>'081235851307'],
            ['closed_date'=>'12/02/25','student_id'=>'1103210268','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab', 'ticket_num'=> '12000186', 'phone'=>'085784787376'],
            ['closed_date'=>'12/02/25','student_id'=>'1203200097','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab  a.n Shabiya dan hanif', 'ticket_num'=> '12000187', 'phone'=>'089520220231'],
            ['closed_date'=>'12/02/25','student_id'=>'1205210082','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab', 'ticket_num'=> '12000188', 'phone'=>'082228928133'],
            ['closed_date'=>'12/02/25','student_id'=>'1205210028','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab', 'ticket_num'=> '12000189', 'phone'=>'082228280252'],
            ['closed_date'=>'12/02/25','student_id'=>'1101212040','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000190', 'phone'=>'089677815759'],
            ['closed_date'=>'12/02/25','student_id'=>'1101210006','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab', 'ticket_num'=> '12000191', 'phone'=>'083137078841'],
            ['closed_date'=>'12/02/25','student_id'=>'1201200001','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab', 'ticket_num'=> '12000192', 'phone'=>'082132630452'],
            ['closed_date'=>'12/02/25','student_id'=>'1103202036','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000193', 'phone'=>'082245180698'],
            ['closed_date'=>'12/02/25','student_id'=>'1204210107','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab', 'ticket_num'=> '12000194', 'phone'=>'081808882819'],
            ['closed_date'=>'12/02/25','student_id'=>'1101210023','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab', 'ticket_num'=> '12000195', 'phone'=>'085856631986'],
            ['closed_date'=>'12/02/25','student_id'=>'1102203010','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'surat bebas lab', 'ticket_num'=> '12000196', 'phone'=>'085158299310'],
            ['closed_date'=>'12/02/25','student_id'=>'1102203010','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'surat bebas keuangan', 'ticket_num'=> '12000197', 'phone'=>'085158299310'],
            ['closed_date'=>'12/02/25','student_id'=>'1203210094','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'bebas lab yudha dan dharma ', 'ticket_num'=> '12000199', 'phone'=>'0881036519619'],
            ['closed_date'=>'12/02/25','student_id'=>'1103238029','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'bebas keuangan Alifio N.', 'ticket_num'=> '12000200', 'phone'=>'081224724142'],
            ['closed_date'=>'12/02/25','student_id'=>'1103238030','service'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri', 'content'=>'bebas LAB Alifio N. ', 'ticket_num'=> '12000201', 'phone'=>'081224724142'],
            ['closed_date'=>'12/02/25','student_id'=>'1205230041','service'=>'Paket Peminjaman', 'content'=>'Kode : 810
            Tgl pengajuan : 13 Februari 2025
            Nama Peminjam : Salsa Bila Aura Gading
            No HP : 081216750287
            Waktu Peminjaman : 22 Februari 2025 (09.00-17.00)
            Oleh : Komunitas paskibra tel-U Sby
            Untuk : Open recruitment Anggota Paskibra
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000202', 'phone'=>'081216750287'],
            ['closed_date'=>'12/02/25','student_id'=>'1203210021','service'=>'Legalisir KHS Mahasiswa', 'content'=>'khs legalisisr', 'ticket_num'=> '12000203', 'phone'=>'087854722378'],
            ['closed_date'=>'11/02/25','student_id'=>'1103230009','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'Proposal HME - Kegiatan sertijab HME dan FHME 2025', 'ticket_num'=> '12000204', 'phone'=>'085668068219'],
            ['closed_date'=>'14/02/25','student_id'=>'1203210144','service'=>'Legalisir KHS Mahasiswa', 'content'=>'KHS LEGALISIR ', 'ticket_num'=> '12000205', 'phone'=>'0895803109571'],
            ['closed_date'=>'17/02/25','student_id'=>'1201220003','service'=>'Paket Peminjaman', 'content'=>'Kode : 811
            Tgl pengajuan : 17 Februari 2025
            Nama Peminjam : Zidan Irfan Z.
            No HP : 088989694349
            Waktu Peminjaman : 26 April 2025 (09.00-21.00)
            Oleh : E-Sports
            Untuk : TSE X DEWA WATCHPARTY
            List yang dipinjam :
            - Paket Aula 1
            - Paket Visual 2 
            - Paket Duduk 8 
            - Paket HDMI 1
            - Paket Lighting 1 
            - Paket Streaming 1 
            - Paket Komunikasi 1 
            - Paket Listrik 4 ', 'ticket_num'=> '12000207', 'phone'=>'088989694349'],
            ['closed_date'=>'17/02/25','student_id'=>'1204220073','service'=>'Paket Peminjaman', 'content'=>'Kode : 812
            Tgl pengajuan : 17 Februari 2025
            Nama Peminjam : Cheasario Y. O
            No HP : 081386005934
            Waktu Peminjaman : 28 Februari 2025 (11.00 - 13.00)
            Oleh : UKKK
            Untuk : Rapat Pleno Pengurus UKKK Telkom University Surabaya
            List yang dipinjam :
            - Paket kelas 1', 'ticket_num'=> '12000209', 'phone'=>'081386005934'],
            ['closed_date'=>'17/02/25','student_id'=>'1204220073','service'=>'Paket Peminjaman', 'content'=>'Kode : 813
            Tgl pengajuan : 17 Februari 2025
            Nama Peminjam : Cheasario Y. O
            No HP : 081386005934
            Waktu Peminjaman : 7 Maret 2025 (11.00 - 13.00)
            Oleh : UKKK
            Untuk : Pendalaman Alkitab UKKK Telkm university Surabaya
            List yang dipinjam :
            - Paket kelas 1', 'ticket_num'=> '12000210', 'phone'=>'081386005934'],
            ['closed_date'=>'17/02/25','student_id'=>'1204220073','service'=>'Paket Peminjaman', 'content'=>'Kode : 814
            Tgl pengajuan : 17 Februari 2025
            Nama Peminjam : Cheasario Y. O
            No HP : 081386005934
            Waktu Peminjaman : 14 Maret 2025 (11.00 - 13.00)
            Oleh : UKKK
            Untuk : Persekutuan Doa Rutin UKKK Telkom University Surabaya
            List yang dipinjam :
            - Paket kelas sekat / gabung 2
            - Paket Audio Portable 1', 'ticket_num'=> '12000211', 'phone'=>'081386005934'],
            ['closed_date'=>'17/02/25','student_id'=>'1204220073','service'=>'Paket Peminjaman', 'content'=>'Kode : 815
            Tgl pengajuan : 17 Februari 2025
            Nama Peminjam : Cheasario Y. O
            No HP : 081386005934
            Waktu Peminjaman : 21 Maret 2025 (11.00 - 13.00)
            Oleh : UKKK
            Untuk : Persekutuan Doa Rutin UKKK Telkom University Surabaya
            List yang dipinjam :
            - Paket kelas sekat / gabung 2
            - Paket Audio Portable 1', 'ticket_num'=> '12000212', 'phone'=>'081386005934'],
            ['closed_date'=>'17/02/25','student_id'=>'1205230016','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab Digital Star Up (1.29) untuk kegiatan Rapat Himpunan Mahasiswa Bisnis Digital 2024, pada tanggal 19 Februari 2025 Rabu (18.30 - 21.00)', 'ticket_num'=> '12000213', 'phone'=>'08111987203'],
            ['closed_date'=>'17/02/25','student_id'=>'1102220308','service'=>'Paket Peminjaman', 'content'=>'Kode : 816
            Tgl pengajuan : 17 Februari 2025
            Nama Peminjam : Finza Fianandra
            No HP : 083123190643
            Waktu Peminjaman : 16 - 17 April 2025 (07.00 - 22.00)
            Oleh : Himpunan Mahasiswa Teknik Komputer Kegiatan : Halal Bihalal
            List yang dipinjam :
            - Paket Aula 1', 'ticket_num'=> '12000214', 'phone'=>'083123190643'],
            ['closed_date'=>'17/02/25','student_id'=>'1206210014','service'=>'Paket Peminjaman', 'content'=>'Kode : 817
            Tgl pengajuan : 17 Februari 2025
            Nama Peminjam :Ryanta Meylinda S.
            No HP :085236000637
            Waktu Peminjaman : 16 April 2025 (07.00 - 22.00)
            Oleh : UKM Badminton TUS 
            Kegiatan : Technical Meeting TUSBC Master 2025
            List yang dipinjam :
            - Paket Aula 1
            - Paket Duduk 2 ', 'ticket_num'=> '12000215', 'phone'=>'085236000637'],
            ['closed_date'=>'18/02/25','student_id'=>'1205230064','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'surat aktif kembali', 'ticket_num'=> '12000216', 'phone'=>'0895806456995'],
            ['closed_date'=>'18/02/25','student_id'=>'101102400007','service'=>'Paket Peminjaman', 'content'=>'Kode : 818
            Tgl pengajuan : 18 Februari 2025
            Nama Peminjam :Rizqimuhadli S.
            No HP :089510724537
            Waktu Peminjaman : 3 - 7 Maret 2025 (15.00 - 18.00)
            Oleh : UKKI 
            Kegiatan : Bazar
            List yang dipinjam :
            - Paket Listrik 3
            - Paket Kelas 1 ', 'ticket_num'=> '12000217', 'phone'=>'089510724537'],
            ['closed_date'=>'18/02/25','student_id'=>'101102400007','service'=>'Paket Peminjaman', 'content'=>'Kode : 819
            Tgl pengajuan : 18 Februari 2025
            Nama Peminjam :Rizqimuhadli S.
            No HP :089510724537
            Waktu Peminjaman : 17 Maret 2025 (15.00 - 18.00)
            Oleh : UKKI 
            Kegiatan : Bazar
            List yang dipinjam :
            - Paket Listrik 3
            - Paket Kelas 1 ', 'ticket_num'=> '12000218', 'phone'=>'089510724537'],
            ['closed_date'=>'18/02/25','student_id'=>'101102400007','service'=>'Paket Peminjaman', 'content'=>'Kode : 820
            Tgl pengajuan : 18 Februari 2025
            Nama Peminjam :Rizqimuhadli S.
            No HP :089510724537
            Waktu Peminjaman : 17 Maret 2025 (15.00 - 18.00)
            Oleh : UKKI 
            Kegiatan : Malam Iman dan Takwa 
            List yang dipinjam :
            - Paket Audio Portable 1  
            - Paket HDMI 1 
            - Paket Komunikasi 1
            - Paket Listrik 1 ', 'ticket_num'=> '12000219', 'phone'=>'089510724537'],
            ['closed_date'=>'18/02/25','student_id'=>'1201220029','service'=>'Paket Peminjaman', 'content'=>'Kode : 821
            Tgl pengajuan : 18 Februari 2025
            Nama Peminjam :Euangelion Michael D
            No HP :081239204404
            Waktu Peminjaman : 26-28 Februari 2025
            Oleh : KMK
            Kegiatan : Rapat Kerja Pengurus KMK 
            List yang dipinjam :
            - Paket kelas 1', 'ticket_num'=> '12000220', 'phone'=>'081239204404'],
            ['closed_date'=>'18/02/25','student_id'=>'1103220024','service'=>'Legalisir KHS Mahasiswa', 'content'=>'legalisir khs untuk beasiswa ', 'ticket_num'=> '12000221', 'phone'=>'081233361821'],
            ['closed_date'=>'18/02/25','student_id'=>'1203230102','service'=>'Paket Peminjaman', 'content'=>'Kode : 822
            Tgl pengajuan : 18 Februari 2025
            Nama Peminjam :Ando Ammar R.
            No HP : 081944603242
            Waktu Peminjaman : 1 Maret 2025 (08.00 - 15.00)
            Oleh : Nippon Bunka-Bu 
            Kegiatan : Open Gathering 
            List yang dipinjam :
            - Paket kelas 1 (Request Ruang Bersekat)', 'ticket_num'=> '12000222', 'phone'=>'081944603242'],
            ['closed_date'=>'18/02/25','student_id'=>'1203230103','service'=>'Paket Peminjaman', 'content'=>'Kode : 823
            Tgl pengajuan : 18 Februari 2025
            Nama Peminjam :Ando Ammar R.
            No HP : 081944603242
            Waktu Peminjaman : 8 Maret 2025 (08.00 - 15.00)
            Oleh : Workshop wig 
            Kegiatan : Open Gathering 
            List yang dipinjam :
            - Paket kelas 1 (Request Ruang Bersekat)', 'ticket_num'=> '12000223', 'phone'=>'081944603242'],
            ['closed_date'=>'18/02/25','student_id'=>'1101220037','service'=>'Paket Peminjaman', 'content'=>'Kode : 824
            Tgl pengajuan : 18 Februari 2025
            Nama Peminjam :Cindy Florence Ovalina
            No HP :085804757642
            Waktu Peminjaman : 5-6 Maret 2025
            Oleh : Hima Tesla
            Kegiatan : Tesla Iftar 
            List yang dipinjam :
            - Paket Aula 1', 'ticket_num'=> '12000224', 'phone'=>'085804757642'],
            ['closed_date'=>'18/02/25','student_id'=>'103102400071','service'=>'Pengajuan Surat Tugas', 'content'=>'UKM MAHITKOM, meminta surat tugas untuk dispensasi kegiatan di luar kampus.', 'ticket_num'=> '12000226', 'phone'=>'081216556145'],
            ['closed_date'=>'19/02/25','student_id'=>'1204220100','service'=>'Paket Peminjaman', 'content'=>'Kode : 825
            Tgl pengajuan : 19 Februari 2025
            Nama Peminjam :zaza syach zayyaan 
            No HP :085174366076
            Waktu Peminjaman :25 Februari 2025
            Oleh : HMSI
            Kegiatan : Sosialisasi Badan Senat HMSI dan photosoot
            List yang dipinjam :
            - Paket Kelas 1
            - Lapangan Hybrid
            - Paket aula 1', 'ticket_num'=> '12000228', 'phone'=>'085174366076'],
            ['closed_date'=>'19/02/25','student_id'=>'1201220003','service'=>'Paket Peminjaman', 'content'=>'Kode : 826
            Tgl pengajuan : 19 Februari 2025
            Nama Peminjam : Zidan Irfan Z.
            No HP : 088989694349
            Waktu Peminjaman : 27 April 2025 (09.00-21.00)
            Oleh : E-Sports
            Untuk : TSE X DEWA WATCHPARTY
            List yang dipinjam :
            - Paket Aula 1
            - Paket Visual 2 
            - Paket Duduk 8 
            - Paket HDMI 1
            - Paket Lighting 1 
            - Paket Streaming 1 
            - Paket Komunikasi 1 
            - Paket Listrik 4 ', 'ticket_num'=> '12000229', 'phone'=>'088989694349'],
            ['closed_date'=>'19/02/25','student_id'=>'1204210164','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'Surat Aktif Kembali ', 'ticket_num'=> '12000230', 'phone'=>'081382683917'],
            ['closed_date'=>'19/02/25','student_id'=>'101102400010','service'=>'Paket Peminjaman', 'content'=>'Kode : 827
            Tgl pengajuan : 19 Februari 2025
            Nama Peminjam : Nafisa F.
            No HP : 083824766820
            Waktu Peminjaman : 8 Maret 2025 (13.00 - 22.00)
            Oleh : Hima Teknik Komputer 
            Kegiatan : Bagi-bagi takjil dan buka Bersama HMTK
            List yang dipinjam :
            - Paket Kelas 2 (Request ruangan bersekat)
            - Paket Audio Portable 1 ', 'ticket_num'=> '12000231', 'phone'=>'083824766820'],
            ['closed_date'=>'19/02/25','student_id'=>'1204230016','service'=>'Paket Peminjaman', 'content'=>'Kode : 828
            Tgl pengajuan : 19 Februari 2025
            Nama Peminjam : Moch Brilliant Adrian H.
            No HP : 082142095898
            Waktu Peminjaman : 26 Februari 2025 (19.00-21.00)
            Oleh : UKM Bola Basket
            Untuk : Latihan tim inti TUS Basketball
            List yang dipinjam :
            - Lapangan Hybrid 1 ', 'ticket_num'=> '12000232', 'phone'=>'082142095898'],
            ['closed_date'=>'19/02/25','student_id'=>'1201222041','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Alat Meja di LAB Telematik, pada Jumat s.d Senin, tanggal pinjam 21  - 24 Februari 2025.', 'ticket_num'=> '12000233', 'phone'=>'081240831105'],
            ['closed_date'=>'19/02/25','student_id'=>'1204200219','service'=>'Pengajuan Cuti', 'content'=>'cuti akademik', 'ticket_num'=> '12000234', 'phone'=>'081217050708'],
            ['closed_date'=>'19/02/25','student_id'=>'1204230037','service'=>'Paket Peminjaman', 'content'=>'Kode : 829
            Tgl pengajuan : 19 Februari 2025
            Nama Peminjam : Mochammad Dilam Al Muhibi
            No HP :082136551569
            Waktu Peminjaman : 20 April 2025 (08.00-21.00)
            Oleh : UKM Badminton TUS
            Untuk : Technical Meeting TUSBC Master 2025
            List yang dipinjam :
            - Paket Aula 1
            - Paket Duduk 2', 'ticket_num'=> '12000235', 'phone'=>'082136551569'],
            ['closed_date'=>'19/02/25','student_id'=>'1204230037','service'=>'Paket Peminjaman', 'content'=>'Kode : 830
            Tgl pengajuan : 19 Februari 2025
            Nama Peminjam : Mochammad Dilam Al Muhibi
            No HP :082136551569
            Waktu Peminjaman : 27 Februari 2025 (18.30-21.00)
            Oleh : UKM Badminton TUS
            Untuk : Rapat Panitia TUSBC Master 2025
            List yang dipinjam :
            - Paket kelas 1', 'ticket_num'=> '12000236', 'phone'=>'082136551569'],
            ['closed_date'=>'19/02/25','student_id'=>'1204230037','service'=>'Paket Peminjaman', 'content'=>'Kode : 831
            Tgl pengajuan : 19 Februari 2025
            Nama Peminjam : Mochammad Dilam Al Muhibi
            No HP :082136551569
            Waktu Peminjaman : 5 Maret 2025 2025 (18.30-21.00)
            Oleh : UKM Badminton TUS
            Untuk : Rapat Panitia TUSBC Master 2025
            List yang dipinjam :
            - Paket kelas 1', 'ticket_num'=> '12000237', 'phone'=>'082136551569'],
            ['closed_date'=>'19/02/25','student_id'=>'1204230037','service'=>'Paket Peminjaman', 'content'=>'Kode : 832
            Tgl pengajuan : 19 Februari 2025
            Nama Peminjam : Mochammad Dilam Al Muhibi
            No HP :082136551569
            Waktu Peminjaman : 12 Maret 2025 (18.30-21.00)
            Oleh : UKM Badminton TUS
            Untuk : Rapat Panitia TUSBC Master 2025
            List yang dipinjam :
            - Paket kelas 1', 'ticket_num'=> '12000238', 'phone'=>'082136551569'],
            ['closed_date'=>'19/02/25','student_id'=>'1204230037','service'=>'Paket Peminjaman', 'content'=>'Kode : 833
            Tgl pengajuan : 19 Februari 2025
            Nama Peminjam : Mochammad Dilam Al Muhibi
            No HP :082136551569
            Waktu Peminjaman : 19 Maret 2025 (18.30-21.00)
            Oleh : UKM Badminton TUS
            Untuk : Rapat Panitia TUSBC Master 2025
            List yang dipinjam :
            - Paket kelas 1', 'ticket_num'=> '12000239', 'phone'=>'082136551569'],
            ['closed_date'=>'19/02/25','student_id'=>'1204230037','service'=>'Paket Peminjaman', 'content'=>'Kode : 834
            Tgl pengajuan : 19 Februari 2025
            Nama Peminjam : Mochammad Dilam Al Muhibi
            No HP :082136551569
            Waktu Peminjaman : 13 April 2025 (18.30-21.00)
            Oleh : UKM Badminton TUS
            Untuk : Rapat Panitia TUSBC Master 2025
            List yang dipinjam :
            - Paket kelas 1', 'ticket_num'=> '12000240', 'phone'=>'082136551569'],
            ['closed_date'=>'20/02/25','student_id'=>'1204200082','service'=>'Pengajuan Cuti', 'content'=>'Cuti Akademik', 'ticket_num'=> '12000242', 'phone'=>'0895392734889'],
            ['closed_date'=>'20/02/25','student_id'=>'1202220421','service'=>'Paket Peminjaman', 'content'=>'Kode : 835
            Tgl pengajuan : 20 Februari 2025
            Nama Peminjam : Peres Hendri Virgiawan
            No HP : 085159452235
            Waktu Peminjaman : 27 Februari 2025 (07.00 s.d 22.00)
            Oleh : Himpunan Mahasiswa Teknologi Informasi 
            Untuk : Serah Terima Jabatan HIMATISI 2024/2025 
            List yang dipinjam :
            - 1 Paket Aula
            - 1 Set Paket Musyawarah
            - 2 Set Paket Duduk', 'ticket_num'=> '12000243', 'phone'=>'085159452235'],
            ['closed_date'=>'20/02/25','student_id'=>'102062400098','service'=>'Pengajuan Undur Diri', 'content'=>'Pengajuan undur diri', 'ticket_num'=> '12000244', 'phone'=>'0895355462281'],
            ['closed_date'=>'20/02/25','student_id'=>'1103230039','service'=>'Paket Peminjaman', 'content'=>'Kode : 836
            Tgl pengajuan : 20 Februari 2025
            Nama Peminjam : M. Nur Rohman
            No HP : 085731423136
            Waktu Peminjaman : 13-14 Maret 2025 (07.00 s.d 22.00)
            Oleh : Himpunan Mahasiswa Elektro 
            Untuk : Bukber HME 2025 
            List yang dipinjam :
            - 1 Set Paket Aula
            - 2 Set Paket Visual
            - 1 Set Paket Streaming
            - 1 Set Paket Komunikasi
            - 1 Set Paket Lisrtrik
            - 1 Set Paket Lightning
            - 1 Set Paket HDMI
            - 1 Set Paket Musyawarah
            - 2 Set Paket Audio Portable
            - 1 Set Paket Duduk', 'ticket_num'=> '12000245', 'phone'=>'085731423136'],
            ['closed_date'=>'20/02/25','student_id'=>'1101238047','service'=>'Pengajuan Undur Diri', 'content'=>'Pengajuan undur diri semester genap', 'ticket_num'=> '12000246', 'phone'=>'08819774652'],
            ['closed_date'=>'20/02/25','student_id'=>'1104230033','service'=>'Paket Peminjaman', 'content'=>'Kode : 837
            Tgl pengajuan : 20 Februari 2025
            Nama Peminjam : Julio Harjo M.
            No HP : 085717014794
            Waktu Peminjaman : 28 Februari 2025 (10.00 s.d 16.00)
            Oleh : Himpunan Mahasiswa Industri
            Untuk : Bukber HMTI 2025 
            List yang dipinjam :
            - 2 Set Paket Duduk
            - 1 Set Paket Streaming
            ', 'ticket_num'=> '12000247', 'phone'=>'085717014794'],
            ['closed_date'=>'20/02/25','student_id'=>'1104230034','service'=>'Paket Peminjaman', 'content'=>'Kode : 838
            Tgl pengajuan : 20 Februari 2025
            Nama Peminjam : Julio Harjo M.
            No HP : 085717014794
            Waktu Peminjaman : 25 April 2025 (14.00 s.d 21.00)
            Oleh : Himpunan Mahasiswa Teknik Industri
            Untuk : Ramadhan Festival  
            List yang dipinjam :
            - Paket Komunikasi 1
            - Paket Aula 1
            ', 'ticket_num'=> '12000248', 'phone'=>'085717014794'],
            ['closed_date'=>'20/02/25','student_id'=>'1104230035','service'=>'Paket Peminjaman', 'content'=>'Kode : 839
            Tgl pengajuan : 20 Februari 2025
            Nama Peminjam : Julio Harjo M.
            No HP : 085717014794
            Waktu Peminjaman : 25 April 2025 (14.00 s.d 21.00)
            Oleh : Himpunan Mahasiswa Teknik Industri
            Untuk : Halal Bihalal  
            List yang dipinjam :
            - Paket Komunikasi 1
            - Paket Aula 1
            ', 'ticket_num'=> '12000249', 'phone'=>'085717014794'],
            ['closed_date'=>'20/02/25','student_id'=>'1203220151','service'=>'Pengajuan Cuti', 'content'=>'surat permohonan cuti akademik ', 'ticket_num'=> '12000250', 'phone'=>'085843385861'],
            ['closed_date'=>'21/02/25','student_id'=>'102072400001','service'=>'Paket Peminjaman', 'content'=>'Kode : 844
            Tgl pengajuan : 21 Februari 2025
            Nama Peminjam : Baiti Fatimah N
            No HP :082260790497
            Waktu Peminjaman : 28 Februari 2025 (6.00 - 10.00)
            Oleh : Mahitkom
            Untuk : Apel Pemberangkatkan Sekolah 3 Divisi 
            List yang dipinjam :
            - Lapangan Hybrid ', 'ticket_num'=> '12000255', 'phone'=>'082260790497'],
            ['closed_date'=>'21/02/25','student_id'=>'1203230051','service'=>'Pengajuan Cuti', 'content'=>'Pengajuan cuti semester genap', 'ticket_num'=> '12000256', 'phone'=>'089524503857'],
            ['closed_date'=>'21/02/25','student_id'=>'1101220506','service'=>'Legalisir KHS Mahasiswa', 'content'=>'Permintaan legalisir dokumen KHS mahasiswa untuk keperluan Surat mengajukan permohonan bantuan biaya semester', 'ticket_num'=> '12000257', 'phone'=>'082199046446'],
            ['closed_date'=>'21/02/25','student_id'=>'1205230037','service'=>'Paket Peminjaman', 'content'=>'Kode : 845
            Tgl pengajuan : 21 Februari 2025
            Nama Peminjam : Arlita Maharani
            No HP :087731281740
            Waktu Peminjaman : 1 Maret - 2 Maret 2025 (09.00 - 15.00)
            Oleh : HMBD
            Untuk : Foto Anggota  
            List yang dipinjam :
            - Paket Lighting 1
            - Stusio Foto lantai 3  ', 'ticket_num'=> '12000258', 'phone'=>'087731281740'],
            ['closed_date'=>'21/02/25','student_id'=>'103072400004','service'=>'Paket Peminjaman', 'content'=>'Kode : 846
            Tgl pengajuan : 21 Februari 2025
            Nama Peminjam : Wafii Fathan E.
            No HP :082245014518
            Waktu Peminjaman : 1 Maret 2025 (14.00 - 19.00)
            Oleh : Robotika
            Untuk : Gathering of Robotics Organization Telkom University 
            List yang dipinjam :
            - Paket Aula 1
            - Paket duduk 2 ', 'ticket_num'=> '12000259', 'phone'=>'082245014518'],
            ['closed_date'=>'21/02/25','student_id'=>'1205230016','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HMBD - Kegiatan Bootcamp HMBD', 'ticket_num'=> '12000260', 'phone'=>'08111987203'],
            ['closed_date'=>'21/02/25','student_id'=>'1202210480','service'=>'Pengajuan Undur Diri', 'content'=>'Pengajuan Undur Diri', 'ticket_num'=> '12000261', 'phone'=>'082128705141'],
            ['closed_date'=>'21/02/25','student_id'=>'1206230044','service'=>'Paket Peminjaman', 'content'=>'Kode : 847
            Tgl pengajuan : 21 Februari 2025
            Nama Peminjam : M. Fert Ardinsyah.
            No HP : 085604106902
            Waktu Peminjaman : 1 Maret 2025 (06.00 - 17.00)
            Oleh : HIMASDATA 
            Untuk : Live QnA Open Recruitment 
            List yang dipinjam :
            - Paket Kelas 1
            - Paket Listrik 1 ', 'ticket_num'=> '12000262', 'phone'=>'085604106902'],
            ['closed_date'=>'21/02/25','student_id'=>'1206230044','service'=>'Paket Peminjaman', 'content'=>'Kode : 848
            Tgl pengajuan : 21 Februari 2025
            Nama Peminjam : M. Fert Ardinsyah.
            No HP : 085604106902
            Waktu Peminjaman : 15 Maret 2025 (06.00 - 17.00)
            Oleh : HIMASDATA 
            Untuk : Open Recruitment Staff Muda HIMASDATA 2025
            List yang dipinjam :
            - Paket Kelas 4 (4 KELAS BERSERET)
            - Paket Listrik 1 ', 'ticket_num'=> '12000263', 'phone'=>'085604106902'],
            ['closed_date'=>'21/02/25','student_id'=>'1204202140','service'=>'Pengajuan Cuti', 'content'=>'Form pengajuan cuti', 'ticket_num'=> '12000264', 'phone'=>'085173351712'],
            ['closed_date'=>'21/02/25','student_id'=>'1201220037','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab digital start Up untuk kegiatan Form Grup Discussion, pada tanggal 25 Februari 2025 pada hari Selasa (18.00 - 22.00).', 'ticket_num'=> '12000265', 'phone'=>'085816673159'],
            ['closed_date'=>'21/02/25','student_id'=>'1202230057','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'Aktif Kembali', 'ticket_num'=> '12000266', 'phone'=>'08222822466'],
            ['closed_date'=>'21/02/25','student_id'=>'1101190066','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'aktif kembali', 'ticket_num'=> '12000267', 'phone'=>'0895364803623'],
            ['closed_date'=>'21/02/25','student_id'=>'1205220091','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'aktif kembali', 'ticket_num'=> '12000268', 'phone'=>'081361118931'],
            ['closed_date'=>'24/02/25','student_id'=>'1204220105','service'=>'Legalisir KHS Mahasiswa', 'content'=>'Permintaan TTD Kabag Kemahasiswaan terkait Beasiswa Indofood', 'ticket_num'=> '12000269', 'phone'=>'085731021898'],
            ['closed_date'=>'02/01/25','student_id'=>'1204210087','service'=>'Pengajuan Surat Tugas', 'content'=>'Pengajuan surat KP', 'ticket_num'=> '12000001', 'phone'=>'082231700377'],
            ['closed_date'=>'24/02/25','student_id'=>'1204220105','service'=>'Legalisir KHS Mahasiswa', 'content'=>'Permintaan legalisir dokumen KHS mahasiswa untuk keperluan Beasiswa', 'ticket_num'=> '12000271', 'phone'=>'085731021898'],
            ['closed_date'=>'24/02/25','student_id'=>'1203220100','service'=>'Pengajuan Cuti', 'content'=>'Form pengajuan cuti semester genap', 'ticket_num'=> '12000272', 'phone'=>'085856069143'],
            ['closed_date'=>'24/02/25','student_id'=>'1203230074','service'=>'Pengajuan Cuti', 'content'=>'Form pengajuan cuti semester genap', 'ticket_num'=> '12000273', 'phone'=>'081216832329'],
            ['closed_date'=>'25/02/25','student_id'=>'1205230016','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HMBD - LPJ BOOTCAMP HMBD', 'ticket_num'=> '12000274', 'phone'=>'08111987203'],
            ['closed_date'=>'25/02/25','student_id'=>'1203230050','service'=>'Pengajuan Cuti', 'content'=>'Form pengajuan cuti semester genap', 'ticket_num'=> '12000275', 'phone'=>'087855401133'],
            ['closed_date'=>'25/02/25','student_id'=>'1206230066','service'=>'Paket Peminjaman', 'content'=>'Kode : 849
            Tgl pengajuan : 25 Februari 2025
            Nama Peminjam : Achmad Sultonul A.
            No HP : 088217045798    
            Waktu Peminjaman : 6 Maret 2025 (16.00-19.00)
            Oleh : Komunitas Paskibra Telkom University Surabaya (BEM TUS)
            Untuk : Foto ID Card
            List yang dipinjam :
            - 2 Paket Lighting
            - 1 Paket Listrik', 'ticket_num'=> '12000276', 'phone'=>'088217045798'],
            ['closed_date'=>'26/02/25','student_id'=>'1105230006','service'=>'Paket Peminjaman', 'content'=>'Kode : 854
            Tgl pengajuan : 26 Februari 2025
            Nama Peminjam : Rengganis Puspa G.
            No HP : 082175136249    
            Waktu Peminjaman : 12 April - 13 April 2025 (07.00-21.00)
            Oleh : Telkom ART
            Untuk : First Meet Anggota Baru UKM Telkom Art 
            List yang dipinjam :
            - Paket Aula 1
            - Paket Komunikasi 2
            - Paket Kursi Tiger 3
            - Paket Lighting 1
            - Paket Listrik 1', 'ticket_num'=> '12000281', 'phone'=>'082175136249'],
            ['closed_date'=>'26/02/25','student_id'=>'1104230033','service'=>'Paket Peminjaman', 'content'=>'Kode : 855
            Tgl pengajuan : 26 Februari 2025
            Nama Peminjam : Julio Harjo Maroni
            No HP : 085717014794    
            Waktu Peminjaman : 11 April 2025 (06.00-20.00)
            Oleh : HMTI
            Untuk : Halal-bihalal  
            List yang dipinjam :
            - Paket Aula 1
            - Paket Komunikasi 1
            ', 'ticket_num'=> '12000282', 'phone'=>'085717014794'],
            ['closed_date'=>'26/02/25','student_id'=>'104052400106','service'=>'Paket Peminjaman', 'content'=>'Kode : 856
            Tgl pengajuan : 26 Februari 2025
            Nama Peminjam : Rexzada Reyhan R.
            No HP : 081233718755    
            Waktu Peminjaman : 8 Maret 2025 (08.00-16.00)
            Oleh : Ikatan Mahasiswa Sulawesi
            Untuk : Upgrading Pengurus IMS Tel-U SBY  
            List yang dipinjam :
            - Paket Kelas 2 ( Req ruangan bersekat)
            - Paket audio portable 1 
            - Paket HDMI 1  ', 'ticket_num'=> '12000283', 'phone'=>'081233718755'],
            ['closed_date'=>'26/02/25','student_id'=>'1101230003','service'=>'Paket Peminjaman', 'content'=>'Kode : 857
            Tgl pengajuan : 26 Februari 2025
            Nama Peminjam : Reyno Nafis Ega J.
            No HP : 085888144207    
            Waktu Peminjaman : 8 Maret 2025 (08.00-15.00)
            Oleh : Hima Tesla
            Untuk : Rapat Makrab Hima Tesla
            List yang dipinjam :
            - 3 Paket Kelas (2 Bersekat dan 1 Reguler)', 'ticket_num'=> '12000284', 'phone'=>'085888144207'],
            ['closed_date'=>'26/02/25','student_id'=>'1101230004','service'=>'Paket Peminjaman', 'content'=>'Kode : 858
            Tgl pengajuan : 26 Februari 2025
            Nama Peminjam : Reyno Nafis Ega J.
            No HP : 085888144207    
            Waktu Peminjaman : 16 Maret 2025 (08.00-15.00)
            Oleh : Hima Tesla
            Untuk : Rapat Makrab Hima Tesla
            List yang dipinjam :
            - 3 Paket Kelas (2 Bersekat dan 1 Reguler)', 'ticket_num'=> '12000285', 'phone'=>'085888144207'],
            ['closed_date'=>'26/02/25','student_id'=>'1205220065','service'=>'Legalisir KHS Mahasiswa', 'content'=>'Permintaan legalisir dokumen KHS mahasiswa untuk keperluan pengurusan Visa ke Australia', 'ticket_num'=> '12000286', 'phone'=>'081217150182'],
            ['closed_date'=>'26/02/25','student_id'=>'1201220037','service'=>'Paket Peminjaman', 'content'=>'Kode : 858
            Tgl pengajuan : 26 Februari 2025
            Nama Peminjam : Ditto Aditya Nugroho
            No HP : 085816673159    
            Waktu Peminjaman : 6 Maret 2025 (18.00-21.00)
            Oleh : HIMSE
            Untuk : FGD (Forum Grup Discussion)
            List yang dipinjam :
            - Paket Kelas 2 (Ruang Kelas Gabungan)', 'ticket_num'=> '12000287', 'phone'=>'085816673159'],
            ['closed_date'=>'26/02/25','student_id'=>'1205230014','service'=>'Paket Peminjaman', 'content'=>'Kode : 860
            Tgl pengajuan : 26 Februari 2025
            Nama Peminjam : Gracela Sri Monita
            No HP : 082286635140    
            Waktu Peminjaman : 22 Maret 2025 (07.00-21.00)
            Oleh : Keluarga Mahasiswa Sumatera
            Untuk : First Gathering 
            List yang dipinjam :
            - Paket Kelas 2 (Ruang Kelas Gabungan)
            - Paket Audio Portable 1', 'ticket_num'=> '12000288', 'phone'=>'082286635140'],
            ['closed_date'=>'27/02/25','student_id'=>'103102400032','service'=>'Paket Peminjaman', 'content'=>'Kode : 861
            Tgl pengajuan : 27 Februari 2025
            Nama Peminjam : Avrio De Galyn Athar
            No HP : 081213640972    
            Waktu Peminjaman : 17-18 Maret 2025 (08.30-15.00)
            Oleh : Unit Kegiatan Kerohanian Islam (UKKI AL-HABSYI)
            Untuk : MTQ  
            List yang dipinjam :
            - Paket Kelas 1 
            - Paket Audio Portabel 1 
            - Paket HDMI 1
            - Paket Komunikasi 1
            - Paket Listrik 1
            - Paket Aula 1', 'ticket_num'=> '12000289', 'phone'=>'081213640972'],
            ['closed_date'=>'30/01/25','student_id'=>'1204210013','service'=>'Surat Rekomendasi Magang', 'content'=>'Minta Template buat magang, tapi prodi ngarahi ke SSC ', 'ticket_num'=> '12000059', 'phone'=>'081331016271'],
            ['closed_date'=>'27/02/25','student_id'=>'1201230043','service'=>'Paket Peminjaman', 'content'=>'Kode : 862
            Tgl pengajuan : 27 Februari 2025
            Nama Peminjam : M. Khafidh Ainur R.
            No HP :085232491318 
            Waktu Peminjaman : 18-20 Maret 2025 (14.00-21.00)
            Oleh :HIMSE
            Untuk : Bukber HIMSI
            List yang dipinjam :
            - Paket Aula 1', 'ticket_num'=> '12000291', 'phone'=>'085232491318'],
            ['closed_date'=>'27/02/25','student_id'=>'1203220001','service'=>'Paket Peminjaman', 'content'=>'Kode : 863
            Tgl pengajuan : 27 Februari 2025
            Nama Peminjam : Akmal Eggy Terea
            No HP :0881027780473    
            Waktu Peminjaman : 8 Maret 2025 (08.00-21.00)
            Oleh :HMIF
            Untuk : Rapat Kerja dan Sidang Pleno HMIF 2025
            List yang dipinjam :
            - Paket Ruang kelas 1
            - Paket Musyawarah 1
            - Paket Lighting 1', 'ticket_num'=> '12000292', 'phone'=>'0881027780473'],
            ['closed_date'=>'27/02/25','student_id'=>'1202230003','service'=>'Paket Peminjaman', 'content'=>'Kode : 865
            Tgl pengajuan : 27 Februari 2025
            Nama Peminjam : Kevin Imanuel S.
            No HP : 082236039191    
            Waktu Peminjaman : 7 Maret 2025 (18.00-22.00)
            Oleh : UKKK
            Untuk : Rapat BPH Perayaan Paskah UK3 2025
            List yang dipinjam :
            - Paket Ruang kelas 1', 'ticket_num'=> '12000294', 'phone'=>'082236039191'],
            ['closed_date'=>'27/02/25','student_id'=>'1202230004','service'=>'Paket Peminjaman', 'content'=>'Kode : 866
            Tgl pengajuan : 27 Februari 2025
            Nama Peminjam : Kevin Imanuel S.
            No HP : 082236039191    
            Waktu Peminjaman : 28 Maret 2025 (18.00-22.00)
            Oleh : UKKK
            Untuk : Rapat BPH Perayaan Paskah UK3 2025
            List yang dipinjam :
            - Paket Ruang kelas 1', 'ticket_num'=> '12000295', 'phone'=>'082236039191'],
            ['closed_date'=>'27/02/25','student_id'=>'1202230005','service'=>'Paket Peminjaman', 'content'=>'Kode : 867
            Tgl pengajuan : 27 Februari 2025
            Nama Peminjam : Kevin Imanuel S.
            No HP : 082236039191    
            Waktu Peminjaman : 18 Maret 2025 (19.00-22.00)
            Oleh : UKKK
            Untuk : Persiapan PAW Ibadah Perayaan Paskah UK3 2025
            List yang dipinjam :
            - Paket Ruang kelas 1', 'ticket_num'=> '12000296', 'phone'=>'082236039191'],
            ['closed_date'=>'27/02/25','student_id'=>'1202230006','service'=>'Paket Peminjaman', 'content'=>'Kode : 868
            Tgl pengajuan : 27 Februari 2025
            Nama Peminjam : Kevin Imanuel S.
            No HP : 082236039191    
            Waktu Peminjaman : 25 Maret 2025 (19.00-22.00)
            Oleh : UKKK
            Untuk : Persiapan PAW Ibadah Perayaan Paskah UK3 2025
            List yang dipinjam :
            - Paket Ruang kelas 1', 'ticket_num'=> '12000297', 'phone'=>'082236039191'],
            ['closed_date'=>'27/02/25','student_id'=>'1202230007','service'=>'Paket Peminjaman', 'content'=>'Kode : 869
            Tgl pengajuan : 27 Februari 2025
            Nama Peminjam : Kevin Imanuel S.
            No HP : 082236039191    
            Waktu Peminjaman : 8 April 2025 (19.00-22.00)
            Oleh : UKKK
            Untuk : Persiapan PAW Ibadah Perayaan Paskah UK3 2025
            List yang dipinjam :
            - Paket Ruang kelas 1', 'ticket_num'=> '12000298', 'phone'=>'082236039191'],
            ['closed_date'=>'27/02/25','student_id'=>'1202230008','service'=>'Paket Peminjaman', 'content'=>'Kode : 870
            Tgl pengajuan : 27 Februari 2025
            Nama Peminjam : Kevin Imanuel S.
            No HP : 082236039191    
            Waktu Peminjaman : 11 April 2025 (19.00-22.00)
            Oleh : UKKK
            Untuk : Persiapan PAW Ibadah Perayaan Paskah UK3 2025
            List yang dipinjam :
            - Paket Ruang kelas 1', 'ticket_num'=> '12000299', 'phone'=>'082236039191'],
            ['closed_date'=>'27/02/25','student_id'=>'1103230002','service'=>'Paket Peminjaman', 'content'=>'Kode : 871
            Tgl pengajuan : 27 Februari 2025
            Nama Peminjam : Pedro Bernadus B 
            No HP : 085159886064    
            Waktu Peminjaman : 19-20 Maret 2025 (8.00-22.00)
            Oleh : KMK
            Untuk : Persekutuan Doa Rosario KMK TUS
            List yang dipinjam :
            - Paket Aula 
            - Paket Visual 2
            - Paket HDMI 1
            - Paket Duduk 1
            - Paket Komunikasi 2
            - Paket Listrik 2
            - paket streaming 1', 'ticket_num'=> '12000300', 'phone'=>'085159886064'],
            ['closed_date'=>'27/02/25','student_id'=>'1103230002','service'=>'Paket Peminjaman', 'content'=>'Kode : 871
            Tgl pengajuan : 27 Februari 2025
            Nama Peminjam : Pedro Bernadus B 
            No HP : 085159886064    
            Waktu Peminjaman : 22-24 April 2025 (8.00-22.00)
            Oleh : KMK
            Untuk : Paskah KMK TUS
            List yang dipinjam :
            - Paket Aula 
            - Paket Visual 2
            - Paket HDMI 1
            - Paket Duduk 1
            - Paket Komunikasi 2
            - Paket Listrik 2
            - paket streaming 2 
            - paket lighting 2', 'ticket_num'=> '12000301', 'phone'=>'085159886064'],
            ['closed_date'=>'27/02/25','student_id'=>'1202230008','service'=>'Paket Peminjaman', 'content'=>'Kode : 873
            Tgl pengajuan : 27 Februari 2025
            Nama Peminjam : Kevin Imanuel S.
            No HP : 082236039191    
            Waktu Peminjaman : 15 April 2025 (19.00-22.00)
            Oleh : UKKK
            Untuk : Persiapan PAW Ibadah Perayaan Paskah UK3 2025
            List yang dipinjam :
            - Paket Ruang kelas 1', 'ticket_num'=> '12000302', 'phone'=>'082236039191'],
            ['closed_date'=>'27/02/25','student_id'=>'1103230002','service'=>'Peminjaman Orbit', 'content'=>'peminjaman orbit untuk persekutuan doa 19-20 Maret 2025', 'ticket_num'=> '12000303', 'phone'=>'085159886064'],
            ['closed_date'=>'27/02/25','student_id'=>'1103230002','service'=>'Peminjaman Orbit', 'content'=>'peminjaman ormit untuk paskah 22-24 april 2025', 'ticket_num'=> '12000304', 'phone'=>'085159886064'],
            ['closed_date'=>'27/02/25','student_id'=>'1202220421','service'=>'Paket Peminjaman', 'content'=>'Kode : 874
            Tgl pengajuan : 27 Februari 2025
            Nama Peminjam : Peres Hendri V.
            No HP : 085159452235    
            Waktu Peminjaman : 9 Maret 2025 (07.00-22.00)
            Oleh : HIMATISI
            Untuk : Serah terima jabatan HIMATISI 
            List yang dipinjam :
            - Paket Aula 1 
            - Paket Musyawarah 1 
            - Paket Duduk 2
            ', 'ticket_num'=> '12000305', 'phone'=>'085159452235'],
            ['closed_date'=>'27/02/25','student_id'=>'1204180010','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'Pengajuan Aktif Kembali ', 'ticket_num'=> '12000306', 'phone'=>'087758904398'],
            ['closed_date'=>'27/02/25','student_id'=>'1204180022','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'Pengajuan Aktif Kembali ', 'ticket_num'=> '12000307', 'phone'=>'083831116312'],
            ['closed_date'=>'28/02/25','student_id'=>'1204230019','service'=>'Paket Peminjaman', 'content'=>'Kode : 875
            Tgl pengajuan : 28 Februari 2025
            Nama Peminjam : Alkhanza Sonia A 
            No HP : 083830604733 
            Waktu Peminjaman : 15-16 MARET 2025 (7.00-18.00)
            Oleh : DPM
            Untuk : Wawancara Open Recruitment DPM
            List yang dipinjam :
            - Paket kelas 1
            - Paket listrik 1', 'ticket_num'=> '12000308', 'phone'=>'083830604733 '],
            ['closed_date'=>'28/02/25','student_id'=>'1205230035','service'=>'Paket Peminjaman', 'content'=>'Kode : 876
            Tgl pengajuan : 28 Februari 2025
            Nama Peminjam : M. Adhelio
            No HP : 08885872709 
            Waktu Peminjaman : 8 Maret 2025 (09.00-15.00)
            Oleh : HMBD
            Untuk : Foto Anggota Himpunan Mahasiswa Bisnis Digital
            List yang dipinjam :
            - Paket Ruang kelas 1
            - paket Lighting 1 ', 'ticket_num'=> '12000309', 'phone'=>'08885872709'],
            ['closed_date'=>'28/02/25','student_id'=>'1203230002','service'=>'Paket Peminjaman', 'content'=>'Kode : 877
            Tgl pengajuan : 28 Februari 2025
            Nama Peminjam : Araya Aliya C.
            No HP : 081395972004
            Waktu Peminjaman : 9 Maret 2025 (14.00-19.00)
            Oleh : Punggawa Inspiratif (BEM)
            Untuk : Gathering Pengurus Punggawa 2025
            List yang dipinjam :
            - Paket Kelas 1
            - Paket Audio Portabel 1 ', 'ticket_num'=> '12000310', 'phone'=>'081395972004'],
            ['closed_date'=>'28/02/25','student_id'=>'1203230037','service'=>'Paket Peminjaman', 'content'=>'Kode : 878
            Tgl pengajuan : 28 Februari 2025
            Nama Peminjam : Pinaringan Iman S.
            No HP : 081333571793
            Waktu Peminjaman : 8 Maret 2025 (10.00-15.00)
            Oleh : Unit Kegiatan Kerohanian Kristen (UKKK)
            Untuk : Photo Shoot Kepengurusan UK3 2025
            List yang dipinjam :
            - Paket Kelas 1
            - Paket Lighting 1 ', 'ticket_num'=> '12000311', 'phone'=>'081333571793'],
            ['closed_date'=>'28/02/25','student_id'=>'102052400041','service'=>'Paket Peminjaman', 'content'=>'Kode : 879
            Tgl pengajuan : 28 Februari 2025
            Nama Peminjam : Andy Muhammad Rizkyawan
            No HP : 081543457290
            Waktu Peminjaman : 25 - 29 September 2025 (08.00-22.00)
            Oleh : IMS (IKATAN MAHASISWA SULAWESI)
            Untuk : PAGESST (PAGELARAN SENI DAN BUDAYA)
            List yang dipinjam :
            - Paket Aula Tel U SBY 1', 'ticket_num'=> '12000312', 'phone'=>'081543457290'],
            ['closed_date'=>'28/02/25','student_id'=>'1105230011','service'=>'Paket Peminjaman', 'content'=>'Kode : 880
            Tgl pengajuan : 28 Februari 2025
            Nama Peminjam : Ivon Nadhia Aisyah
            No HP : 081937881513
            Waktu Peminjaman : 12 Maret 2025 (12.00-21.00)
            Oleh : Himpunan Mahasiswa Teknik Logistik
            Untuk : Buka Bersama Program Studi Teknik Logistik 2025
            List yang dipinjam :
            - Paket Aula 1
            - Paket Musyawarah 1 (Tiang Bendera Set)
            - Paket Duduk 2
            - Paket Listrik 1 ', 'ticket_num'=> '12000313', 'phone'=>'081937881513'],
            ['closed_date'=>'28/02/25','student_id'=>'1105230023','service'=>'Paket Peminjaman', 'content'=>'Kode : 879
            Tgl pengajuan : 28 Februari 2025
            Nama Peminjam : Daryan Apriyanyo K.
            No HP : 087881140633
            Waktu Peminjaman : 22 - 23 April 2025 (06.00-22.00)
            Oleh : IM NTT
            Untuk : Pameran Seni Budaya
            List yang dipinjam :
            - Paket Aula 1
            - Paket Listrik 1 
            - Paket Visual 1
            - Paket Duduk 3', 'ticket_num'=> '12000314', 'phone'=>'087881140633'],
            ['closed_date'=>'28/02/25','student_id'=>'1204220105','service'=>'Legalisir KHS Mahasiswa', 'content'=>'Permintaan Stempel untuk Beasiswa Indofood', 'ticket_num'=> '12000315', 'phone'=>'085731021898'],
            ['closed_date'=>'28/02/25','student_id'=>'1103230027','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HME - Laporan Pengajuan Dana Bukber Elektro 2025', 'ticket_num'=> '12000316', 'phone'=>'082301043405'],
            ['closed_date'=>'31/01/25','student_id'=>'1206230029','service'=>'Legalisir KHS Mahasiswa', 'content'=>'Menunggu Followup dari mbak dina, karena masi menayakan ke sekpim terkait legalisisr KHS', 'ticket_num'=> '12000061', 'phone'=>'08970697248'],
            ['closed_date'=>'28/02/25','student_id'=>'101082400021','service'=>'Pengajuan Cuti', 'content'=>'Pengajuan cuti ', 'ticket_num'=> '12000318', 'phone'=>'085348030999'],
            ['closed_date'=>'03/03/25','student_id'=>'1102230005','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HMTK - Pengajuan Dana Bagi-Bagi Takjil dan Buka Puasa Bersama HMTK', 'ticket_num'=> '12000319', 'phone'=>'081339787262'],
            ['closed_date'=>'03/03/25','student_id'=>'1204220043','service'=>'Paket Peminjaman', 'content'=>'Kode : 882
            Tgl pengajuan : 3 Maret 2025
            Nama Peminjam : Aditya Meilano F.
            No HP : 085341623153 
            Waktu Peminjaman : 15 Maret 2025 (09.00 - 17.00)
            Oleh : Ikatan Mahasiswa Sulawesi
            Untuk : Rapat Triwulan IMS 
            List yang dipinjam :
            - 1 Paket Kelas', 'ticket_num'=> '12000320', 'phone'=>'085341623153'],
            ['closed_date'=>'03/03/25','student_id'=>'1203230008','service'=>'Paket Peminjaman', 'content'=>'Kode : 883
            Tgl pengajuan : 3 Maret 2025
            Nama Peminjam : Ahmad Farhan Q. F.
            No HP : 085163602445 
            Waktu Peminjaman : 25-28 April 2025 (07.00 - 17.00)
            Oleh : UKM CODER
            Untuk : Dojo - Gelatik 
            List yang dipinjam :
            - 1 Paket Aula', 'ticket_num'=> '12000321', 'phone'=>'085163602445'],
            ['closed_date'=>'03/03/25','student_id'=>'102062400099','service'=>'Paket Peminjaman', 'content'=>'Kode : 884
            Tgl pengajuan : 3 Maret 2025
            Nama Peminjam : Gevira Rasudatul G.
            No HP : 082237785641 
            Waktu Peminjaman : 12 April 2025 (07.00 - 12.00)
            Oleh : Ikatan Mahasiswa Sulawesi
            Untuk : Play And Bound IMS 
            List yang dipinjam :
            - 1 Peminjaman Lap. Hybrid (Untuk Sesi 1 dan Sesi 2)
            - Paket Audio Portable', 'ticket_num'=> '12000322', 'phone'=>'082237785641'],
            ['closed_date'=>'03/03/25','student_id'=>'1203220079','service'=>'Paket Peminjaman', 'content'=>'Kode : 885
            Tgl pengajuan : 3 Maret 2025
            Nama Peminjam : Michael Leonardo
            No HP : 087854726516
            Waktu Peminjaman : 9 Maret 2025 (15.00-21.00)
            Oleh : BEM
            Untuk : Diklat Pemimpin BEM
            List yang dipinjam :
            - Paket Audio Portable 1
            - Paket Ruang Kelas 1', 'ticket_num'=> '12000323', 'phone'=>'087854726516'],
            ['closed_date'=>'04/03/25','student_id'=>'1204210041','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab. Pemodelan dan Komputasi Terapan untuk keperluan belajar mandiri 10 Maret 2025 s/d 10 April 2025 pada hari Senin-Jumat (19.00 - 20.00) dan hari Sabtu-Minggu (08.00-12.00).', 'ticket_num'=> '12000324', 'phone'=>'085161907133'],
            ['closed_date'=>'04/03/25','student_id'=>'1204230018','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HMSI - Aksi Ramadhan berbagi Berkah ', 'ticket_num'=> '12000325', 'phone'=>'089681594879'],
            ['closed_date'=>'05/03/25','student_id'=>'1205230001','service'=>'Peminjaman Orbit', 'content'=>'peminjaman orbit untuk kulish tamu pengantar manajemen bisnis 10 Maret - 11 Maret 2025', 'ticket_num'=> '12000326', 'phone'=>'082140429735'],
            ['closed_date'=>'05/03/25','student_id'=>'1102230005','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HMTK - Proposal Pengajuan Dana Bagi-Bagi Takjil dan Buka Puasa Bersama HMTK', 'ticket_num'=> '12000327', 'phone'=>'081339787262'],
            ['closed_date'=>'05/03/25','student_id'=>'1101230045','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HIMA TESLA - PEKAN RAMADHAN 2025', 'ticket_num'=> '12000328', 'phone'=>'087863058323'],
            ['closed_date'=>'05/03/25','student_id'=>'1204230113','service'=>'Paket Peminjaman', 'content'=>'Kode : 886
            Tgl pengajuan : 5 Maret 2025
            Nama Peminjam : Fransisca Aurelia
            No HP : 082140741749
            Waktu Peminjaman : 20-21 Maret 2025 (07.00 - 22.00)
            Oleh : BEM KEMA Tel-U SBY
            Untuk : Ramadhan Unity BEM KEMA TEL-U Surabaya
            List yang dipinjam :
            - Paket Aula 1', 'ticket_num'=> '12000329', 'phone'=>'082140741749'],
            ['closed_date'=>'09/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 960
            Tgl pengajuan : 09 April 2025
            Nama Peminjam :  Athaya Alfarabi
            No HP : 087855149236
            Waktu Peminjaman : 22 April 2025 (18.00-21.00)
            Oleh : HIMASDATA
            Untuk : FIT N FUN 2025
            List yang dipinjam :
            - Paket Kelas 1
            ', 'ticket_num'=> '12000330', 'phone'=>'087855149236'],
            ['closed_date'=>'09/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 961
            Tgl pengajuan : 09 April 2025
            Nama Peminjam :  Athaya Alfarabi
            No HP : 087855149236
            Waktu Peminjaman : 29 April 2025 (18.00-21.00)
            Oleh : HIMASDATA
            Untuk : FIT N FUN 2025
            List yang dipinjam :
            - Paket Kelas 1
            ', 'ticket_num'=> '12000331', 'phone'=>'087855149236'],
            ['closed_date'=>'09/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 962
            Tgl pengajuan : 09 April 2025
            Nama Peminjam :  Athaya Alfarabi
            No HP : 087855149236
            Waktu Peminjaman : 4 Mei 2025 (13.00-21.00)
            Oleh : HIMASDATA
            Untuk : FIT N FUN 2025
            List yang dipinjam :
            - Lapangan Hybrid 1
            - Paket Kelas 1
            - Paket Audio Lapangan 1
            - Megaphone / Toa 1
            ', 'ticket_num'=> '12000332', 'phone'=>'087855149236'],
            ['closed_date'=>'09/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 963
            Tgl pengajuan : 09 April 2025
            Nama Peminjam :  Athaya Alfarabi
            No HP : 087855149236
            Waktu Peminjaman : 10 & 11 Mei 2025 (13.00-21.00)
            Oleh : HIMASDATA
            Untuk : FIT N FUN 2025
            List yang dipinjam :
            - Lapangan Hybrid 1
            - Paket Kelas 1
            - Paket Audio Lapangan 1
            - Megaphone / Toa 1
            ', 'ticket_num'=> '12000333', 'phone'=>'087855149236'],
            ['closed_date'=>'09/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 964
            Tgl pengajuan : 09 April 2025
            Nama Peminjam :  Athaya Alfarabi
            No HP : 087855149236
            Waktu Peminjaman : 17 & 18 Mei 2025 (13.00-21.00)
            Oleh : HIMASDATA
            Untuk : FIT N FUN 2025
            List yang dipinjam :
            - Lapangan Hybrid 1
            - Paket Kelas 1
            - Paket Audio Lapangan 1
            - Megaphone / Toa 1
            ', 'ticket_num'=> '12000334', 'phone'=>'087855149236'],
            ['closed_date'=>'09/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 965
            Tgl pengajuan : 09 April 2025
            Nama Peminjam :  Athaya Alfarabi
            No HP : 087855149236
            Waktu Peminjaman : 24 & 25 Mei 2025 (13.00-21.00)
            Oleh : HIMASDATA
            Untuk : FIT N FUN 2025
            List yang dipinjam :
            - Lapangan Hybrid 1
            - Paket Kelas 1
            - Paket Audio Lapangan 1
            - Megaphone / Toa 1', 'ticket_num'=> '12000335', 'phone'=>'087855149236'],
            ['closed_date'=>'09/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 966
            Tgl pengajuan : 09 April 2025
            Nama Peminjam :  Athaya Alfarabi
            No HP : 087855149236
            Waktu Peminjaman : 31 Mei & 1 Juni 2025 (13.00-21.00)
            Oleh : HIMASDATA
            Untuk : FIT N FUN 2025
            List yang dipinjam :
            - Lapangan Hybrid 1
            - Paket Kelas 1
            - Paket Audio Lapangan 1
            - Megaphone / Toa 1', 'ticket_num'=> '12000336', 'phone'=>'087855149236'],
            ['closed_date'=>'09/04/25','student_id'=>'1202230062','service'=>'Paket Peminjaman', 'content'=>'Kode : 967
            Tgl pengajuan : 09 April 2025
            Nama Peminjam :  Masita nurjanah 
            No HP : 081210963501
            Waktu Peminjaman : 3 Mei 2025 (10.00-22.00)
            Oleh : IMS
            Untuk : Studi Banding 1
            List yang dipinjam :
            - Paket Kelas 2 (Kelas Gabung)
            - Paket Musyawarah 1
            - Paket Audio Portable 1', 'ticket_num'=> '12000337', 'phone'=>'081210963501'],
            ['closed_date'=>'10/04/25','student_id'=>'1204230033','service'=>'Paket Peminjaman', 'content'=>'Kode : 968
            Tgl pengajuan : 10 April 2025
            Nama Peminjam :  Rama Galih Tri S.  
            No HP : 082334361950
            Waktu Peminjaman : 03-04 Mei 2025 (08.00-22.00)
            Oleh : HMSI
            Untuk : Open Recruitment & Upgrading Staff Magang HMSI
            List yang dipinjam :
            - Paket Kelas 4 (2 Ruang Kelas Gabungan)
            - Paket Audio 1', 'ticket_num'=> '12000338', 'phone'=>'082334361950'],
            ['closed_date'=>'10/04/25','student_id'=>'1206230029','service'=>'Paket Peminjaman', 'content'=>'Kode : 969
            Tgl pengajuan : 10 April 2025
            Nama Peminjam :  Khosyi Kafi Kirdiad  
            No HP : 08970697248
            Waktu Peminjaman : 8 Mei 2025 (13.00-21.00)
            Oleh : Himasdata
            Untuk : Gathering Pengurus dan Staff Muda Himasdata
            List yang dipinjam :
            - Paket Aula 1', 'ticket_num'=> '12000339', 'phone'=>'08970697248'],
            ['closed_date'=>'10/04/25','student_id'=>'1101230014','service'=>'Paket Peminjaman', 'content'=>'Kode : 970
            Tgl pengajuan : 10 April 2025
            Nama Peminjam : Yenita Diah
            No HP : 082231557538
            Waktu Peminjaman : 19 April 2025 (08.00-22.00)
            Oleh : Hima Tesla
            Untuk : Rapat Kepengurusan Dan Foto Kabinet Hima Tesla
            List yang dipinjam :
            - Paket Kelas 2 (Kelas Bersekat)
            - Paket Lighthing 1', 'ticket_num'=> '12000340', 'phone'=>'082231557538'],
            ['closed_date'=>'11/04/25','student_id'=>'1203230124','service'=>'Paket Peminjaman', 'content'=>'Kode : 971
            Tgl pengajuan : 11 April 2025
            Nama Peminjam :  Agastya Ferdian P. 
            No HP : 081358249335
            Waktu Peminjaman : 9 Mei 2025 (15.00-19.00)
            Oleh : BEM
            Untuk : BATAS (BAHAS TUNTAS)
            List yang dipinjam :
            - Paket Aula 1
            - Paket Visual 1
            - Paket Duduk 4 set
            - Paket Listrik 1 set', 'ticket_num'=> '12000341', 'phone'=>'081358249335'],
            ['closed_date'=>'11/04/25','student_id'=>'1203230002','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab. Digital Start-Up (1.29) untuk Program Kerja Forum HIMA Interaktif (FORMATIF) pada 19 April 2025 hari Sabtu (11.00- 19.00)', 'ticket_num'=> '12000342', 'phone'=>'081395972004'],
            ['closed_date'=>'11/04/25','student_id'=>'1205230072','service'=>'Paket Peminjaman', 'content'=>'Kode : 972
            Tgl pengajuan : 11 April 2025
            Nama Peminjam :  Agung Andreas Silalahi 
            No HP : 081262777472
            Waktu Peminjaman : 20 April 2025 (10.00-15.00)
            Oleh : HMBD
            Untuk : Foto Panitia Diesnatalis Bisnis Digital
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000343', 'phone'=>'081262777472'],
            ['closed_date'=>'11/04/25','student_id'=>'1206220028','service'=>'Paket Peminjaman', 'content'=>'Kode : 973
            Tgl pengajuan : 11 April 2025
            Nama Peminjam :  Safinah Salmaa Al Anshory
            No HP : 0895370686939
            Waktu Peminjaman : 21-24 April 2025 (18.00-22.00)
            Oleh : HIMASDATA
            Untuk : After Party : Orientasi DS 2025 (Latihan)
            List yang dipinjam :
            - Paket Kelas 3 (Kelas Bersebelahan)
            - Paket Listrik 2 set', 'ticket_num'=> '12000344', 'phone'=>'0895370686939'],
            ['closed_date'=>'11/04/25','student_id'=>'1206220028','service'=>'Paket Peminjaman', 'content'=>'Kode : 974
            Tgl pengajuan : 11 April 2025
            Nama Peminjam :  Safinah Salmaa Al Anshory
            No HP : 0895370686939
            Waktu Peminjaman : 19 April 2025 (06.00-22.00)
            Oleh : HIMASDATA
            Untuk : After Party : Orientasi DS 2025 (Latihan)
            List yang dipinjam :
            - Paket Kelas 2
            - Paket Listrik 2 set', 'ticket_num'=> '12000345', 'phone'=>'0895370686939'],
            ['closed_date'=>'11/04/25','student_id'=>'1204220026','service'=>'Paket Peminjaman', 'content'=>'Kode : 975
            Tgl pengajuan : 11 April 2025
            Nama Peminjam :  Ahmad Ilman Nafia
            No HP : 0895620085162
            Waktu Peminjaman : 19 April 2025 (09.00-17.00)
            Oleh : UKM Telkom ART
            Untuk : Latihan Divisi Tari
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000346', 'phone'=>'0895620085162'],
            ['closed_date'=>'11/04/25','student_id'=>'1204220026','service'=>'Paket Peminjaman', 'content'=>'Kode : 976
            Tgl pengajuan : 11 April 2025
            Nama Peminjam :  Ahmad Ilman Nafia
            No HP : 0895620085162
            Waktu Peminjaman : 3 Mei 2025 (09.00-17.00)
            Oleh : UKM Telkom ART
            Untuk : Latihan Divisi Tari
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000347', 'phone'=>'0895620085162'],
            ['closed_date'=>'11/04/25','student_id'=>'1204220026','service'=>'Paket Peminjaman', 'content'=>'Kode : 977
            Tgl pengajuan : 11 April 2025
            Nama Peminjam :  Ahmad Ilman Nafia
            No HP : 0895620085162
            Waktu Peminjaman : 4 Mei 2025 (09.00-17.00)
            Oleh : UKM Telkom ART
            Untuk : Latihan Divisi Tari
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000348', 'phone'=>'0895620085162'],
            ['closed_date'=>'11/04/25','student_id'=>'1204220026','service'=>'Paket Peminjaman', 'content'=>'Kode : 978
            Tgl pengajuan : 11 April 2025
            Nama Peminjam :  Ahmad Ilman Nafia
            No HP : 0895620085162
            Waktu Peminjaman : 10 Mei 2025 (09.00-17.00)
            Oleh : UKM Telkom ART
            Untuk : Latihan Divisi Tari
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000349', 'phone'=>'0895620085162'],
            ['closed_date'=>'11/04/25','student_id'=>'1103230036','service'=>'Paket Peminjaman', 'content'=>'Kode : 979
            Tgl pengajuan : 11 April 2025
            Nama Peminjam :  M. Zavi Rohmatulloh
            No HP : 083123265535
            Waktu Peminjaman : 19 April 2025 (07.30-12.00)
            Oleh : UKKI
            Untuk : Grand Opening Mentoring Mahasiswa/i Muslim TUS
            List yang dipinjam :
            - Paket Komunikasi 2
            - Paket Musyawarah 1
            - Paket Visual 1', 'ticket_num'=> '12000350', 'phone'=>'083123265535'],
            ['closed_date'=>'11/04/25','student_id'=>'1101230014','service'=>'Paket Peminjaman', 'content'=>'Kode : 980
            Tgl pengajuan : 11 April 2025
            Nama Peminjam :  Yenita Diah P.
            No HP : 082231557538
            Waktu Peminjaman : 19 April 2025 (08.00-20.00)
            Oleh : HIMA TESLA
            Untuk : Rapat Kepengurusan dan Foto Kabinet HIMA
            List yang dipinjam :
            - Paket Kelas 2
            - Paket Lightning 2', 'ticket_num'=> '12000351', 'phone'=>'082231557538'],
            ['closed_date'=>'11/04/25','student_id'=>'1203220079','service'=>'Paket Peminjaman', 'content'=>'Kode : 981
            Tgl pengajuan : 11 April 2025
            Nama Peminjam : Michael Leonardo
            No HP : 087854726516
            Waktu Peminjaman : 25 Mei 2025 (08.00-20.00)
            Oleh : BEM
            Untuk : Rapat 100 Hari Kerja BEM 
            List yang dipinjam :
            - Paket Duduk 2
            - Paket Aula 1
            - Paket Musyawarah 1
            - Paket Listrik 1', 'ticket_num'=> '12000352', 'phone'=>'087854726516'],
            ['closed_date'=>'14/04/25','student_id'=>'1101230021','service'=>'Paket Peminjaman', 'content'=>'Kode : 983
            Tgl pengajuan : 14 April 2025
            Nama Peminjam : Santa Dinda P. 
            No HP : 082264868299
            Waktu Peminjaman : 22 April 2025 (17.00-22.00)
            Oleh : Hima Tesla
            Untuk : Rapat Makrab Hima Tesla
            List yang dipinjam :
            - Paket Kelas 3 ( 2 Ruang bersekat dan 1 Reguler)', 'ticket_num'=> '12000354', 'phone'=>'082264868299'],
            ['closed_date'=>'14/04/25','student_id'=>'1204230033','service'=>'Paket Peminjaman', 'content'=>'Kode : 984
            Tgl pengajuan : 14 April 2025
            Nama Peminjam : Rama  Galih Tri Sanjaya 
            No HP : 082334361950
            Waktu Peminjaman : 03 - 04 Mei 2025 (08.00-20.00)
            Oleh : HMSI
            Untuk : Open Recruitment Staff Magang HMSI
            List yang dipinjam :
            - Paket Kelas 4
            - Paket Audio 1', 'ticket_num'=> '12000355', 'phone'=>'082334361950'],
            ['closed_date'=>'14/04/25','student_id'=>'1204230033','service'=>'Paket Peminjaman', 'content'=>'Kode : 985
            Tgl pengajuan : 14 April 2025
            Nama Peminjam : Rama  Galih Tri Sanjaya 
            No HP : 082334361950
            Waktu Peminjaman : 10 Mei 2025 (08.00-20.00)
            Oleh : HMSI
            Untuk : Open Recruitment Staff Magang HMSI
            List yang dipinjam :
            - Paket Kelas 4 (kelas gabungan)
            - Paket Audio 1', 'ticket_num'=> '12000356', 'phone'=>'082334361950'],
            ['closed_date'=>'14/04/25','student_id'=>'1204230033','service'=>'Paket Peminjaman', 'content'=>'Kode : 986
            Tgl pengajuan : 14 April 2025
            Nama Peminjam : Rama  Galih Tri Sanjaya 
            No HP : 082334361950
            Waktu Peminjaman : 25 Mei 2025 (08.00-20.00)
            Oleh : HMSI
            Untuk : Upgrading Staff Magang HMSI
            List yang dipinjam :
            - Paket Aula 1
            - Paket Listrik 1', 'ticket_num'=> '12000357', 'phone'=>'082334361950'],
            ['closed_date'=>'14/04/25','student_id'=>'103072400046','service'=>'Legalisir KHS Mahasiswa', 'content'=>'Legalisir KHS Mahasiswa untuk beasiswa', 'ticket_num'=> '12000358', 'phone'=>'081255978502'],
            ['closed_date'=>'14/04/25','student_id'=>'1206230029','service'=>'Paket Peminjaman', 'content'=>'Kode : 987
            Tgl pengajuan : 14 April 2025
            Nama Peminjam :  Khosyi Kafi Kirdiad  
            No HP : 08970697248
            Waktu Peminjaman : 29 Mei 2025 (08.00-22.00)
            Oleh : Himasdata
            Untuk : Gathering Pengurus dan Staff Muda Himasdata 2025
            List yang dipinjam :
            - Paket Aula 1
            - Paket Visual 1
            - Paket Listrik 1', 'ticket_num'=> '12000359', 'phone'=>'08970697248'],
            ['closed_date'=>'14/04/25','student_id'=>'103072400046','service'=>'Legalisir KHS Mahasiswa', 'content'=>'Tanda tangan kemahasiswaan untuk beasiswa', 'ticket_num'=> '12000360', 'phone'=>'081255978502'],
            ['closed_date'=>'14/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 988
            Tgl pengajuan : 14 April 2025
            Nama Peminjam : Athaya Alfarabi
            No HP : 0878551492367
            Waktu Peminjaman : 10 & 11 Mei 2025 (08.00-16.00)
            Oleh : Himpunan Mahasiswa Sains Data
            Untuk : Dolanan Data 2025
            List yang dipinjam :
            - Paket Kelas 5
            - Paket Listrik 2', 'ticket_num'=> '12000361', 'phone'=>'087855149236'],
            ['closed_date'=>'14/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 989
            Tgl pengajuan : 14 April 2025
            Nama Peminjam : Athaya Alfarabi
            No HP : 0878551492367
            Waktu Peminjaman : 17 & 18 Mei 2025 (08.00-16.00)
            Oleh : Himpunan Mahasiswa Sains Data
            Untuk : Dolanan Data 2025
            List yang dipinjam :
            - Paket Kelas 5
            - Paket Listrik 2', 'ticket_num'=> '12000362', 'phone'=>'087855149236'],
            ['closed_date'=>'14/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 990
            Tgl pengajuan : 14 April 2025
            Nama Peminjam : Athaya Alfarabi
            No HP : 0878551492367
            Waktu Peminjaman : 24 Mei 2025 (06.00-20.00)
            Oleh : Himpunan Mahasiswa Sains Data
            Untuk : Dolanan Data 2025
            List yang dipinjam :
            - Paket Kursi 1
            - Paket Audio Potable 1
            - Paket Visual 2', 'ticket_num'=> '12000363', 'phone'=>'087855149236'],
            ['closed_date'=>'14/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 991
            Tgl pengajuan : 14 April 2025
            Nama Peminjam : Athaya Alfarabi
            No HP : 0878551492367
            Waktu Peminjaman : 30 Mei 2025 (18.00-22.00)
            Oleh : Himpunan Mahasiswa Sains Data
            Untuk : Fit N Fun 2025
            List yang dipinjam :
            - Paket Aula 1', 'ticket_num'=> '12000364', 'phone'=>'087855149236'],
            ['closed_date'=>'14/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 992
            Tgl pengajuan : 14 April 2025
            Nama Peminjam : Athaya Alfarabi
            No HP : 0878551492367
            Waktu Peminjaman : 31 Mei 2025 (13.00-21.00)
            Oleh : Himpunan Mahasiswa Sains Data
            Untuk : Fit N Fun 2025
            List yang dipinjam :
            - Paket Aula 1
            - Paket Kursi 1
            - Paket Visual 1
            - Paket Lighting 1', 'ticket_num'=> '12000365', 'phone'=>'087855149236'],
            ['closed_date'=>'15/04/25','student_id'=>'1103230003','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'Proposal Pengajuan Dana Elektro Berbagi', 'ticket_num'=> '12000366', 'phone'=>'081359016632'],
            ['closed_date'=>'15/04/25','student_id'=>'1204230043','service'=>'Paket Peminjaman', 'content'=>'Kode : 993
            Tgl pengajuan : 15 April 2025
            Nama Peminjam : Ahmad Naufalianto
            No HP : 085228001836
            Waktu Peminjaman : 26 April 2025 (09.00-18.00)
            Oleh : Himpunan Mahasiswa Sistem Informasi 
            Untuk : Webinar Career Development HMSI X CDC
            List yang dipinjam :
            - Paket Kelas 1
            - Paket Listrik 1', 'ticket_num'=> '12000367', 'phone'=>'085228001836'],
            ['closed_date'=>'15/04/25','student_id'=>'1202220421','service'=>'Paket Peminjaman', 'content'=>'Kode : 994
            Tgl pengajuan : 15 April 2025
            Nama Peminjam : Peres Hendri V.
            No HP : 085159452235
            Waktu Peminjaman : 26 April 2025 (07.00-18.00)
            Oleh : Himpunan Mahasiswa Teknologi Informasi (HIMATISI)
            Untuk : Sosialisasi Staff MIHATISI
            List yang dipinjam :
            - Paket Kelas 2 (Ruang Kelas Bersekat)
            - Paket Audio Potable 1', 'ticket_num'=> '12000368', 'phone'=>'085159452235'],
            ['closed_date'=>'15/04/25','student_id'=>'1202220421','service'=>'Paket Peminjaman', 'content'=>'Kode : 995
            Tgl pengajuan : 15 April 2025
            Nama Peminjam : Peres Hendri V.
            No HP : 085159452235
            Waktu Peminjaman : 27 April 2025 (13.00-21.00)
            Oleh : Himpunan Mahasiswa Teknologi Informasi (HIMATISI)
            Untuk : IT Sport Day - Futsal
            List yang dipinjam :
            - Lapangan Hybrid 1', 'ticket_num'=> '12000369', 'phone'=>'085159452235'],
            ['closed_date'=>'15/04/25','student_id'=>'1202230003','service'=>'Paket Peminjaman', 'content'=>'Kode : 996
            Tgl pengajuan : 15 April 2025
            Nama Peminjam : Kevin Imanuel S.
            No HP : 082236039191
            Waktu Peminjaman : 22 April 2025 (19.00-22.00)
            Oleh : Unit Kegiatan Kerohanian Kristen (UKKK) Tel U Surabaya
            Untuk : Persiapan PAW Ibadah Perayaan Paskah UK3 2025
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000370', 'phone'=>'082236039191'],
            ['closed_date'=>'15/04/25','student_id'=>'1205230035','service'=>'Paket Peminjaman', 'content'=>'Kode : 997
            Tgl pengajuan : 15 April 2025
            Nama Peminjam : Muhamad Adhelio
            No HP : 08885872709
            Waktu Peminjaman : 26 April 2025 (12.00-17.00)
            Oleh : Himpunan Mahasiswa Bisnis Digital 
            Untuk : Take Video Profile Himpunan Mahasiswa Bisnis Digital
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000371', 'phone'=>'08885872709'],
            ['closed_date'=>'15/04/25','student_id'=>'1205230035','service'=>'Paket Peminjaman', 'content'=>'Peminjaman Lab. Digital Start-Up (1.29) untuk Take Video Profile HIMABD pada 26 April 2025 hari Sabtu (06.00- 12.00)', 'ticket_num'=> '12000372', 'phone'=>'08885872709'],
            ['closed_date'=>'15/04/25','student_id'=>'103082400040','service'=>'Peminjaman Orbit', 'content'=>'Peminjaman Orbit untuk Kuliah Tamu pada Selasa, 22 April 2025 s.d 23 April 2025 (PRODI RPL)', 'ticket_num'=> '12000373', 'phone'=>'087879661560'],
            ['closed_date'=>'15/04/25','student_id'=>'1201220449','service'=>'Paket Peminjaman', 'content'=>'Kode : 998
            Tgl pengajuan : 15 April 2025
            Nama Peminjam : Farhan Nugraha
            No HP : 081238474150
            Waktu Peminjaman : 27 April 2025 (09.00-19.00)
            Oleh : BEM
            Untuk : Forum HIMA Interaktif (FORMATIF)
            List yang dipinjam :
            - Paket Kelas 1
            - Paket Listrik 1
            - Paket Audio Potable 1
            - Paket HDMI 1', 'ticket_num'=> '12000374', 'phone'=>'081238474150'],
            ['closed_date'=>'15/04/25','student_id'=>'103082400040','service'=>'Paket Peminjaman', 'content'=>'Kode : 999
            Tgl pengajuan : 15 April 2025
            Nama Peminjam : Muhamad Rozi
            No HP : 087879661560
            Waktu Peminjaman : 22 April 2025 (06.00-18.00)
            Oleh : Prodi RPL 
            Untuk : Kuliah Tamu
            List yang dipinjam :
            - Paket Audio Portable 1
            - Paket Audio Lapangan 1
            - Paket Streaming 1
            - Paket Listrik 1
            - Paket Visual 1
            - Paket HDMI 1', 'ticket_num'=> '12000375', 'phone'=>'087879661560'],
            ['closed_date'=>'15/04/25','student_id'=>'1205230078','service'=>'Paket Peminjaman', 'content'=>'Kode : 1000
            Tgl pengajuan : 15 April 2025
            Nama Peminjam : Mochammad Mishbahuddin
            No HP : 081331924232
            Waktu Peminjaman : 21 - 22 Mei 2025 (07.00-22.00)
            Oleh : Himpunan Mahasiswa Bisnis Digital
            Untuk : Digbizian Sport Day
            List yang dipinjam :
            - Lapangan Hybrid 1
            - Net Voli 1
            - Bola Basket 4
            - Bola Voli 4
            - Bola Futsal 4
            - Kabel Olor 2
            - Mic 2
            - Speaker 2', 'ticket_num'=> '12000376', 'phone'=>'081331924232'],
            ['closed_date'=>'15/04/25','student_id'=>'1206230014','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HIMASDATA - Proposal Pengajuan Dana Dolanan Data Batch 5', 'ticket_num'=> '12000377', 'phone'=>'082131206662'],
            ['closed_date'=>'16/04/25','student_id'=>'1204230070','service'=>'Paket Peminjaman', 'content'=>'Kode : 1001
            Tgl pengajuan : 16 April 2025
            Nama Peminjam : Rezal Ihsanu M
            No HP : 081322889145
            Waktu Peminjaman : 23 - 26 April 2025 (12.00-21.30)
            Oleh : UKM Badminton TUS
            Untuk : Acara Turnamen TUSBC Master 2025
            List yang dipinjam :
            - Meja Kelas 8', 'ticket_num'=> '12000378', 'phone'=>'081322889145'],
            ['closed_date'=>'16/04/25','student_id'=>'1103230021','service'=>'Paket Peminjaman', 'content'=>'Kode : 1003
            Tgl pengajuan : 16 April 2025
            Nama Peminjam : Mochammad Kharisudin 
            No HP : 087816567208 
            Waktu Peminjaman : 2 Mei 2025 (17.00-21.00)
            Oleh : Himpunan Mahasiswa Elektro
            Untuk : SET UP OPREC STAF MAGANG HME TUS 2025
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000380', 'phone'=>'087816567208'],
            ['closed_date'=>'16/04/25','student_id'=>'1103230021','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab. Power and Electronics untuk Kegiatan Sosialisasi oprec staf magang HME TUS 2025 pada 19 April 2025 hari Sabtu (08.00- 21.00)', 'ticket_num'=> '12000381', 'phone'=>'087816567208'],
            ['closed_date'=>'16/04/25','student_id'=>'1103230027','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HME - Proposal Pengajuan Dana Elektro Berbagi', 'ticket_num'=> '12000382', 'phone'=>'082301043405'],
            ['closed_date'=>'16/04/25','student_id'=>'1205230035','service'=>'Paket Peminjaman', 'content'=>'Kode : 1004
            Tgl pengajuan : 16 April 2025
            Nama Peminjam : Muhamad Adhelio 
            No HP : 08885872709
            Waktu Peminjaman : 26 April 2025 (07.00-17.00)
            Oleh : Himpunan Mahasiswa Bisnis Digital
            Untuk : Take Video Profile Himpunan Mahasiswa Bisnis Digital
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000383', 'phone'=>'08885872709'],
            ['closed_date'=>'16/04/25','student_id'=>'1205230035','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab. StarUp, untuk kegiatan rapat kuliah tamu. Pada 22 April 2025 hari Selasa (18.00 - 19.00)', 'ticket_num'=> '12000384', 'phone'=>'08885872709'],
            ['closed_date'=>'16/04/25','student_id'=>'1104230060','service'=>'Paket Peminjaman', 'content'=>'Kode : 1005
            Tgl pengajuan : 16 April 2025
            Nama Peminjam : Pesta Demokrasi Daeli
            No HP : 081217382090
            Waktu Peminjaman : 26 April 2025 (08.00-12.00)
            Oleh : BEM
            Untuk : Olahraga Bersama
            List yang dipinjam :
            - Lapangan Hybrid 1', 'ticket_num'=> '12000385', 'phone'=>'081217382090'],
            ['closed_date'=>'16/04/25','student_id'=>'1104230060','service'=>'Paket Peminjaman', 'content'=>'Kode : 1006
            Tgl pengajuan : 16 April 2025
            Nama Peminjam : Pesta Demokrasi Daeli
            No HP : 081217382090
            Waktu Peminjaman : 26 April 2025 (08.00-12.00)
            Oleh : BEM
            Untuk : Olahraga Bersama
            List yang dipinjam :
            - Paket Audio Potable 1
            - Paket Listrik 1', 'ticket_num'=> '12000386', 'phone'=>'081217382090'],
            ['closed_date'=>'16/04/25','student_id'=>'1205230035','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab. StarUp. Pada 22 April 2025 hari Jumat (19.00 - 20.00)', 'ticket_num'=> '12000387', 'phone'=>'08885872709'],
            ['closed_date'=>'17/04/25','student_id'=>'1204230113','service'=>'Paket Peminjaman', 'content'=>'Kode : 1007
            Tgl pengajuan : 17 April 2025
            Nama Peminjam : Fransisca Aurelia
            No HP : 082140741749
            Waktu Peminjaman : 26 April 2025 (08.00-12.00)
            Oleh : BEM
            Untuk : Halal Bihalal BEM KEMA Telkom University Surabaya
            List yang dipinjam :
            - Paket Kelas 2 (Ruang Kelas Bersekat)
            - Paket Audio Potable 1', 'ticket_num'=> '12000388', 'phone'=>'082140741749'],
            ['closed_date'=>'17/04/25','student_id'=>'102052400041','service'=>'Paket Peminjaman', 'content'=>'Kode : 1008
            Tgl pengajuan : 17 April 2025
            Nama Peminjam : Andy Muhammad Rizkyawan
            No HP : 081543457290
            Waktu Peminjaman :  1-5 Oktober 2025 (08.00-22.00)
            Oleh : IMS
            Untuk : PAGESSI (PAGELARAN SENI DAN BUDAYA)
            List yang dipinjam :
            - Paket Aula 1', 'ticket_num'=> '12000389', 'phone'=>'081543457290'],
            ['closed_date'=>'17/04/25','student_id'=>'1101230021','service'=>'Paket Peminjaman', 'content'=>'Kode : 1009
            Tgl pengajuan : 17 April 2025
            Nama Peminjam : Santa Dinda P.
            No HP : 082264868299
            Waktu Peminjaman : 27 April 2025 (10.00-18.00)
            Oleh : Hima Tesla
            Untuk : Rapat Makrab Hima Tesla
            List yang dipinjam :
            - Paket Kelas 3 ( 2 Ruang bersekat dan 1 Reguler)', 'ticket_num'=> '12000390', 'phone'=>'082264868299'],
            ['closed_date'=>'17/04/25','student_id'=>'103102430004','service'=>'Paket Peminjaman', 'content'=>'Kode : 1010
            Tgl pengajuan : 17 April 2025
            Nama Peminjam : Safa Ayu Artanti
            No HP : 08982112701
            Waktu Peminjaman : 1 Juni 2025 (13.00-21.00)
            Oleh : HIMASDATA
            Untuk : FIT N FUN 2025
            List yang dipinjam :
            - Paket Aula 1
            - Paket Kursi 1
            - Paket Visual 1
            - Paket Lighting 1', 'ticket_num'=> '12000391', 'phone'=>'08982112701'],
            ['closed_date'=>'10/02/25','student_id'=>'1101210536','service'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri', 'content'=>'Meminta pengembalian dana semester 8 (genap) karena mahasiswa ybs coumloude', 'ticket_num'=> '12000136', 'phone'=>'087743216986'],
            ['closed_date'=>'10/02/25','student_id'=>'1102190003','service'=>'Legalisir Ijazah dan Transkrip Nilai Akhir', 'content'=>'membawa 2 fc (legalisir dan transkrip)', 'ticket_num'=> '12000135', 'phone'=>'081511728615'],
            ['closed_date'=>'24/04/25','student_id'=>'1204210168','service'=>'Pengajuan Surat Pengantar Mata Kuliah', 'content'=>'Mata Kuliah, Rekayasa proses Bisnis, Dosen Bu Raulia', 'ticket_num'=> '12000431', 'phone'=>'085361211173'],
            ['closed_date'=>'24/04/25','student_id'=>'1204210146','service'=>'Pengajuan Surat Pengantar Mata Kuliah', 'content'=>'Mata Kuliah, Rekayasa proses Bisnis, Dosen Bu Raulia', 'ticket_num'=> '12000432', 'phone'=>'087803142439'],
            ['closed_date'=>'21/04/25','student_id'=>'1104238063','service'=>'Paket Peminjaman', 'content'=>'Kode : 1012
            Tgl pengajuan : 21 April 2025
            Nama Peminjam : Julliza Nazhifa A.
            No HP : 082143566975
            Waktu Peminjaman : 28 April 2025 (17.00-22.00)
            Oleh : BEM
            Untuk : FORUM KESEPAKATAN KETUA PKKMB TUS 2025
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000397', 'phone'=>'082143566975'],
            ['closed_date'=>'21/04/25','student_id'=>'1104238063','service'=>'Paket Peminjaman', 'content'=>'Kode : 1013
            Tgl pengajuan : 21 April 2025
            Nama Peminjam : Julliza Nazhifa A.
            No HP : 082143566975
            Waktu Peminjaman : 1 Mei 2025 (07.00-22.00)
            Oleh : BEM
            Untuk : DIKLAT PANITIA DIREKTUR CUP 2025
            List yang dipinjam :
            - Paket Kelas 2 (Ruang Bersekat)
            - Paket Audio Portable 1 ', 'ticket_num'=> '12000398', 'phone'=>'082143566975'],
            ['closed_date'=>'21/04/25','student_id'=>'1204230081','service'=>'Paket Peminjaman', 'content'=>'Kode : 1014
            Tgl pengajuan : 21 April 2025
            Nama Peminjam : M. Zaki Winanda P. F.
            No HP : 085975304733
            Waktu Peminjaman : 28 April 2025 (18.00-22.00)
            Oleh : HMSI
            Untuk : Rapat Brain Challenge
            List yang dipinjam :
            - Paket Kelas 2 (Ruang Bersekat)', 'ticket_num'=> '12000399', 'phone'=>'085975304733'],
            ['closed_date'=>'21/04/25','student_id'=>'1202239001','service'=>'Pengajuan Surat Tugas', 'content'=>'Konfirmasi Surat Tugas Lomba Entrepreneurs Creative Challenge 2025', 'ticket_num'=> '12000400', 'phone'=>'087791004790'],
            ['closed_date'=>'22/04/25','student_id'=>'1205230035','service'=>'Paket Peminjaman', 'content'=>'Kode : 1015
            Tgl pengajuan : 22 April 2025
            Nama Peminjam : Muhammad Adhelio
            No HP : 08885872709
            Waktu Peminjaman :03 Mei 2025 (09.00-14.00)
            Oleh : HMBD
            Untuk : Foto Korsa HMBD
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000401', 'phone'=>'08885872709'],
            ['closed_date'=>'23/04/25','student_id'=>'1104230056','service'=>'Pengajuan Surat Pengantar Mata Kuliah', 'content'=>'Mata Kuliah Penelitian Operasional 2, Dosen Bu Tya', 'ticket_num'=> '12000417', 'phone'=>'082131964413'],
            ['closed_date'=>'23/04/25','student_id'=>'1104230025','service'=>'Pengajuan Surat Pengantar Mata Kuliah', 'content'=>'Mata Kuliah Penelitian Operasional 2, Dosen Bu Tya', 'ticket_num'=> '12000419', 'phone'=>'081515470508'],
            ['closed_date'=>'23/04/25','student_id'=>'1104220042','service'=>'Pengajuan Surat Pengantar Mata Kuliah', 'content'=>'Mata Kuliah Penelitian Operasional 2, Dosen Bu Tya', 'ticket_num'=> '12000421', 'phone'=>'085655222356'],
            ['closed_date'=>'22/04/25','student_id'=>'1101230019','service'=>'Paket Peminjaman', 'content'=>'Kode : 1016
            Tgl pengajuan : 22 April 2025
            Nama Peminjam : Berliando Karel
            No HP : 081936781515
            Waktu Peminjaman :01 Mei 2025 (08.00-15.00)
            Oleh : DPM
            Untuk : Rapat kerja DPM 2025
            List yang dipinjam :
            - Paket Kelas 2', 'ticket_num'=> '12000405', 'phone'=>'081936781515'],
            ['closed_date'=>'22/04/25','student_id'=>'1203230038','service'=>'Paket Peminjaman', 'content'=>'Kode : 1017
            Tgl pengajuan : 22 April 2025
            Nama Peminjam : Khansa Nailah Anjani
            No HP : 08115540119
            Waktu Peminjaman : 31 Mei - 1 Juni 2025 (06.00-18.00)
            Oleh : HMIF
            Untuk : I Care 2025
            List yang dipinjam :
            - Paket Listrik 2
            - Paket Visual 1
            - paket HDMI 1
            - paket kelas 2 ( Req ruang bersekat 2.25-2.26, 2.23-2.24 )
            - paket audio Portable 1 ', 'ticket_num'=> '12000406', 'phone'=>'08115540119'],
            ['closed_date'=>'23/04/25','student_id'=>'103072400082','service'=>'Paket Peminjaman', 'content'=>'Kode : 1018
            Tgl pengajuan : 23 April 2025
            Nama Peminjam : Andi Muh Alief A
            No HP : 082190342225
            Waktu Peminjaman :01 Mei 2025 (08.00-18.00)
            Oleh : IMS
            Untuk : Studi Banding 1
            List yang dipinjam :
            - Paket Kelas 2 (Kelas Gabung)
            - Paket Musyawarah 1
            - Paket Audio Portable 1', 'ticket_num'=> '12000407', 'phone'=>'082190342225'],
            ['closed_date'=>'23/04/25','student_id'=>'104052400078','service'=>'Paket Peminjaman', 'content'=>'Kode : 1019
            Tgl pengajuan : 23 April 2025
            Nama Peminjam : Aisyah Cathrina E
            No HP : 085755983211
            Waktu Peminjaman : 9 Mei (18.00-21.00) - 10 Mei (09.00-20.00) 2025 
            Oleh : Himpunan Mahasiswa Bisnis Digital
            Untuk : Seleksi Family 100 Dies Natalis Bisnis Digital
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000408', 'phone'=>'085755983211'],
            ['closed_date'=>'23/04/25','student_id'=>'1103210014','service'=>'Legalisir KHS Mahasiswa', 'content'=>'legalisir khs untuk beasiswa ', 'ticket_num'=> '12000409', 'phone'=>'082232462122'],
            ['closed_date'=>'23/04/25','student_id'=>'1202220020','service'=>'Paket Peminjaman', 'content'=>'Kode : 1020
            Tgl pengajuan : 23 April 2025
            Nama Peminjam : Siti Mayla Aliyah
            No HP : 082260221250
            Waktu Peminjaman :01 Mei 2025 (09.00-22.00)
            Oleh : HIMATISI
            Untuk : Sosialisasi Staf Muda
            List yang dipinjam :
            - Paket Musyawarah 1', 'ticket_num'=> '12000410', 'phone'=>'082260221250'],
            ['closed_date'=>'23/04/25','student_id'=>'1203220128','service'=>'Paket Peminjaman', 'content'=>'Kode : 1021
            Tgl pengajuan : 23 April 2025
            Nama Peminjam : Friand Jacnus M.
            No HP : 082116842205
            Waktu Peminjaman :02 Mei 2025 (17.00-22.00)
            Oleh : HIMAIF
            Untuk : Welcome Party Staff Muda Himpunan Mahasiswa Informatika
            List yang dipinjam :
            - Paket Kelas 2 (Ruang Bersekat)', 'ticket_num'=> '12000411', 'phone'=>'082116842205'],
            ['closed_date'=>'23/04/25','student_id'=>'1103230009','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HME - Proposal Pengajuan Dana Oprec Staf Magang 2025', 'ticket_num'=> '12000412', 'phone'=>'085668068219'],
            ['closed_date'=>'23/04/25','student_id'=>'1103230009','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HME - Proposal Pengajuan Dana Voltmeet', 'ticket_num'=> '12000413', 'phone'=>'085668068219'],
            ['closed_date'=>'23/04/25','student_id'=>'1103230009','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HME - Proposal Kegiatan Oprec Staf Muda HME TUS', 'ticket_num'=> '12000414', 'phone'=>'085668068219'],
            ['closed_date'=>'24/04/25','student_id'=>'1104230015','service'=>'Pengajuan Surat Pengantar Mata Kuliah', 'content'=>'Mata Kuliah Penelitian Operasional 2, Dosen Bu Tya', 'ticket_num'=> '12000429', 'phone'=>'085850155432'],
            ['closed_date'=>'24/04/25','student_id'=>'1104230003','service'=>'Pengajuan Surat Pengantar Mata Kuliah', 'content'=>'Mata Kuliah Penelitian Operasional 2, Dosen Bu Tya', 'ticket_num'=> '12000430', 'phone'=>'0895339814071'],
            ['closed_date'=>'23/04/25','student_id'=>'1104230025','service'=>'Pengajuan Surat Pengantar Mata Kuliah', 'content'=>'Mata Kuliah Manajemen Rantai Pasok Global, Dosen Bu Granita', 'ticket_num'=> '12000418', 'phone'=>'085855055753'],
            ['closed_date'=>'23/04/25','student_id'=>'1105220012','service'=>'Pengajuan Surat Pengantar Mata Kuliah', 'content'=>'Mata Kuliah Manajemen Rantai Pasok Global, Dosen Bu Granita', 'ticket_num'=> '12000420', 'phone'=>'085790808044'],
            ['closed_date'=>'03/02/25','student_id'=>'1102210002','service'=>'Pengajuan Surat Pengantar Mata Kuliah', 'content'=>'Konfirmasi terkait itenticate terlambat dan pengumpulan revisi menggunakan itenticate lama dan revisi tidak jauh beda dengan bab 6 nya, revisi bab 4 banyak dan dipisah bab 4 dan 5 lalu bab 6 kesimpulan', 'ticket_num'=> '12000076', 'phone'=>'081252323420'],
            ['closed_date'=>'23/04/25','student_id'=>'1204230082','service'=>'Paket Peminjaman', 'content'=>'Kode : 1022
            Tgl pengajuan : 24 April 2025
            Nama Peminjam : Aditya Wahyu H.
            No HP : 082132557159
            Waktu Peminjaman :26 - 27 Mei 2025 (15.00-20.00)
            Oleh : DPM
            Untuk : Kongres Mahasiswa
            List yang dipinjam :
            - Paket Aula 1', 'ticket_num'=> '12000426', 'phone'=>'082132557159'],
            ['closed_date'=>'04/02/25','student_id'=>'1205222089','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'From Permohonan Aktif Kuliah ', 'ticket_num'=> '12000081', 'phone'=>'089521662921'],
            ['closed_date'=>'04/02/25','student_id'=>'1104220003','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'Form Permohonan Aktif Kuliah', 'ticket_num'=> '12000082', 'phone'=>'085733941724'],
            ['closed_date'=>'04/02/25','student_id'=>'1204200061','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'Form Permohonan Aktif Kuliah', 'ticket_num'=> '12000084', 'phone'=>'087750591441'],
            ['closed_date'=>'04/02/25','student_id'=>'1203210092','service'=>'Pengajuan Aktif Kuliah Kembali', 'content'=>'Form Permohonan Aktif Kuliah', 'ticket_num'=> '12000085', 'phone'=>'081362815958'],
            ['closed_date'=>'24/04/25','student_id'=>'1204230115','service'=>'Pengajuan Cuti', 'content'=>'Pak ilham, management rantai pasok ', 'ticket_num'=> '12000433', 'phone'=>''],
            ['closed_date'=>'24/04/25','student_id'=>'1103230002','service'=>'Paket Peminjaman', 'content'=>'Kode : 1023
            Tgl pengajuan : 24 April 2025
            Nama Peminjam : Pedro Benardus B. 
            No HP : 085159886064
            Waktu Peminjaman : 6-8 Juni 2025 (08.00-22.00)
            Oleh : KMK
            Untuk : Studi banding KMK
            List yang dipinjam :
            - Paket Aula 1
            - Paket Listrik 1
            - Paket Duduk 2 
            - Paket Lighting 1
            - Paket HDMI 1', 'ticket_num'=> '12000434', 'phone'=>''],
            ['closed_date'=>'25/04/25','student_id'=>'1205230036','service'=>'Paket Peminjaman', 'content'=>'Kode : 1024
            Tgl pengajuan : 25 April 2025
            Nama Peminjam : Lailia K.
            No HP : 081352232253
            Waktu Peminjaman : 16 - 17 Mei 2025 (06.30-14.00)
            Oleh : HMBD
            Untuk : Digbizian Sport Day
            List yang dipinjam :
            - Paket Ruang Kelas 1
            - Paket Streaming 1
            - paket Listrik 1 ', 'ticket_num'=> '12000435', 'phone'=>''],
            ['closed_date'=>'25/04/25','student_id'=>'1204220027','service'=>'Paket Peminjaman', 'content'=>'Kode : 1025
            Tgl pengajuan : 25 April 2025
            Nama Peminjam : Naomi Benevolence S.
            No HP : 082245666100
            Waktu Peminjaman : 02 Mei 2025 (11.00-13.00)
            Oleh : UKKK
            Untuk : Rapat Pleno UKKK Telkom University Surabaya
            List yang dipinjam :
            - Paket Ruang Kelas 1
            ', 'ticket_num'=> '12000436', 'phone'=>''],
            ['closed_date'=>'25/04/25','student_id'=>'1204220027','service'=>'Paket Peminjaman', 'content'=>'Kode : 1026
            Tgl pengajuan : 25 April 2025
            Nama Peminjam : Naomi Benevolence S.
            No HP : 082245666100
            Waktu Peminjaman : 09 Mei 2025 (11.00-13.00)
            Oleh : UKKK
            Untuk : Persekutuan Doa Rutin UKKK Telkom University Surabaya
            List yang dipinjam :
            - Paket Ruang Kelas 2 (Req Ruangan bersekat)
            - Paket Audio Portable 1

            ', 'ticket_num'=> '12000437', 'phone'=>''],
            ['closed_date'=>'25/04/25','student_id'=>'1204220027','service'=>'Paket Peminjaman', 'content'=>'Kode : 1027
            Tgl pengajuan : 25 April 2025
            Nama Peminjam : Naomi Benevolence S.
            No HP : 082245666100
            Waktu Peminjaman : 23 Mei 2025 (11.00-13.00)
            Oleh : UKKK
            Untuk : Persekutuan Doa Rutin UKKK Telkom University Surabaya
            List yang dipinjam :
            - Paket Ruang Kelas 2 (Req Ruangan bersekat)
            - Paket Audio Portable 1', 'ticket_num'=> '12000438', 'phone'=>''],
            ['closed_date'=>'25/04/25','student_id'=>'1204220002','service'=>'Paket Peminjaman', 'content'=>'Kode : 1028
            Tgl pengajuan : 25 April 2025
            Nama Peminjam : Ahmad Pasha M
            No HP : 0895337010477
            Waktu Peminjaman : 06-08 Juni 2025 (07.00-21.00)
            Oleh : DPM
            Untuk : Kongres Ormawa UKM 2025
            List yang dipinjam :
            - Paket Aula 1
            - Paket Listrik 1 
            - Paket Komunikasi 2 
            - Paket Musyawarah 1 
            - Paket Visual 3  
            - Paket Duduk 4 
            - Splitter 3', 'ticket_num'=> '12000439', 'phone'=>''],
            ['closed_date'=>'25/04/25','student_id'=>'1204230100','service'=>'Paket Peminjaman', 'content'=>'Kode : 1029
            Tgl pengajuan : 25 April 2025
            Nama Peminjam : Moch. Fahrul F. D.
            No HP : 081357462021
            Waktu Peminjaman : 18 Juni 2025 (18.00-22.00)
            Oleh : HMSI
            Untuk : Rapat Brain Challenge 
            List yang dipinjam :
            - Paket Kelas 2 (Req ruangan bersekat)', 'ticket_num'=> '12000440', 'phone'=>''],
            ['closed_date'=>'25/04/25','student_id'=>'1204230100','service'=>'Paket Peminjaman', 'content'=>'Kode : 1030
            Tgl pengajuan : 28 April 2025
            Nama Peminjam : Moch. Fahrul F. D.
            No HP : 081357462021
            Waktu Peminjaman : 16 Juni 2025 (18.00-22.00)
            Oleh : HMSI
            Untuk : Technical Meeting Brain Challenge 
            List yang dipinjam :
            - Paket Kelas 2 (Req ruangan bersekat)', 'ticket_num'=> '12000441', 'phone'=>''],
            ['closed_date'=>'25/04/25','student_id'=>'1204230100','service'=>'Paket Peminjaman', 'content'=>'Kode : 1031
            Tgl pengajuan : 28 April 2025
            Nama Peminjam : Moch. Fahrul F. D.
            No HP : 081357462021
            Waktu Peminjaman : 20 Juni 2025 (06.00-22.00)
            Oleh : HMSI
            Untuk : Gladi Bersih Brain Challenge 
            List yang dipinjam :
            - Paket Aula 1', 'ticket_num'=> '12000442', 'phone'=>''],
            ['closed_date'=>'25/04/25','student_id'=>'1104230060','service'=>'Paket Peminjaman', 'content'=>'Kode : 1032
            Tgl pengajuan : 28 April 2025
            Nama Peminjam : Pesta Demokrasi D.
            No HP : 81217382090
            Waktu Peminjaman : 10 Mei 2025 (08.00-15.00)
            Oleh : BEM
            Untuk : Olahraga Bersama
            List yang dipinjam :
            - Lapangan Hybrid', 'ticket_num'=> '12000443', 'phone'=>''],
            ['closed_date'=>'25/04/25','student_id'=>'1104230060','service'=>'Paket Peminjaman', 'content'=>'Kode : 1033
            Tgl pengajuan : 28 April 2025
            Nama Peminjam : Pesta Demokrasi D.
            No HP : 81217382090
            Waktu Peminjaman : 10 Mei 2025 (08.00-15.00)
            Oleh : BEM
            Untuk : Olahraga Bersama
            List yang dipinjam :
            - Paket Audio Potable 1
            - Paket Listrik 1', 'ticket_num'=> '12000444', 'phone'=>''],
            ['closed_date'=>'03/02/25','student_id'=>'1204200160','service'=>'Pengajuan SK Tugas Akhir', 'content'=>'Case belum mendaftar sidang terkait dosbing 1 pada SKTA belum terganti dan baru mendaftar pada tanggal 30 Januari 2025 lalu approval dosbing 1 pengganti pada 7 Januari 2025', 'ticket_num'=> '12000078', 'phone'=>'081332888588'],
            ['closed_date'=>'28/04/25','student_id'=>'1202220020','service'=>'Paket Peminjaman', 'content'=>'Kode : 1020
            Tgl pengajuan : 23 April 2025
            Nama Peminjam : Siti Mayla Aliyah
            No HP : 082260221250
            Waktu Peminjaman :01 Mei 2025 (09.00-22.00)
            Oleh : HIMATISI
            Untuk : Sosialisasi Staf Muda
            List yang dipinjam :
            - Paket Kelas 2 (Gabungan)
            - Paket Musyawarah 1', 'ticket_num'=> '12000446', 'phone'=>''],
            ['closed_date'=>'29/04/25','student_id'=>'1204230051','service'=>'Paket Peminjaman', 'content'=>'Kode : 1035
            Tgl pengajuan : 29 April 2025
            Nama Peminjam : Ahmad Nunu G.
            No HP : 08815523119
            Waktu Peminjaman :22 Juni 2025 (08.00-22.00)
            Oleh : HMSI
            Untuk : Rapat Evaluasi HMSI
            List yang dipinjam :
            - Paket Aula 1
            - Paket Listrik 1', 'ticket_num'=> '12000448', 'phone'=>''],
            ['closed_date'=>'29/04/25','student_id'=>'1204230082','service'=>'Paket Peminjaman', 'content'=>'Kode : 1036
            Tgl pengajuan : 29 April 2025
            Nama Peminjam : Aditya Wahyu H.
            No HP : 082132557159
            Waktu Peminjaman : 13-15 Juni 2025 (07.00-21.00)
            Oleh : DPM
            Untuk : Kongres Ormawa UKM 2025
            List yang dipinjam :
            - Paket Aula 1', 'ticket_num'=> '12000449', 'phone'=>''],
            ['closed_date'=>'29/04/25','student_id'=>'1102220308','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HMTK - LPJ Bagi-Bagi Takjil dan Buka Puasa Bersama HMTK', 'ticket_num'=> '12000450', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1203230034','service'=>'Paket Peminjaman', 'content'=>'Kode : 1037
            Tgl pengajuan : 30 April 2025
            Nama Peminjam : Naufal fahmi A
            No HP : 0881037247863
            Waktu Peminjaman : 11-12 September 2025 (07.00-19.00)
            Oleh : BEM
            Untuk : Kunjungan BEM FKS Telkom University Bandung
            List yang dipinjam :
            - Paket Aula 1 
            - Paket Komunikasi 1
            - Paket Listrik 1 
            - Paket Duduk 6 
            - Paket Kelas 2 (Req ruangan bersekat)', 'ticket_num'=> '12000451', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1203230090','service'=>'Paket Peminjaman', 'content'=>'Kode : 1038
            Tgl pengajuan : 30 April 2025
            Nama Peminjam : Muhammad Muhyi Akbar
            No HP : 0895339950302
            Waktu Peminjaman : 29 Mei 2025 (07.00-16.00)
            Oleh : HMIF
            Untuk : Funsportika
            List yang dipinjam :
            - Lapangan Hybrid Telkom University Surabya 1
            - Paket Aula Lapangan 1 ', 'ticket_num'=> '12000452', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1203230090','service'=>'Paket Peminjaman', 'content'=>'Kode : 1039
            Tgl pengajuan : 30 April 2025
            Nama Peminjam : Muhammad Muhyi Akbar
            No HP : 0895339950302
            Waktu Peminjaman : 30 Mei 2025 (07.00-21.00)
            Oleh : HMIF
            Untuk : Funsportika
            List yang dipinjam :
            - Paket kelas 2 (Req ruangan bersekat)
            - Paket Listrik 1 ', 'ticket_num'=> '12000453', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1203230090','service'=>'Paket Peminjaman', 'content'=>'Kode : 1040
            Tgl pengajuan : 30 April 2025
            Nama Peminjam : Muhammad Muhyi Akbar
            No HP : 0895339950302
            Waktu Peminjaman : 1 Juni 2025 (08.00-21.00)
            Oleh : HMIF
            Untuk : Funsportika
            List yang dipinjam :
            - Paket kelas 2 (Req ruangan bersekat)
            - Paket Listrik 1 ', 'ticket_num'=> '12000454', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1205230035','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab Digital Start UP untuk kegiatan Take Video Profile HMBD pada hari, Jumat 09 Mei 2025 ', 'ticket_num'=> '12000455', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1102220009','service'=>'Paket Peminjaman', 'content'=>'Kode : 1041
            Tgl pengajuan : 30 April 2025
            Nama Peminjam : Fredianto S. 
            No HP : 082149087867
            Waktu Peminjaman : 7 Mei 2025 (18.00-22.00)
            Oleh : HMTK
            Untuk : Rapat Bulanan HMTK
            List yang dipinjam :
            - Paket kelas 2 (Req ruangan bersekat)
            ', 'ticket_num'=> '12000456', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1205230035','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab Digital Start UP untuk kegiatan Seleksi SmartBiz Diesnatalis  pada hari, Sabtu 10 Mei 2025', 'ticket_num'=> '12000457', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1205230035','service'=>'Peminjaman Ruang Laboratorium', 'content'=>'Peminjaman Lab Digital Start UP untuk kegiatan Foto Produk HMBD  pada hari, Sabtu 12 Mei 2025', 'ticket_num'=> '12000458', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 1042
            Tgl pengajuan : 30 April 2025
            Nama Peminjam :  Athaya Alfarabi
            No HP : 087855149236
            Waktu Peminjaman : 24 Mei 2025 (06.00-20.00)
            Oleh : HIMASDATA
            Untuk : Dolanan Data 2025
            List yang dipinjam :
            - Paket Komunikasi 2', 'ticket_num'=> '12000459', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1206230018','service'=>'Paket Peminjaman', 'content'=>'Kode : 1043
            Tgl pengajuan : 30 April 2025
            Nama Peminjam :  Athaya Alfarabi
            No HP : 087855149236
            Waktu Peminjaman : 25 Mei 2025 (08.00-21.00)
            Oleh : HIMASDATA
            Untuk : Fit N Fun 2025
            List yang dipinjam :
            - Meja Tenis 1
            - Paket Kelas 2 (Bersekat)
            - Paket Audio Portable 1
            - Paket Listrik 1
            - Paket Komunikasi 1', 'ticket_num'=> '12000460', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1204230066','service'=>'Paket Peminjaman', 'content'=>'Kode : 1044
            Tgl pengajuan : 30 April 2025
            Nama Peminjam :  Alifiyah Adinda
            No HP : 082394721477
            Waktu Peminjaman : 11 Mei 2025 (06.00-22.00)
            Oleh : BEM
            Untuk : Diklat Panitia Direktur CUP
            List yang dipinjam :
            - Paket Kelas 2 (Bersekat)
            - Paket Audio Portable 1
            - Paket Musyawarah 1', 'ticket_num'=> '12000461', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1204230066','service'=>'Paket Peminjaman', 'content'=>'Kode : 1045
            Tgl pengajuan : 30 April 2025
            Nama Peminjam :  Alifiyah Adinda
            No HP : 082394721477
            Waktu Peminjaman : 31 Mei - 1 Juni 2025 (06.00-18.00)
            Oleh : BEM
            Untuk : Tes Fisik Rekruitasi Panitia PKKMB DM 2025
            List yang dipinjam :
            - Paket Kelas 2 (Bersekat)
            - Paket Audio Portable 1
            - Paket Musyawarah 2', 'ticket_num'=> '12000462', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1204230066','service'=>'Paket Peminjaman', 'content'=>'Kode : 1046
            Tgl pengajuan : 30 April 2025
            Nama Peminjam :  Alifiyah Adinda
            No HP : 082394721477
            Waktu Peminjaman : 7 - 8 Juni 2025 (06.00-22.00)
            Oleh : BEM
            Untuk : Wawancara Rekruitasi Panitia PKKMB DM 2025
            List yang dipinjam :
            - Paket Kelas 2 (Bersekat)', 'ticket_num'=> '12000463', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1204230066','service'=>'Paket Peminjaman', 'content'=>'Kode : 1047
            Tgl pengajuan : 30 April 2025
            Nama Peminjam :  Alifiyah Adinda
            No HP : 082394721477
            Waktu Peminjaman : 7 - 8 Juni 2025 (07.00-22.00)
            Oleh : BEM
            Untuk : Wawancara Rekruitasi Panitia PKKMB DM 2025
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000464', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1104230060','service'=>'Paket Peminjaman', 'content'=>'Kode : 1048
            Tgl pengajuan : 30 April 2025
            Nama Peminjam : Pesta Demokrasi D. 
            No HP : 81217382090
            Waktu Peminjaman : 17 Mei 2025 (08.00-15.00)
            Oleh : BEM
            Untuk : Olaraga Bersama
            List yang dipinjam :
            - Lapangan Hybrid 1
            - Paket Audio Portable 1
            - Paket Listrik 1', 'ticket_num'=> '12000465', 'phone'=>''],
            ['closed_date'=>'30/04/25','student_id'=>'1204230117','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HMSI - Proposal Pengajuan Dana STUDY COLLABORATION 2025', 'ticket_num'=> '12000466', 'phone'=>''],
            ['closed_date'=>'02/05/25','student_id'=>'1202230022','service'=>'Paket Peminjaman', 'content'=>'Kode : 1049
            Tgl pengajuan : 2 Mei 2025
            Nama Peminjam : M. Iqbal Hilmi 
            No HP : 081359261638
            Waktu Peminjaman : 24 Mei 2025 (07.00-12.00)
            Oleh : HIMATISI
            Untuk : IT Cup
            List yang dipinjam :
            - Lapangan Hybrid 1
            - Paket Audio Portable 1', 'ticket_num'=> '12000467', 'phone'=>''],
            ['closed_date'=>'02/05/25','student_id'=>'1202230022','service'=>'Paket Peminjaman', 'content'=>'Kode : 1050
            Tgl pengajuan : 2 Mei 2025
            Nama Peminjam : M. Iqbal Hilmi 
            No HP : 081359261638
            Waktu Peminjaman : 25 Mei 2025 (07.00-12.00)
            Oleh : HIMATISI
            Untuk : IT Cup
            List yang dipinjam :
            - Lapangan Hybrid 1
            - Paket Audio Portable 1', 'ticket_num'=> '12000468', 'phone'=>''],
            ['closed_date'=>'02/05/25','student_id'=>'1202230022','service'=>'Paket Peminjaman', 'content'=>'Kode : 1051
            Tgl pengajuan : 2 Mei 2025
            Nama Peminjam : M. Iqbal Hilmi 
            No HP : 081359261638
            Waktu Peminjaman : 1 Juni 2025 (07.00-18.00)
            Oleh : HIMATISI
            Untuk : IT Cup
            List yang dipinjam :
            - Lapangan Hybrid 1
            - Paket Audio Portable 1', 'ticket_num'=> '12000469', 'phone'=>''],
            ['closed_date'=>'02/05/25','student_id'=>'1101230008','service'=>'Paket Peminjaman', 'content'=>'Kode : 1052
            Tgl pengajuan : 2 Mei 2025
            Nama Peminjam :  Dian Ratih Sukma H.
            No HP : 0895802928009
            Waktu Peminjaman : 3 Juni 2025 (17.00-22.00)
            Oleh : HIMA TESLA
            Untuk : Rapat LDMO Hima Tesla
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000470', 'phone'=>''],
            ['closed_date'=>'02/05/25','student_id'=>'1101230008','service'=>'Paket Peminjaman', 'content'=>'Kode : 1053
            Tgl pengajuan : 2 Mei 2025
            Nama Peminjam :  Dian Ratih Sukma H.
            No HP : 0895802928009
            Waktu Peminjaman : 21 Juni 2025 (07.00-21.00)
            Oleh : HIMA TESLA
            Untuk : Pra LDMO
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000471', 'phone'=>''],
            ['closed_date'=>'02/05/25','student_id'=>'1101230008','service'=>'Paket Peminjaman', 'content'=>'Kode : 1054
            Tgl pengajuan : 2 Mei 2025
            Nama Peminjam :  Dian Ratih Sukma H.
            No HP : 0895802928009
            Waktu Peminjaman : 23-27 Juni 2025 (06.00-21.00)
            Oleh : HIMA TESLA
            Untuk : LDMO
            List yang dipinjam :
            - Paket Aula 1
            - Paket Musyawarah 1
            - Paket Duduk 1
            - Paket Visual 1
            - Paket Komunikasi 1', 'ticket_num'=> '12000472', 'phone'=>''],
            ['closed_date'=>'02/05/25','student_id'=>'1205230018','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HMBD - Proposal Pengajuan Dana DIESNATALIS PRODI BISNIS DIGITAL 4.0', 'ticket_num'=> '12000473', 'phone'=>''],
            ['closed_date'=>'02/05/25','student_id'=>'1205230018','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HMBD - Proposal Pengajuan Dana DIGBIZIAN SPORT DAY', 'ticket_num'=> '12000474', 'phone'=>''],
            ['closed_date'=>'02/05/25','student_id'=>'1203230002','service'=>'Paket Peminjaman', 'content'=>'Kode : 1055
            Tgl pengajuan : 2 Mei 2025
            Nama Peminjam :  Araya Aliya c.
            No HP : 081395972004
            Waktu Peminjaman : 31 MEI 2025 (12.00-15.00)
            Oleh : Punggawa Inspiratif
            Untuk : Softskill saga
            List yang dipinjam :
            - Paket Aula 1
            - Paket Duduk 1 ', 'ticket_num'=> '12000475', 'phone'=>''],
            ['closed_date'=>'02/05/25','student_id'=>'103092400080','service'=>'Paket Peminjaman', 'content'=>'Kode : 1056
            Tgl pengajuan : 2 Mei 2025
            Nama Peminjam :  Queenitas Sekar Dewi
            No HP : 085814059757
            Waktu Peminjaman : 9 Mei 2025 (18.00-21.00)
            Oleh : HIMATISI
            Untuk : Rapat IT Cup
            List yang dipinjam :
            - Paket Kelas 2 (Bersekat)', 'ticket_num'=> '12000476', 'phone'=>''],
            ['closed_date'=>'02/05/25','student_id'=>'103092400080','service'=>'Paket Peminjaman', 'content'=>'Kode : 1057
            Tgl pengajuan : 2 Mei 2025
            Nama Peminjam :  Queenitas Sekar Dewi
            No HP : 085814059757
            Waktu Peminjaman : 14 Mei 2025 (18.00-21.00)
            Oleh : HIMATISI
            Untuk : TRapat IT Cup
            List yang dipinjam :
            - Paket Kelas 2 (Bersekat)', 'ticket_num'=> '12000477', 'phone'=>''],
            ['closed_date'=>'02/05/25','student_id'=>'103092400080','service'=>'Paket Peminjaman', 'content'=>'Kode : 1058
            Tgl pengajuan : 2 Mei 2025
            Nama Peminjam :  Queenitas Sekar Dewi
            No HP : 085814059757
            Waktu Peminjaman : 15 Mei 2025 (18.00-21.00)
            Oleh : HIMATISI
            Untuk : Technical Meeting IT Cup
            List yang dipinjam :
            - Paket Kelas 1', 'ticket_num'=> '12000478', 'phone'=>''],
            ['closed_date'=>'02/05/25','student_id'=>'103092400080','service'=>'Paket Peminjaman', 'content'=>'Kode : 1059
            Tgl pengajuan : 2 Mei 2025
            Nama Peminjam :  Queenitas Sekar Dewi
            No HP : 085814059757
            Waktu Peminjaman : 18 Mei 2025 (09.00-21.00)
            Oleh : HIMATISI
            Untuk : IT Cup
            List yang dipinjam :
            - Paket Kelas 2 (Bersekat)
            - Paket Audio Portable 1
            - Paket Listrik 1
            - Paket Visual 1', 'ticket_num'=> '12000479', 'phone'=>''],
            ['closed_date'=>'05/05/25','student_id'=>'1205230049','service'=>'Proposal Pendanaan Kegiatan UKM', 'content'=>'HMBD - Proposal Pengajuan Dana Kuliah Tamu Olah Rasa', 'ticket_num'=> '12000480', 'phone'=>''],
        ];

        foreach ($tickets as $t) {
            $p = Person::where('per_num', $t['student_id'])->first();
            $s = Service::where('service', $t['service'])->first();
            $sct = ServiceCategory::where('type', 'time')->where('category','Sedang')->first();
            $sco = ServiceCategory::where('type', 'order')->where('category','Permintaan')->first();
            $sm = ServiceMapping::where('service_id', $s->id)->first();
            $sa = ServiceAdditional::where('id', $s->id)->first();
            $p2 = Person::where('id', $sm->person_id)->first();
            $u = Unit::where('id', $sm->unit_id)->first();

            if($p && $s && $sct && $sco && $sm && $sa && $p2 && $u){

                // Ubah ke objek DateTime dari format d/m/y
                $date = \DateTime::createFromFormat('d/m/y', $t['closed_date']);

                // Kurangi 3 hari
                $date->modify('-'.($sa->duration-1).' days');

                // Generate waktu acak antara 09:00:00 dan 15:00:00
                $startTimestamp = strtotime('09:00:00');
                $endTimestamp   = strtotime('15:00:00');
                $randomTime     = rand($startTimestamp, $endTimestamp);
                $randomTimeFormatted = date('H:i:s', $randomTime);

                // Gabungkan
                $finalDateTime = $date->format('Y-m-d') . ' ' . $randomTimeFormatted;

                $closedDate = \DateTime::createFromFormat('d/m/y', $t['closed_date']);

                // Generate waktu acak antara 09:00:00 dan 15:00:00
                $startTimestamp = strtotime('09:00:00');
                $endTimestamp   = strtotime('15:00:00');
                $randomTime     = rand($startTimestamp, $endTimestamp);
                $randomTimeFormatted = date('H:i:s', $randomTime);

                // Gabungkan
                $closedDateTime = $closedDate->format('Y-m-d') . ' ' . $randomTimeFormatted;

                //$p
                $created = [
                    'createdat' => $finalDateTime,
                    'createdby' => $p->person,
                ];

                //$p
                $creator = [
                    'name' => $p->person,
                    'id' => $p->id,
                    'major' => $p->per_major,
                    'faculty' => $p->per_faculty,
                    'years' => $p->per_years,
                    'phone' => $p->per_phone,
                    'email' => $p->per_email,
                    'photo' => $p->per_photo
                ];

                //$p2
                $recipient = [
                    'name' => $p2->person,
                    'id' => $p2->id,
                    'phone' => $p2->per_phone,
                    'email' => $p2->per_email,
                ];

                $supervisor = [
                    'name' => '',
                    'id' => '',
                ];

                $person = compact('creator', 'supervisor', 'recipient');

                //$u
                $unit = [
                    'name' => $u->unit,
                    'id' => $u->id,
                ];

                //$s
                $service = [
                    'name' => $s->service,
                    'id' => $s->id,
                ];

                $purpose = compact('unit', 'service');

                // $sct
                $time = [
                    'name' => $sct->category,
                    'id' => $sct->id,
                ];

                // $sco
                $order = [
                    'name' => $sco->category,
                    'id' => $sco->id,
                ];

                $category = compact('time', 'order');

                // input ticket
                $ticket = Ticket::create([
                    'attachment' => '',
                    'created' => $created,
                    'person' => $person,
                    'purpose' => $purpose,
                    'category' => $category,
                    'updated' => [],
                    'rating' => '',
                    'status' => 'closed',
                    'active' => 'Y',
                    'ticketNumber' => (int) $t['ticket_num'],
                    'content' => $t['content'],
                    'created_at' => $finalDateTime
                ]);

                // input progress
                $ticketProgress = TicketProgress::create([
                    'ticketId' => $ticket->id,
                    'head' => 'created',
                    'content' => "Tiket " . $t['ticket_num'] . " berhasil dibuat oleh " . $p->person . " untuk " . $p->person . ", Mohon menunggu sampai tiket diproses.",
                    'attachment' => '',
                    'by' => [
                        'name' => $p->person,
                        'id' => $p->id,
                    ],
                    'timestamp' => $finalDateTime,
                ]);

                $ticketProgress = TicketProgress::create([
                    'ticketId' => $ticket->id,
                    'head' => 'assigned',
                    'content' => "Tiket " . $t['ticket_num'] . " berhasil diberikan kepada " . $p2->person . ", Tiket akan segera diproses.",
                    'attachment' => '',
                    'by' => [
                        'name' => $p->person,
                        'id' => $p->id,
                    ],
                    'timestamp' => $finalDateTime,
                ]);

                $ticketAssigned = TicketProgress::create([
                    'ticketId' => $ticket->id,
                    'head' => 'progress',
                    'content' => "Tiket " . $t['ticket_num'] . " sudah mulai dikerjakan, " . $p2->person . " memulai pengerjaan tiket.",
                    'attachment' => '',
                    'by' => [
                        'name' => $p2->person,
                        'id' => $p2->id,
                    ],
                    'timestamp' => $finalDateTime,
                ]);

                $ticketProgress = TicketProgress::create([
                    'ticketId' => $ticket->id,
                    'head' => 'content-original',
                    'content' => $t['content'],
                    'attachment' => '',
                    'by' => [
                        'name' => $p->person,
                        'id' => $p->id,
                    ],
                    'timestamp' => $finalDateTime,
                ]);

                // input log
                $ticketLog = TicketLog::create([
                    'ticketId' => $ticket->id,
                    'action' => 'Ticket Created',
                    'content' => "Ticket created by " . $p->person . " on " . $finalDateTime,
                    'ticketdata' => $ticket->toArray(),
                    'by' => [
                        'name' => $p->person,
                        'id' => $p->id,
                    ],
                    'timestamp' => $finalDateTime,
                ]);

                $ticketLog = TicketLog::create([
                    'ticketId' => $ticket->id,
                    'action' => 'Ticket Assigned',
                    'content' => "Ticket assigned to " . $p2->person . " by " . $p->person . " on " . $finalDateTime,
                    'ticketdata' => $ticket->toArray(),
                    'by' => [
                        'name' => $p->person,
                        'id' => $p->id,
                    ],
                    'timestamp' => $finalDateTime,
                ]);

                $ticketLog = TicketLog::create([
                    'ticketId' => $ticket->id,
                    'action' => 'Ticket Progress',
                    'content' => "Ticket progress started by " . $p2->person . " on " . $finalDateTime,
                    'ticketdata' => $ticket->toArray(),
                    'by' => [
                        'name' => $p2->person,
                        'id' => $p2->id,
                    ],
                    'timestamp' => $finalDateTime,
                ]);

                if(!empty($t['phone'])){
                    $p->per_phone = $t['phone'];
                    $p->save();
                }

                //$closedDateTime

                $by = [
                    'name' => $p2->person,
                    'id' => $p2->id,
                ];

                // input resolution
                $resolution = Resolution::create([
                    'ticketId' => $ticket->id,
                    'resolution' => 'Telah diselesaikan',
                    'response' => 'Silahkan dicek kembali',
                    'attachment' => '',
                    'by' => $by,
                    'timestamp' => $closedDateTime,
                ]);

                // input progress
                $ticketProgress = TicketProgress::create([
                    'ticketId' => $ticket->id,
                    'head' => 'closed',
                    'content' => 'Ticket ' . $ticket->ticketNumber . ' ditutup oleh ' . $p2->person . ', Tiket ditutup dengan keterangan Silahkan dicek kembali',
                    'attachment' => '',
                    'by' => $by,
                    'timestamp' => $closedDateTime,
                ]);

                // input log
                $ticketLog = TicketLog::create([
                    'ticketId' => $ticket->id,
                    'action' => 'Ticket Closed',
                    'content' => "Ticket closed by " . $p2->person . " on " . $closedDateTime,
                    'ticketdata' => $ticket->toArray(),
                    'by' => $by,
                    'timestamp' => $closedDateTime,
                ]);
            }
        }

    }
}
