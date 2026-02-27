<script setup>
import { ref, reactive } from 'vue';

const selectSelected = ref(0);
const clickSelect = (index) => {
  selectSelected.value = index;
}

const listOnlineService = reactive({
  guide: [
    {
      id: 1,
      icons: 'ph:person-simple-walk',
      title: 'Mahasiswa Datang dengan membawa KTM dan Mengambil Antrian',
    },
    {
      id: 2,
      icons: 'material-symbols:problem-outline-rounded',
      title: 'Mahasiswa menunggu antrian sampai operator memanggil',
    },
    {
      id: 3,
      icons: 'ri:customer-service-2-fill',
      title: 'Mahasiswa berkonsultasi dan akan mendapatkan informasi tindak lanjut layanan melalui WA dan E-mail',
    },
    {
      id: 4,
      icons: 'akar-icons:thumbs-up',
      title: 'Jika sudah menerima WA dan E-mail, Mahasiswa bisa datang kembali ke SSC',
    }
  ]
})

</script>

<template>
  <section class="my-24" id="panduan">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-black text-3xl md:text-4xl font-poppins">
          Panduan Pengajuan Layanan
        </h2>
      </div>
      <div class="flex flex-wrap justify-center mb-10">
        <div class="flex flex-wrap mr-5 mb-5">
          <div class="flex bg-white rounded-3xl border border-gray-300 shadow-lg overflow-hidden">
            <div @click="clickSelect(0)" :class="selectSelected === 0 ? 'bg-primary-400 text-white' : 'text-black'"
              class="px-8 py-2 hover:bg-primary-400 hover:text-white cursor-pointer rounded-l-3xl transition-all duration-300">
              <p class="mb-0 font-bold text-base">Offline</p>
            </div>
            <div @click="clickSelect(1)" :class="selectSelected === 1 ? 'bg-primary-400 text-white' : 'text-black'"
              class="px-8 py-2 hover:bg-primary-400 hover:text-white cursor-pointer transition-all duration-300">
              <p class="mb-0 font-bold text-base">Online</p>
            </div>
          </div>

        </div>
      </div>
      <div v-if="selectSelected == 0" class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:items-stretch mb-32">
        <div v-for="(item, index) in listOnlineService.guide" :key="index"
          class="flex flex-col border border-gray-200 text-center rounded-xl shadow-lg p-8">
          <Icon class="block mx-auto text-4xl text-primary-400 mb-3" :icon="item.icons" />
          <p class="mt-2 text-base text-dark">{{ item.title }}</p>
        </div>
      </div>
      <div v-if="selectSelected == 1" class="mb-32">
        <div class="flex flex-col border border-gray-200 rounded-xl shadow-lg p-10">
          <h4 class="text-dark font-bold text-xl text-primary-400 text-center">Alur pelayanan mandiri</h4>
          <hr class="h-px my-8 bg-neutral-400 border-0">
          <div>
            <span class="text-base font-bold text-neutral-800">Kirimkan e-mail dengan menggunakan format dibawah
              ini</span>
            <ul class="list-none list-inside font-poppins text-neutral-800 mt-2">
              <li class="mb-1"><span class="font-bold">Penerima:</span> ssc@ittelkom-sby.ac.id</li>
              <li class="mb-1"><span class="font-bold">Subjek:</span> KODE UNIT_Permintaan (LAYANAN) Mahasiswa IT Telkom
                Surabaya
              </li>
              <li class="mb-1">NIM :</li>
              <li class="mb-1">Nama :</li>
              <li class="mb-1">Prodi :</li>
              <li class="mb-1">Fakultas :</li>
              <li class="mb-1">Angkatan :</li>
              <li class="mb-1">Email Kampus :</li>
              <li class="mb-1">No. Hp (WA*) :</li>
              <li class="mb-1">Tanggal Kebutuhan :</li>
              <li class="mb-1">Deskripsi Kebutuhan :</li>
            </ul>
            <ul class="list-none list-inside font-poppins text-neutral-800 mt-4">
              <li class="mb-1"><span class="font-bold">NB:</span></li>
              <li class="mb-1">*Sertakan lampiran berkas sesuai dengan syarat requirement yang telah tercantum di
                website SSC</li>
              <li class="mb-1">**Pastikan No. WA sudah sesuai dengan igracias</li>
              <li class="mb-1">***Keterangan Kode Unit</li>
            </ul>
            <div class="flex justify-between mt-3">
              <ul class="">
                <li class="mb-1"><span class="font-bold">AKA: </span> Akademik</li>
                <li class="mb-1"><span class="font-bold">KEU: </span> Keuangan</li>
                <li class="mb-1"><span class="font-bold">PUT: </span> PuTI</li>

              </ul>
              <ul class="">
                <li class="mb-1"><span class="font-bold">KEM: </span> Kemahasiswaan</li>
                <li class="mb-1"><span class="font-bold">LOG: </span> Logistik</li>
                <li class="mb-1"><span class="font-bold">PBP: </span> Pusat Bahasa & Perpustakaan</li>
              </ul>
            </div>

          </div>
        </div>
      </div>

    </div>
  </section>
</template>