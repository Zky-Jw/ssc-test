<script setup>
  import { Head, Link } from '@inertiajs/vue3';
  import BaseLayout from '@/Layouts/BaseLayout.vue';
  import imgUrl from '../../../images/foto-tempat.png'
</script>

<template>
  <Head title="Student Service Center" />
  <BaseLayout>
    <section class="my-20">
      <div class="container mx-auto px-6">
        <h1 class="text-center font-quicksand font-bold text-black">Tentang Kami</h1>
        <div class="my-16">
          <div class="flex flex-wrap items-center">
            <div class="w-full lg:w-1/2 text-center mb-5 lg:mb-0">
              <img class="block  h-auto w-full" src="../../../images/about-photo.png" alt="">
            </div>
            <div class="w-full lg:w-1/2">
              <div class="card rounded-lg border-[1px] border-neutral-200">
                <div class="card-body py-8 md:px-10 px-7">
                  <h2 class="text-primary-400 font-bold mb-3">Student Service Center</h2>
                  <p class="font-medium text-base md:text-lg font-poppins tracking-wide">Student Service Center adalah sebuah unit atau pusat layanan yang beroperasi di Telkom University Surabaya dengan tujuan untuk memberikan pelayanan terkait permasalahan administrasi mahasiswa. SSC memberikan layanan terpadu yang disediakan untuk memberikan kemudahan akses bagi mahasiswa untuk memperoleh layanan administrasi melalui satu pintu.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="my-20 bg-primary-400">
      <div class="flex flex-wrap items-center">
        <div class="bg-contain w-full lg:w-2/5 bg-no-repeat" :style="`background-image: url(${imgUrl})`">
          <img class="block w-full h-auto" :src="imgUrl" alt="">
        </div>
        <div class="w-full lg:w-3/5 px-10 md:px-20 py-10">
          <h2 class="font-bold text-4xl font-quicksand text-tartiary-200 mb-5">Jam Pelayanan</h2>
          <div class="flex flex-wrap items-center gap-4">
            <div class="mr-0 md:mr-5">
              <div class="flex flex-wrap items-center gap-4 mb-5">
                <h3 class="text-white">Senin - Jumat</h3>
                <button type="button" class="py-2 px-5 text-base inline-flex justify-center items-center gap-2 rounded-lg border border-transparent font-semibold bg-tartiary-200 text-primary-400">
                  09.00 - 15.00
                </button>
              </div>
              <div class="flex flex-wrap items-center gap-4">
                <h3 class="text-white">Jam Istirahat</h3>
                <button type="button" class="py-2 px-5 text-base inline-flex justify-center items-center gap-2 rounded-lg border border-transparent font-semibold bg-tartiary-200 text-primary-400">
                  12.00 - 13.00
                </button>
              </div>
            </div>
            <div class="text-white w-full md:w-2/5 mt-5 md:mt-0">
              <h3 class="inline-flex mr-1.5">Pengambilan Berkas</h3>
              <span class="text-xl font-thin">Bisa dilakukan sampai pukul</span>
              <h3 class="inline-flex ml-1.5">16.00</h3>
            </div>
           
          </div>
        </div>
      </div>
    </section>
    <section class="my-20">
      <div class="container mx-auto px-6">
        <h2 class="text-primary-400 mb-3">Tata Tertib</h2>
        <div class="card rounded-lg border-[1px] border-neutral-200 relative">
          <div class="card-body py-14 md:py-20 px-8 md:px-14 flex flex-wrap">
            <ol class="list-decimal list-inside text-lg md:text-base">
              <li class="mb-3 md:mb-2">Mahasiswa wajib membawa KTM  sebagai tanda pengenal.</li>
              <li class="mb-3 md:mb-2">Pakaian sopan berkerah dan menggunakan sepatu, saat memasuki ruangan.</li>
              <li class="mb-3 md:mb-2">Menjaga etika dan sopan santun saat berinteraksi.</li>
              <li class="mb-3 md:mb-2">Mahasiswa mengambil antrian melalui mesin antrian.</li>
              <li class="mb-3 md:mb-2">Pelayanan diproses selama jam operasional.</li>
            </ol>
            <div class=""></div>
          </div>
          <div class="">
            <img class="hidden lg:block absolute bottom-0 right-0 mt-10" src="../../../images/fitri.png" alt="">
          </div>
          
        </div>
      </div>
    </section>
    <section class="my-20">
      <div class="container mx-auto px-6">
        <h2 class="text-primary-400 mb-3">Struktur Organisasi</h2>
        <div>
          <img class="w-full h-auto" src="../../../images/struktur-bagan.png" alt="">
        </div>
      </div>
    </section>
  </BaseLayout>
</template>