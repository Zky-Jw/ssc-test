<script setup>
import { Head, Link } from "@inertiajs/vue3";
import BaseLayout from '@/Layouts/BaseLayout.vue';
import SearchSelect from '@/Components/SearchSelect.vue';
import InformationData from '@/Components/InformationData.vue';


const props = defineProps({
  services: Array,
});
</script>

<template>

  <Head title="Layanan Mandiri" />
  <BaseLayout>
    <section class="my-24 mt-40">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-primary-400 text-center font-bold text-5xl mb-16">Layanan Mandiri</h2>
        <div
          class="flex flex-col bg-white border border-gray-200 shadow-md rounded-2xl py-5 px-7 md:py-8 md:px-10 mb-10">
          <div class="inline-block lg:flex items-center gap-6">

            <div class="inline-flex lg:flex rounded-full border-4 border-primary-400 py-1.5 px-7 items-center mb-4 lg:mb-0">
              <Icon icon="mingcute:warning-line" class="text-3xl mr-1.5 font-bold text-primary-400"/>
              <span class="font-semibold text-xl text-primary-400">Catatan</span>
            </div>
            <div>
              <p class="text-base font-normal">
                Layanan ini harap dilaporkan maksimal H-1 sebelum acara demi tercapainya suasana pengerjaan yang
                kondusif.
                Pengerjaan akan memakan waktu kurang lebih 3 hari kerja
              </p>

            </div>
          </div>

        </div>
        <!-- <div class="mx-auto max-w-3xl">
          <SearchSelect />
        </div> -->
        <div class="my-10">
          <InformationData :services="services" />
        </div>
      </div>
    </section>
  </BaseLayout>
</template>