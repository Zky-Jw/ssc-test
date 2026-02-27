<script setup>
  import SectionTitle from './SectionTitle.vue';
</script>

<template>
  <div class="lg:mx-16 mx-5 my-20">
    <div class="container mx-auto">
      <div class="flex flex-wrap items-center mb-10">
        <div class="w-full lg:w-1/2 block">
          <SectionTitle title="Layanan Online" />
          <p class="text-base mb-10 leading-relaxed break-words text-neutral-800">
            Layanan online di Student Service Center (SSC) merupakan sebuah platform yang didesain untuk memberikan kemudahan kepada mahasiswa dalam mengurus berbagai administrasi mereka secara efisien dimanapun dan kapanpun. Layanan ini memanfaatkan sistem komunikasi melalui email yang telah disediakan dengan format khusus yang memudahkan mahasiswa untuk mengajukan pertanyaan, meminta informasi, serta menyelesaikan berbagai tugas administratif.
          </p>
          <a href="#" class="py-3 px-7 bg-primary-400 rounded-lg text-white font-semibold text-base">
            Buat Tiket Online
          </a>
        </div>
        <div class="w-full lg:w-1/2 hidden lg:block">
          <img class="h-auto max-w-full m-auto" src="../../images/img-service-online.png" alt="img service">
        </div>
      </div>
    </div>
   
  </div>
</template>