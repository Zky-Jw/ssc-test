<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceAdditional;
use App\Models\ServiceMapping;
use App\Models\Person;
use Illuminate\Support\Str;

class ServiceMappingSeederAdditional extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = [
            ['name'=>'Administrasi Wisuda','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Ijazah','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Kerja Praktik ','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Legalisir Ijazah dan Transkrip Nilai Akhir','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Legalisir KHS Mahasiswa','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Pengajuan Aktif Kuliah Kembali','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Pengajuan Cuti','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Pengajuan Perubahan Data','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Pengajuan SK Tugas Akhir','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Pengajuan Surat Keterangan Aktif Mahasiswa','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Pengajuan Surat Pengantar Mata Kuliah','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Pengajuan Surat Pengantar Tugas Akhir','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Pengajuan Undur Diri','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Pengurusan Berkas Yudisium','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Permohonan Transkrip Nilai Sementara','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Perpanjangan dan Pembaruan SK Tugas Akhir','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Surat Keterangan Lulus (SKL)','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Surat Rekomendasi Magang','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Tel-U Care ','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Validasi Laporan MBKM','unit_id'=>'bd646c5d-5521-11ee-akd1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930038'],
            ['name'=>'Pengaduan Orang Tua','unit_id'=>'bd646c5d-5521-11ee-bds1-04d4c477450f','description'=>'<p>Layanan pengaduan orang tua kepada kaprodi<p>','requirement'=>'<p>Nama mahasiswa, detail pengaduan</p>','duration'=>1,'pic'=>'15890076'],
            ['name'=>'Pengajuan Dana Himpunan Mahasiswa ','unit_id'=>'bd646c5d-5521-11ee-bds1-04d4c477450f','description'=>'<p>Layanan pengajuan dana himpunan mahasiswa program studi Bisnis Digital<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'15890076'],
            ['name'=>'Pengaduan Orang Tua','unit_id'=>'bd646c5d-5521-11ee-bif1-04d4c477450f','description'=>'<p>Layanan pengaduan orang tua kepada kaprodi<p>','requirement'=>'<p>Nama mahasiswa, detail pengaduan</p>','duration'=>1,'pic'=>'20940043'],
            ['name'=>'Pengajuan Dana Himpunan Mahasiswa ','unit_id'=>'bd646c5d-5521-11ee-bif1-04d4c477450f','description'=>'<p>Layanan pengajuan dana himpunan mahasiswa program studi Informatika<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20940043'],
            ['name'=>'Approval SKPI ','unit_id'=>'bd646c5d-5521-11ee-kem1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'24950004'],
            ['name'=>'Approval TAK','unit_id'=>'bd646c5d-5521-11ee-kem1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'24950004'],
            ['name'=>'Layanan Kesehatan Fisik','unit_id'=>'bd646c5d-5521-11ee-kem1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>1,'pic'=>'24950004'],
            ['name'=>'Layanan Pra-kerja','unit_id'=>'bd646c5d-5521-11ee-kem1-04d4c477450f','description'=>'<p>Informasi mengenai lowongan kerja atau magang yang tersedia akan diposting di IG resmi CDC<p>','requirement'=>'<p>Dapat menghubungi admin (+62 823-3753-8183) atau cek informasi di IG @karir.telkomunivsby</p>','duration'=>1,'pic'=>'22920013'],
            ['name'=>'Layanan Self Improvement','unit_id'=>'bd646c5d-5521-11ee-kem1-04d4c477450f','description'=>'<p>Mahasiswa/alumni yang hendak mengikuti layanan self-improvement seperti (STAR dan JRP) sesuai periode yang di buka saat itu. Informasi dan tata cara pengerjaan dapat diakses di IG resmi CDC<p>','requirement'=>'<p>Dapat menghubungi admin (+62 823-3753-8183) atau cek informasi dan tata cara pengerjaan di IG @karir.telkomunivsby</p>','duration'=>1,'pic'=>'20950002'],
            ['name'=>'Pengajuan Layanan Kesehatan Mental','unit_id'=>'bd646c5d-5521-11ee-kem1-04d4c477450f','description'=>'<p>Mahasiswa/alumni yang hendak melakukan konseling dikarenakan permasalahan pribadi, karir, atau pendidikan yang mempengaruhi kesehatan mental<p>','requirement'=>'<p>Mengisi form konseling https://tel-u.ac.id/konselingtus kemudian mengontak konselor (081341544618) untuk janji pertemuan konsultasi</p>','duration'=>1,'pic'=>'20950002'],
            ['name'=>'Pengajuan Surat keterangan Tidak Menerima Beasiswa ','unit_id'=>'bd646c5d-5521-11ee-kem1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'24950004'],
            ['name'=>'Pengajuan Surat Tugas ','unit_id'=>'bd646c5d-5521-11ee-kem1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'24950004'],
            ['name'=>'Pra-tracer dan Tracer Studi','unit_id'=>'bd646c5d-5521-11ee-kem1-04d4c477450f','description'=>'<p>Pra-Tracer diawali dengan mengikuti Tel-U Career Coach di LMS hingga lulus. Kemudian mengisi form penyelesaian agar Pra-Tracer di iGracias aktif (butuh ACC). Pengerjaan Pra-Tracer hingga selesai dapat dikerjakan setelah status aktif<p>','requirement'=>'<p>1. Pengaduan Masalah: tel-u.ac.id/pengaduanpratracertelu 2. Cek Respon Pengaduan: tel-u.ac.id/statuspengaduanpratracer 3.Menghubungi admin (+62 823-3753-8183) atau cek informasi dan tata cara pengerjaan di IG @karir.telkomunivsby; Tracer Study dapat diakses di cdc.telkomuniversity.ac.id dengan log in menggunakan NIM dan password (cek di postingan IG CDC). Pilih pengisian survey dan isi data dengan lengkap sesuai kondisi saat ini</p>','duration'=>3,'pic'=>'20950002'],
            ['name'=>'Proposal Pendanaan Kegiatan UKM','unit_id'=>'bd646c5d-5521-11ee-kem1-04d4c477450f','description'=>'<p>Layanan Informasi template proposal dan penyerahan proposal pengajuan pendanaan UKM/BEM/DPM (http://linktr.ee/kemahasiswaan.univtelkomsby)<p>','requirement'=>'<p>Proposal Pengajuan Pendanaan Kegiatan UKM/BEM/DPM</p>','duration'=>1,'pic'=>'22930016'],
            ['name'=>'Proposal Pendanaan Kompetisi','unit_id'=>'bd646c5d-5521-11ee-kem1-04d4c477450f','description'=>'<p>Layanan Informasi template proposal dan penyerahan proposal pengajuan pendanaan kompetisi (http://linktr.ee/kemahasiswaan.univtelkomsby)<p>','requirement'=>'<p>Proposal Pengajuan Pendanaan Kompetisi Mahasiswa</p>','duration'=>1,'pic'=>'22930016'],
            ['name'=>'Administrasi Bebas Keuangan untuk Yudisium & Undur Diri','unit_id'=>'bd646c5d-5521-11ee-keu1-04d4c477450f','description'=>'<p>Permohonan tanda tangan untuk keterangan bebas keuangan<p>','requirement'=>'<p>Form bebas administrasi keuangan</p>','duration'=>2,'pic'=>'20950022'],
            ['name'=>'Penundaan dan Pembayaran BPP','unit_id'=>'bd646c5d-5521-11ee-keu1-04d4c477450f','description'=>'<p>Penjelasan terkait cara pembayaran dan pengajuan penundaan pembayaran melalui Tel-U Care<p>','requirement'=>'<p></p>','duration'=>1,'pic'=>'20950022'],
            ['name'=>'Permintaan Kwitansi Pembayaran','unit_id'=>'bd646c5d-5521-11ee-keu1-04d4c477450f','description'=>'<p>Permintaan tagihan atau bukti pembayaran untuk keperluan pengajuan beasiswa dan lainnya<p>','requirement'=>'<p></p>','duration'=>2,'pic'=>'20950022'],
            ['name'=>'Administrasi Bebas Laboratorium untuk Yudisium & Undur Diri','unit_id'=>'bd646c5d-5521-11ee-labpusbas1-04d4c477450f','description'=>'<p>Layanan Informasi dan penyerahan form Pengajuan Surat Bebas Laboratorium untuk syarat yudisium<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'01760006'],
            ['name'=>'Informasi layanan pusat bahasa','unit_id'=>'bd646c5d-5521-11ee-labpusbas1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'24930005'],
            ['name'=>'Logbook Asisten Laboratorium','unit_id'=>'bd646c5d-5521-11ee-labpusbas1-04d4c477450f','description'=>'<p>Layanan Kompulir Rekap Logbook Asisten Laboratorium<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'01760006'],
            ['name'=>'Peminjaman Alat Laboratorium','unit_id'=>'bd646c5d-5521-11ee-labpusbas1-04d4c477450f','description'=>'<p>Layanan Informasi dan penyerahan form Peminjaman Alat Laboratorium<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'01760006'],
            ['name'=>'Peminjaman Perpustakaan','unit_id'=>'bd646c5d-5521-11ee-labpusbas1-04d4c477450f','description'=>'<p><p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'24930005'],
            ['name'=>'Peminjaman Ruang Laboratorium','unit_id'=>'bd646c5d-5521-11ee-labpusbas1-04d4c477450f','description'=>'<p>Layanan Informasi dan penyerahan form Peminjaman Ruangan Laboratorium<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'01760006'],
            ['name'=>'Paket Peminjaman','unit_id'=>'bd646c5d-5521-11ee-log1-04d4c477450f','description'=>'<p>layanan peminjaman aset kampus yang bertujuan untuk melancarkan kegiatan UKM / ORMAWA Telkom University Surabaya<p>','requirement'=>'<p>1. F01 yang digunakan sebagai detail identitas dari pengguna; 2. F02 yang digunakan sebagai form permintaan yang diajukan</p>','duration'=>3,'pic'=>'62499055'],
            ['name'=>'Pelaporan Kerusakan Asset','unit_id'=>'bd646c5d-5521-11ee-log1-04d4c477450f','description'=>'<p>Layanan perbaikan aset adalah kegiatan pemeliharaan dan perbaikan yang dilakukan untuk mengembalikan fungsi dan kondisi aset agar tetap optimal digunakan. Layanan ini mencakup inspeksi, perbaikan kerusakan, penggantian komponen untuk memastikan aset kembali beroperasi sesuai standar. (baik aset inventaris kantor maupun aset sipil)<p>','requirement'=>'<p>Pelapor submit kerusakan melalui form: Repair and Maintenance Request form, untuk di validasi</p>','duration'=>1,'pic'=>'23930014'],
            ['name'=>'Akses Internet','unit_id'=>'bd646c5d-5521-11ee-pti1-04d4c477450f','description'=>'<p>Layanan pelaporan gangguan akses internet gedung, antara lain : Internet lambat, gagal koneksi Tel-U Connect, gagal login Tel-U Connect<p>','requirement'=>'<p>Data username SSO, pesan error (jika ada), lokasi detail gangguan (contoh: ruang kelas 1.02, lorong sayap kanan depan lab)</p>','duration'=>3,'pic'=>'82402111'],
            ['name'=>'Bug Aplikasi','unit_id'=>'bd646c5d-5521-11ee-pti1-04d4c477450f','description'=>'<p>Layanan pelaporan error web dan aplikasi baik akademik maupun non akademik yang digunakan di lingkungan Telkom University<p>','requirement'=>'<p>Data username SSO, Nama aplikasi atau URL web, Lokasi menu atau URL halaman terjadinya error, Detail pesan Error, User group yang digunakan, Lampiran berupa screenshot atau screen recording</p>','duration'=>3,'pic'=>'22920014'],
            ['name'=>'Peminjaman Orbit','unit_id'=>'bd646c5d-5521-11ee-pti1-04d4c477450f','description'=>'<p>Layanan peminjaman Orbit untuk backup internet kegiatan kampus<p>','requirement'=>'<p>Form peminjaman orbit yang sudah ditandatangani dosen pembina atau Kaprodi</p>','duration'=>1,'pic'=>'82402111'],
            ['name'=>'Permintaan email UKM/HIMA/Ormawa','unit_id'=>'bd646c5d-5521-11ee-pti1-04d4c477450f','description'=>'<p>Layanan pembuatan akun email untuk kegiatan operasional UKM/HIMA/Ormawa<p>','requirement'=>'<p>Nama UKM/HIMA/Ormawa, username yang akan digunakan pada email, Nama dosen pembina</p>','duration'=>3,'pic'=>'22920014'],
            ['name'=>'Reset 2FA Igracias','unit_id'=>'bd646c5d-5521-11ee-pti1-04d4c477450f','description'=>'<p>Layanan reset Two Factor Authentication khusus igracias apabila ada case Aplikasi Authenticator gagal menampilkan kode OTP<p>','requirement'=>'<p>Data username SSO</p>','duration'=>1,'pic'=>'22920014'],
            ['name'=>'Reset 2FA SSO','unit_id'=>'bd646c5d-5521-11ee-pti1-04d4c477450f','description'=>'<p>Layanan reset Two Factor Authentication SSO apabila ada case ganti HP, Laptop, Aplikasi Authenticator gagal menampilkan kode OTP<p>','requirement'=>'<p>Data username SSO,  Nama aplikasi atau URL web, Detail pesan Error</p>','duration'=>1,'pic'=>'82401156'],
            ['name'=>'Shared Hosting','unit_id'=>'bd646c5d-5521-11ee-pti1-04d4c477450f','description'=>'<p>Layanan permintaan shared hosting untuk keperluan Tugas Akhir<p>','requirement'=>'<p>Form permintaan shared hosting yang ditandatangani oleh Dosen pembimbing</p>','duration'=>2,'pic'=>'22970007'],
            ['name'=>'Pengaduan Orang Tua','unit_id'=>'bd646c5d-5521-11ee-bse1-04d4c477450f','description'=>'<p>Layanan pengaduan orang tua kepada kaprodi<p>','requirement'=>'<p>Nama mahasiswa, detail pengaduan</p>','duration'=>1,'pic'=>'19870004'],
            ['name'=>'Pengajuan Dana Himpunan Mahasiswa ','unit_id'=>'bd646c5d-5521-11ee-bse1-04d4c477450f','description'=>'<p>Layanan pengajuan dana himpunan mahasiswa program studi Teknik Telekomunikasi<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'19870004'],
            ['name'=>'Pengaduan Orang Tua','unit_id'=>'bd646c5d-5521-11ee-bds1-04d4c477450f','description'=>'<p>Layanan pengaduan orang tua kepada kaprodi<p>','requirement'=>'<p>Nama mahasiswa, detail pengaduan</p>','duration'=>1,'pic'=>'23950023'],
            ['name'=>'Pengajuan Dana Himpunan Mahasiswa ','unit_id'=>'bd646c5d-5521-11ee-bds1-04d4c477450f','description'=>'<p>Layanan pengajuan dana himpunan mahasiswa program studi Sains Data<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'23950023'],
            ['name'=>'Pengaduan Orang Tua','unit_id'=>'bd646c5d-5521-11ee-bis1-04d4c477450f','description'=>'<p>Layanan pengaduan orang tua kepada kaprodi<p>','requirement'=>'<p>Nama mahasiswa, detail pengaduan</p>','duration'=>1,'pic'=>'21910012'],
            ['name'=>'Pengajuan Dana Himpunan Mahasiswa ','unit_id'=>'bd646c5d-5521-11ee-bis1-04d4c477450f','description'=>'<p>Layanan pengajuan dana himpunan mahasiswa program studi Sistem Informasi<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'21910012'],
            ['name'=>'Pengaduan Orang Tua','unit_id'=>'bd646c5d-5521-11ee-bee1-04d4c477450f','description'=>'<p>Layanan pengaduan orang tua kepada kaprodi<p>','requirement'=>'<p>Nama mahasiswa, detail pengaduan</p>','duration'=>1,'pic'=>'19920002'],
            ['name'=>'Pengajuan Dana Himpunan Mahasiswa ','unit_id'=>'bd646c5d-5521-11ee-bee1-04d4c477450f','description'=>'<p>Layanan pengajuan dana himpunan mahasiswa program studi Teknik Elektro<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'19920002'],
            ['name'=>'Pengaduan Orang Tua','unit_id'=>'bd646c5d-5521-11ee-bie1-04d4c477450f','description'=>'<p>Layanan pengaduan orang tua kepada kaprodi<p>','requirement'=>'<p>Nama mahasiswa, detail pengaduan</p>','duration'=>1,'pic'=>'23880010'],
            ['name'=>'Pengajuan Dana Himpunan Mahasiswa ','unit_id'=>'bd646c5d-5521-11ee-bie1-04d4c477450f','description'=>'<p>Layanan pengajuan dana himpunan mahasiswa program studi Teknik Industri<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'23880010'],
            ['name'=>'Pengaduan Orang Tua','unit_id'=>'bd646c5d-5521-11ee-bce1-04d4c477450f','description'=>'<p>Layanan pengaduan orang tua kepada kaprodi<p>','requirement'=>'<p>Nama mahasiswa, detail pengaduan</p>','duration'=>1,'pic'=>'22760004'],
            ['name'=>'Pengajuan Dana Himpunan Mahasiswa ','unit_id'=>'bd646c5d-5521-11ee-bce1-04d4c477450f','description'=>'<p>Layanan pengajuan dana himpunan mahasiswa program studi Teknik Komputer<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'22760004'],
            ['name'=>'Pengaduan Orang Tua','unit_id'=>'bd646c5d-5521-11ee-ble1-04d4c477450f','description'=>'<p>Layanan pengaduan orang tua kepada kaprodi<p>','requirement'=>'<p>Nama mahasiswa, detail pengaduan</p>','duration'=>1,'pic'=>'20930072'],
            ['name'=>'Pengajuan Dana Himpunan Mahasiswa ','unit_id'=>'bd646c5d-5521-11ee-ble1-04d4c477450f','description'=>'<p>Layanan pengajuan dana himpunan mahasiswa program studi Teknik Logistik<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20930072'],
            ['name'=>'Pengaduan Orang Tua','unit_id'=>'bd646c5d-5521-11ee-bte1-04d4c477450f','description'=>'<p>Layanan pengaduan orang tua kepada kaprodi<p>','requirement'=>'<p>Nama mahasiswa, detail pengaduan</p>','duration'=>1,'pic'=>'20910026'],
            ['name'=>'Pengajuan Dana Himpunan Mahasiswa ','unit_id'=>'bd646c5d-5521-11ee-bte1-04d4c477450f','description'=>'<p>Layanan pengajuan dana himpunan mahasiswa program studi Teknik Telekomunikasi<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'20910026'],
            ['name'=>'Pengaduan Orang Tua','unit_id'=>'bd646c5d-5521-11ee-bit1-04d4c477450f','description'=>'<p>Layanan pengaduan orang tua kepada kaprodi<p>','requirement'=>'<p>Nama mahasiswa, detail pengaduan</p>','duration'=>1,'pic'=>'23929009'],
            ['name'=>'Pengajuan Dana Himpunan Mahasiswa ','unit_id'=>'bd646c5d-5521-11ee-bit1-04d4c477450f','description'=>'<p>Layanan pengajuan dana himpunan mahasiswa program studi Teknologi Informasi<p>','requirement'=>'<p></p>','duration'=>3,'pic'=>'23929009'],
        ];

        foreach ($arr as $a) {

            $sid = Str::uuid();
            $s = Service::create([
                'id' => $sid,
                'service' => $a['name'],
                'active' => 'Y',
                'external_app' => 'N',
                'createdby' => '999',
            ]);

            $sa = ServiceAdditional::create([
                'id' => $sid,
                'description' => $a['description'],
                'requirement' => $a['requirement'],
                'duration' => 3,
                'active' => 'Y',
                'createdby' => '999'
            ]);

            $pic = null;
            $per = Person::where('per_num', $a['pic'])->first();
            if($per){
                $pic = $per->id;
            }

            $sm = ServiceMapping::create([
                'id' => Str::uuid(),
                'service_id' => $sid,
                'unit_id' => $a['unit_id'],
                'service_category_id' => 'a74ece88-b5ed-11ef-b3cc-51c2da007135+a74ed363-b5ed-11ef-b3cc-51c2da007135',
                'service_additional_id' => $sid,
                'person_id' => $pic,
                'active' => 'Y',
                'createdby' => '999',
            ]);
        }
    }
}
