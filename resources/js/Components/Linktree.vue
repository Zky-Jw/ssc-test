<script setup>


defineProps({
  class: {
    type: String,
    default: 'my-20 bg-primary-400 py-12',
  },
});

const formList = [
  {
    icons: 'mdi:customer-service',
    title: 'Form Layanan SSC',
    description: 'Form untuk pengajuan layanan offline SSC',
    link: 'https://ittsby.id/LayananOfflineSSC',
  },
  {
    icons: 'eos-icons:critical-bug-outlined',
    title: 'Form Pusat Keluhan dan Saran',
    description: 'Form aspirasi mahasiswa terhadap layanan kampus ',
    link: 'https://ittsby.id/PusaranSSC',
  },
  {
    icons: 'mingcute:happy-line',
    title: 'Form Kepuasan Layanan SSC',
    description: 'Form untuk kepuasan layanan SSC',
    link: 'https://ittsby.id/KepuasanLayananSSC',
  },
]
</script>

<template>
  <section :class="class">
    <div class="container mx-auto">
      <div class="text-center mb-10">
        <h2 class="text-tartiary-200">Kumpulan Tautan From SSC</h2>
      </div>
      <div class="lg:mx-20 mx-5">
        <div class="grid grid-cols-1 md:grid-cols-3 justify-items-center gap-4 mx-auto">
          <div v-for="item in formList" :key="item" class=" bg-white border shadow-sm rounded-xl p-4 md:p-8">
            <div class="inline-flex items-center justify-center bg-primary-400 p-2 rounded-md mb-3">
              <Icon :icon="item.icons" class="text-4xl text-tartiary-200" />
            </div>
            <a :href="item.link" target="_blank" class="text-2xl font-extrabold text-primary-400 block hover:underline hover:text-primary-300">
              {{ item.title }}
            </a>
            <p class="mt-2 text-gray-800 text-lg">
              {{ item.description }}
            </p>
          </div>
        </div>
      </div>

    </div>
  </section>
</template>