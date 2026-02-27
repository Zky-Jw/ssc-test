<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import SearchSelect from '@/Components/SearchSelect.vue';
import InformationData from '@/Components/InformationData.vue';
import Linktree from '@/Components/Linktree.vue';

import { defineProps } from 'vue';
const props = defineProps({
  services: Array,
});
</script>

<template>
  <Head title="Student Service Center" />
  <Navbar class="bg-gradient-primary pb-8 md:pt-8 w-full z-20"></Navbar>
  <section class="my-12">
    <div class="container mx-auto px-5 md:px-16">
      <h2 class="text-primary-500 text-center font-bold font-quicksand">Layanan Mandiri</h2>
      <div class="my-9 bg-secondary-300 rounded-md px-10 py-7 w-full">
        <p class="font-bold text-base">Catatan </p>
        <p class="text-base">Layanan ini harap dilaporkan maksimal H-1 sebelum acara demi tercapainya suasana pengerjaan
          yang kondusif. Pengerjaan akan memakan waktu kurang lebih 3 hari kerja</p>
      </div>
      <!-- <div class="mx-auto max-w-3xl">
        <SearchSelect />
      </div> -->
      <div class="my-10">
        <InformationData  :services="services"/>
      </div>
      

    </div>
  </section>
  <Linktree :class="`mt-20 bg-primary-400 py-12`"/>
  <Footer :is-footer-simple="false" />
</template>
