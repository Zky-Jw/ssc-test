<script setup>
import { Head, Link } from '@inertiajs/vue3';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { ref, onMounted, computed, defineProps } from "vue";
import List from "list.js";
// import { Header, Item } from "vue3-easy-data-table";

const props = defineProps({
  ticket: Array,
  creatorData: Object,
});

const encodeText = (text) => {
  return text.replace(/[\u00A0-\u9999<>\&]/gim, function (i) {
    return '&#' + i.charCodeAt(0) + ';';
  });
};


const decodeText = (text) => {
  return text.replace(/&#(\d+);/g, function (match, dec) {
    return String.fromCharCode(dec);
  });
};

const notValid = 'invalid data';
// foreach ticket data make a new array with ?? option in each index
const data = ref(props.ticket.map((item) => ({
  ...item,
  created: item.created.createdat ?? '',
  creator: decodeText(item.person['creator']['name']) ?? notValid,
  unit: item.purpose.service.name +"-"+ item.purpose.unit.name ?? notValid,
  summary: item.content ?? notValid,
  number: item.ticketNumber ?? notValid,
  status: item.status,
  href: item._id,
})));


// const headers = ref([
//   { text: "#", value: "id", sortable: true },
//   { text: "NOMER TIKET", value: "no_tiket", sortable: true },
//   { text: "LAYANAN/UNIT", value: "layanan", },
//   { text: "STATUS TIKET", value: "status_tiket", sortable: true },
//   { text: "TANGGAL PENGAJUAN", value: "tanggal", sortable: true },
//   { text: "RINGKASAN AJUAN", value: "ringkasan" },
//   { text: "#", value: "href" },
// ]);
const headers = ref([
	{ text: "NOMOR TIKET", value: "number", sortable: true, fixed: true, width: 75 },
  { text: "LAYANAN/UNIT", value: "unit", width: 200 },
	{ text: "STATUS TIKET", value: "status", width: 100 },
	{ text: "TANGGAL PENGAJUAN", value: "created", width: 100 },
	{ text: "RINGKASAN AJUAN", value: "summary", width: 200 },
	{ text: "ACTION", value: "href" },
]);

const searchValue = ref("");

</script>

<template>

  <Head title="Riwayat Pengajuan" />
  <BaseLayout>
    <section class="mb-20 mt-32">
      <div class="container mx-auto px-4">
        <h2 class="text-center">Riwayat Pengajuan Tiket <span class="text-primary-400">{{ creatorData.name }}</span></h2>
        <div class="my-12">

          <div class="flex items-center justify-center">
            <div id="history" class="card flex flex-col w-full shadow-lg rounded-lg border-[1px] border-neutral-200">
              <div
                class="card-header block md:flex justify-between items-center px-9 py-5 border-b-[1px] border-neutral-200">
                <h3 class="font-bold text-primary-400 mb-3 md:mb-0">Pengajuan Tiket</h3>
                <div class="flex items-center">
                  <p class="text-base">Pencarian</p>
                  <input v-model="searchValue" type="text"
                    class="search py-1 px-5 ml-2 block w-full border-neutral-500 rounded-md text-sm "
                    placeholder="Search">
                </div>
              </div>
              <EasyDataTable buttons-pagination :headers="headers" :items="data" class="w-full px-8" show-index
                alternating :search-value="searchValue">
                <template #item-status="item">
                  <td class="font-semibold uppercase" :class="{
                    'text-red-700': item.status.toUpperCase() === 'OPEN',
                    'text-orange-700': item.status.toUpperCase() === 'ON HOLD',
                    'text-green-700': item.status.toUpperCase() === 'CLOSED'
                  }">{{ item.status }}</td>
                </template>
                <template #item-created="item">
                  <td class="font-regular"> {{ item.created === '' ? notValid :
                    $dateFormatIndo(item.created) }}</td>
                </template>
                <template #item-summary="item">
                  <td class="font-regular" v-html="$truncateParagraph(item.summary, 10)"></td>
                </template>
                <template #item-person="item">
                  <td class="font-regular">{{ ($makeTitle($makeShortName(item.person)) ??
                    $makeTitle('belum ada petugas')) ?? notValid }}</td>
                </template>
                <template #item-href="item">
                  <td class="py-2">
                    <a :href="`/detail-ticket/`+item.href"
                      class="py-2 px-2 inline-flex justify-center items-center gap-2 text-xs rounded-md border border-transparent font-semibold bg-primary-400 text-white hover:bg-primary-500">
                      Lihat Detail
                    </a>
                  </td>
                </template>
              </EasyDataTable>
            </div>
          </div>
        </div>
      </div>
    </section>
  </BaseLayout>
</template>
<style>
p{
  font-size: .75rem;
}
</style>
