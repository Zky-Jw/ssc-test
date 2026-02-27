<script setup>
import heroImage from '../../../images/foto-home-new.png';
</script>

<template>
  <section class="my-24 mt-40">
    <!-- Hero -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 ">
      <!-- Grid -->
      <div class="grid lg:grid-cols-8 lg:gap-x-8 xl:gap-x-12 lg:items-center">
        <div class="lg:col-span-4 mt-10 lg:mt-0 mb-14 lg:mb-0">
          <img class="w-full rounded-xl" :src="heroImage" alt="Image Description">
        </div>
        <div class="lg:col-span-4">
          <h1 class="block text-5xl font-extrabold text-dark sm:text-5xl md:text-6xl lg:text-7xl">
            <span class="text-primary-400">S</span>tudent
            <span class="block"><span class="text-primary-400">S</span>ervice <span
                class="text-primary-400">C</span>enter</span>
          </h1>
          <p class="text-neutral-600 font-semibold my-5 text-xl">Datang. Buat Tiket. Proses.</p>

          <div class="block md:flex md:flex-wrap">
            <div class="block md:flex bg-white md:rounded-3xl border border-gray-300 shadow-lg overflow-hidden">
              <div class="px-8 py-2 bg-primary-400 md:rounded-l-3xl">
                <p class="mb-0 font-bold text-white">Pelayanan</p>
              </div>
              <div class="self-center px-7 py-3 md:py-0">
                <p class="mb-0 font-bold text-neutral-500">Senin - Jumat 9.00 - 15.00</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Grid -->
      <div class="flex flex-col bg-white border border-neutral-200 shadow-lg rounded-xl p-10 my-20">
        <div class="grid items-center lg:grid-cols-12 gap-6 lg:gap-12">
          <div class="col-span-6 lg:col-span-3 mb-5 lg:mb-0">
            <div class="">
              <p class="text-5xl font-bold leading-10 text-center">
                2000+
              </p>
              <p class="mt-2 sm:mt-3 text-primary-400 text-base text-center">Tiket yang sudah dilayani</p>
            </div>
          </div>
          <div class="col-span-6 lg:col-span-3 mb-5 lg:mb-0">
            <div class="">
              <p class="text-5xl font-bold leading-10 text-center">
                6 unit
              </p>
              <p class="mt-2 sm:mt-3 text-primary-400 text-base text-center">Layanan Tersebar</p>
            </div>
          </div>
          <div class="col-span-6 lg:col-span-3 mb-5 lg:mb-0">
            <div class="">
              <p class="text-5xl font-bold leading-10 text-center">
                50+
              </p>
              <p class="mt-2 sm:mt-3 text-primary-400 text-base text-center">Jenis Layanan</p>
            </div>
          </div>
          <div class="col-span-6 lg:col-span-3 mb-5 lg:mb-0">
            <div class="">
              <p class="text-5xl font-bold leading-10 text-center">
                1500+
              </p>
              <p class="mt-2 sm:mt-3 text-primary-400 text-base text-center">Penggunan Layanan SSC</p>
            </div>
          </div>

        </div>
      </div>

      <!-- End Grid -->
      <!-- End Grid -->
    </div>
    <!-- End Hero -->
  </section>

</template>