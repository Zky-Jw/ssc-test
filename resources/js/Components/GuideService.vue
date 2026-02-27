<script setup>

import { reactive } from 'vue';
import SectionTitle from '@/Components/SectionTitle.vue';
const scrollRight = () => {
  const slider = document.querySelector('.wrapper-guide');
  slider.scrollLeft += 100;
}
const scrollLeft = () => {
  const slider = document.querySelector('.wrapper-guide');
  slider.scrollLeft -= 100;
}
const obj = reactive({
  guide: [
    {
      id: 1,
      icons: 'ph:person-simple-walk',
      title: 'Mahasiswa Datang ke SSC',
    },
    {
      id: 2,
      icons: 'ion:id-card-outline',
      title: 'Mahasiswa mendatangi operator dan menyiapkan KTM',
    },
    {
      id: 3,
      icons: 'material-symbols:problem-outline-rounded',
      title: 'Mahasiswa berkonsultasi tentang layanan ke operator',
    },
    {
      id: 4,
      icons: 'ri:customer-service-2-fill',
      title: 'Operator membantu mahasiwa terkait layanan SSC melalui ticketing aplikasi',
    },
    {
      id: 5,
      icons: 'mi:circle-information',
      title: 'Mahasiswa akan mendapatkan informasi terkait tindak lanjut layanan melalui Email dan WhatsApp',
    },
    {
      id: 6,
      icons: 'akar-icons:thumbs-up',
      title: 'Selesai',
    }

  ]
})

</script>

<template>
  <div class="lg:mx-16 mx-5 my-20 overflow-x-hidden">
    <SectionTitle title="Panduan Pengajuan Layanan" />
    <div class="flex flex-wrap justify-between relative top-20 z-50">
      <button @click="scrollLeft" class="inline-flex lg:hidden bg-neutral-300 px-1 py-2 rounded-lg">
        <Icon class="text-2xl text-primary-400" icon="ic:round-chevron-left" />
      </button>
      <button @click="scrollRight" class="inline-flex lg:hidden bg-neutral-300 px-1 py-2 rounded-lg">
        <Icon class="text-2xl text-primary-400" icon="ic:round-chevron-right" />
      </button>
    </div>
    <div class="flex justify-center">
      <div class="my-7 overflow-x-auto flex wrapper-guide">
        <template v-for="(item, index) in obj.guide" :key="item">
          <div class="h-full">
            <div class="text-center flex flex-col justify-center w-[150px]">
              <div class="flex items-center justify-center mb-3">
                <div class="bg-primary-400 p-2  rounded-full w-10 h-10">
                  <span class="text-white">{{ item.id }}</span>
                </div>
              </div>
              <Icon class="m-auto text-4xl text-primary-400 mb-3" :icon="item.icons" />
              <p class="text-sm">{{ item.title }}</p>
            </div>
          </div>
          <div v-if="index != obj.guide.length - 1">
            <div class="w-[85px] h-10 flex justify-center items-center relative">
              <hr class="border-2 border-primary-400 w-[150px] absolute">
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<style>
.line {
  left: 0;
  display: inline-block;
  position: absolute;

  width: 10px;
  height: 2px;
  background-color: black;
}
</style>
