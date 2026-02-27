<script setup>
const listTatib = [
  {
    id: 1,
    text: 'Wajib membawa KTM'
  },
  {
    id: 2,
    text: 'Pakaian sopan berkerah & memakai sepatu'
  },
  {
    id: 3,
    text: 'Menjaga etika & sopan santun'
  },
  {
    id: 4,
    text: 'Mengambil antrian melalui mesin antrian'
  },
  {
    id: 5,
    text: 'Pelayanan diproses selama jam operasional'
  },
]
</script>

<template>
  <section class="my-24 bg-section-ssc py-20" id="about">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 ">
      <div class="text-center mb-16">
        <h2 class="font-black text-3xl md:text-4xl font-poppins">Apa sih <span class="text-primary-400">SSC</span> itu?
        </h2>
      </div>
      <!-- Grid -->
      <div class="lg:grid lg:grid-cols-12 lg:gap-16 lg:items-center">
        <div class="lg:col-span-6">
          <iframe class="w-full aspect-video"
            src="https://www.youtube.com/embed/xMU_SV3SN0A?si=ZZAcdQ8dS3DWPvl7"></iframe>
        </div>
        <div class="lg:col-span-6">
          <p class="text-lg text-neutral-600">Student Service Center adalah sebuah unit atau pusat layanan yang
            beroperasi di Universitas Telkom Surabaya
            dengan tujuan untuk memberikan pelayanan terkait permasalahan administrasi mahasiswa. SSC memberikan layanan
            terpadu yang disediakan untuk memberikan kemudahan akses bagi mahasiswa untuk memperoleh layanan
            administrasi melalui satu pintu.</p>
        </div>
      </div>

      <div class="mt-24">
        <div class="text-center mb-16">
          <h2 class="font-black text-3xl font-poppins">Tata Tertib SSC
          </h2>
        </div>
        <div class="flex flex-wrap justify-center">
          <div v-for="(item, index) in listTatib" :key="index" class="flex flex-wrap mr-5 mb-10">
            <div class="flex bg-white rounded-3xl border border-gray-300 shadow-lg overflow-hidden">
              <div class="px-8 py-2.5 bg-primary-400 rounded-l-3xl">
                <p class="mb-0 font-bold text-white text-base">{{ item.id }}</p>
              </div>
              <div class="self-center px-7 py-0">
                <p class="mb-0 font-normal text-base">{{ item.text }}</p>
              </div>
            </div>
          </div>
          
        </div>
      </div>

    </div>
  </section>
</template>