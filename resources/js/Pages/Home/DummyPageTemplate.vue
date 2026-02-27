<script setup>
// import {getIcons} from '@iconify/utils';

// // List all icons
// console.log( getIcons());


const printPage = () => {
  const printContent = document.getElementById('ini-print').innerHTML;
  // remove hidden class
  document.getElementById('ini-print').classList.remove('hidden');
  const originalContent = document.body.innerHTML;
  document.body.innerHTML = printContent;
  window.print();
  document.body.innerHTML = originalContent;
  window.location.reload();
}

const tableRows1 = [
  'Nama Ketua Pelaksana', 'Nama Kegiatan', 'Tanggal Kegiatan', 'Tempat Kegiatan', 'Waktu Kegiatan', 'Total Peserta Kegiatan'
]

const tableRows2 = [
  'Tanggal Peminjaman', 'Waktu Peminjaman', 'Paket Peminjaman', 'Tambahan Peminjaman'
]
</script>

<template>
  <div class="py-14 bg-slate-200 h-full min-h-screen">
    <div class="container mx-auto">
      {{ iconinput }}
      <Icon icon={icon.name} />
      <!-- Start Confirmation Page -->
      <Section class="max-w-2xl py-8 mx-auto bg-white relative">
        <header class="px-8">
          <img class="object-scale-down w-32 h-24" src="../../../images/logo-kop-surat.png" alt="">
        </header>
        <main class="mt-5 mb-20 px-8">
          <div class="w-[67%]">
            <h3 class="font-extrabold font-serif">Validasi Surat Cuti Akademik Telkom University Surabaya</h3>
          </div>
          <div class="my-5">
            <p class="text-base font-serif font-light">Dokumen digital dan atau cetak ini dapat dijadikan sebagai alat
              bukti yang sah, format dan isi telah sesuai dengan ketentuan yang berlaku sejak disahkan, dan secara
              otomatis terdaftar dan terdokumentasi dalam sistem Student Service Center dengan detail berikut:</p>
          </div>
          <div class="border-b-2 border-gray-300 py-1">
            <p class="font-semibold">Profil User</p>
          </div>
          <table class="table-auto mt-2 mb-5">
            <tbody>
              <tr>
                <td class="text-base font-normal">Nomer Tiket</td>
                <td class="pl-20">:</td>
              </tr>
              <tr>
                <td class="text-base font-normal">NIM</td>
                <td class="pl-20">:</td>
              </tr>
              <tr>
                <td class="text-base font-normal">Nama</td>
                <td class="pl-20">:</td>
              </tr>
              <tr>
                <td class="text-base font-normal">Program Studi</td>
                <td class="pl-20">:</td>
              </tr>
            </tbody>
          </table>
          <div class="border-b-2 border-gray-300 py-1">
            <p class="font-semibold">Info Penandatanganan</p>
          </div>
          <table class="table-auto mt-2 mb-5">
            <tbody>
              <tr>
                <td class="text-base font-normal">Kategori</td>
                <td class="pl-10 pr-2">:</td>
                <td class="">Diperiksa Oleh</td>
              </tr>
              <tr>
                <td class="text-base font-normal">Penandatanganan</td>
                <td class="pl-10 pr-2">:</td>
                <td class="">Rizal Jihadi</td>
              </tr>
              <td class="pb-3"></td>
              <tr>
                <td class="text-base font-normal">Kategori</td>
                <td class="pl-10 pr-2">:</td>
                <td class="">Mengetahui</td>
              </tr>
              <tr>
                <td class="text-base font-normal">Penandatanganan</td>
                <td class="pl-10 pr-2">:</td>
                <td class="">Dr. Helmy Widyantara, S.Kom., M.Eng.</td>
              </tr>
              <td class="pb-3"></td>
              <tr>
                <td class="text-base font-normal">Kategori</td>
                <td class="pl-10 pr-2">:</td>
                <td class="">Menyetujui</td>
              </tr>
              <tr>
                <td class="text-base font-normal">Penandatanganan</td>
                <td class="pl-10 pr-2">:</td>
                <td class="">Rokhmatul Insani Hawwin</td>
              </tr>
              <td class="pb-3"></td>
            </tbody>
          </table>
          <div class="border-b-2 border-gray-300 py-1">
            <p class="font-semibold">Informasi</p>
          </div>
          <table class="table-auto mt-2 mb-5">
            <tbody>
              <tr>
                <td class="text-base font-normal w-2">Tanggal Penandatanganan</td>
                <td class="pl-10 pr-2">:</td>
                <td>11 - 10 - 2023, 23:18:00</td>
              </tr>
            </tbody>
          </table>
        </main>
        <footer class="absolute bottom-0 bg-neutral-200 w-full py-2">
          <p class="text-center">©Telkom University Surabaya. All Rights Reserved</p>
        </footer>
      </Section>
      <!-- End Confirmation Page -->
      <div class="my-10"></div>

      <!-- Start gagal validasi -->
      <Section class="max-w-2xl py-8 mx-auto bg-white relative">
        <header class="px-8">
          <img class="object-scale-down w-32 h-24" src="../../../images/logo-kop-surat.png" alt="">
        </header>
        <main class="mt-5 mb-20 px-8">
          <Icon class="text-primary-400 mx-auto text-9xl my-10" icon="icon-park-outline:file-failed" />
          <h2 class="font-serif font-bold text-center">Berkas Gagal Divalidasi</h2>
        </main>
        <footer class="absolute bottom-0 bg-neutral-200 w-full py-2">
          <p class="text-center">©Telkom University Surabaya. All Rights Reserved</p>
        </footer>
      </Section>
      <!-- End gagal validasi -->

      <!-- Start Print -->
      <div class="text-center mt-20">
        <button type="button" @click="printPage"
          class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border-2 border-primary-400 bg-primary-400 font-semibold text-white hover:bg-primary-500 hover:border-primary-500 text-sm">
          Print Page
        </button>
        <div id="ini-print" class="hidden">
          <!-- Halaman Utama -->
          <div class="page-1 p-6 h-full">
            <div class="relative h-full w-full">
              <div class="kop-header absolute top-0 right-5">
                <img class="object-scale-down w-36 h-32" src="../../../images/logo-kop-surat.png" alt="">
              </div>
              <div style="height: 130px;"></div>
              <div class="content px-3">
                <div class="text-center font-serif mb-7">
                  <p class="font-semibold text-sm">SURAT PEMINJAMAN LOGISTIK</p>
                  <p class="text-sm font-normal">No. 012/AKD/XI/2023</p>
                </div>
                <p class="text-sm font-normal mb-5">Bersamaan dengan surat ini saya,</p>
                <div class="mb-5">
                  <table class="table-auto">
                    <tbody>
                      <tr v-for="text in tableRows1" :key="text">
                        <td class="text-sm font-normal">{{ text }}</td>
                        <td class="pl-10">:</td>
                      </tr>
                      <tr class="">
                        <td class="py-5"></td>
                      </tr>
                    </tbody>
                  </table>
                  <p class="text-sm font-normal mb-5">
                    Dengan ini mengajukan Permohonan Cuti Akademik sebagai mahasiswa Telkom University Surabaya,
                    dengan detail terlampir.
                    <br>Demikian permohonan ini saya buat dengan sesungguhnya, dan segala akibat yang ditimbulkan oleh
                    permohonan ini sepenuhnya menjadi tanggung jawab saya.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <!-- Halaman Lampiran -->
          <div class="page-1 p-6 h-full">
            <div class="relative h-full w-full">
              <div class="kop-header absolute top-0 right-5">
                <img class="object-scale-down w-36 h-32" src="../../../images/logo-kop-surat.png" alt="">
              </div>
              <div style="height: 130px;"></div>
              <div class="content px-3">
                <p class="text-sm font-normal mb-5">Berikut detail pengajuan Peminjaman Aset Logistik</p>
                <div class="mb-5">
                  <table class="table-auto">
                    <tbody>
                      <tr v-for="text in tableRows1" :key="text">
                        <td class="text-sm font-normal">{{ text }}</td>
                        <td class="pl-10">:</td>
                      </tr>
                      <tr class="">
                        <td class="py-5"></td>
                      </tr>
                      <tr v-for="text in tableRows2" :key="text">
                        <td class="text-sm font-normal">{{ text }}</td>
                        <td class="pl-10">:</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- End -->
    </div>
  </div>
</template>

<style>
@media print {
  @page {
    size: A4;
    margin: 0;
  }

  .page-1,
  .page-2 {
    width: 210mm;
    height: 297mm;
    margin: 0;
  }

}
</style>