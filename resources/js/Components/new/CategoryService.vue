<script setup>
import { dataCategory } from '@/Components/JsonCategory.vue';
import { Link } from "@inertiajs/vue3";

const displayListLayanan = (id) => {
  dataCategory.serviceId = 1
  dataCategory.displayLayanan = id
}

const displayDetailLayanan = (id) => {
  dataCategory.serviceId = id
}
</script>

<template>
  <section class="my-24" id="kategori-layanan">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="font-black text-3xl md:text-4xl font-poppins">
          Informasi Unit
        </h2>
      </div>
      <div class="grid lg:grid-cols-12 gap-4 lg:divide-x-2 lg:divide-neutral-400 mb-28">
        <div class="lg:col-span-6">
          <div class="grid grid-cols-2 lg:grid-cols-3">
            <div v-for="item in dataCategory.layanan" :key="item" class="mr-4 lg:mr-5 mb-5">
              <div @click="displayListLayanan(item.id)"
                class="p-3 lg:p-3 text-center cursor-pointer border-2 rounded-lg overflow-hidden h-full"
                :class="dataCategory.displayLayanan === item.id ? 'bg-primary-400' : 'border-primary-400'">
                <lord-icon style="width: 75px; height: 75px" :src="`https://cdn.lordicon.com/${item.icon}.json`"
                  trigger="hover"
                  :colors="`primary:${dataCategory.displayLayanan === item.id ? '#ffffff' : item.colorPrimary},secondary:${dataCategory.displayLayanan === item.id ? '#ffffff' : item.colorSecondary}`">
                </lord-icon>
                <h6 class="text-center text-sm break-words font-medium"
                  :class="dataCategory.displayLayanan === item.id ? 'text-white' : 'text-dark'">{{ item.title }}</h6>
              </div>
            </div>
          </div>
        </div>
        <div class="lg:col-span-6">
          <div v-for="item in dataCategory.layanan" :key="item" v-show="dataCategory.displayLayanan == item.id" v-cloak
            class="pl-5">
            <div>
              <h4 class="text-primary-400 text-2xl lg:text-3xl font-bold">{{ item.informationTitle }}</h4>
              <p class="my-5">{{ item.informationDescription }}</p>
              <!-- <div class="mb-5 group">
                <a :href="item.igUrl" target="_blank"
                  class="inline-flex items-center px-5 py-3 border-2 border-gray-400 text-primary-400 font-semibold rounded-lg group-hover:bg-primary-400 group-hover:text-white">
                  <Icon icon="ri:instagram-line" class="text-xl inline-block mr-3" />
                  <span class="">{{ item.igUsername }}</span>
                </a>
              </div> -->
              <!-- <div v-if="item.webUrl.length < 2" class="group mb-3">
                <a :href="item.webUrl" target="_blank"
                  class="inline-flex items-center px-5 py-3 border-2 border-gray-400 text-primary-400 font-semibold rounded-lg group-hover:bg-primary-400 group-hover:text-white">
                  <Icon icon="tabler:world" class="text-xl inline-block mr-3" />
                  <span class="">{{ item.webUrl[0] }}</span>
                </a>
              </div>
              <div v-else v-for="webUrl in item.webUrl" class="group mb-3">
                <a :href="webUrl" target="_blank"
                  class="inline-flex items-center px-5 py-3 border-2 border-gray-400 text-primary-400 font-semibold rounded-lg group-hover:bg-primary-400 group-hover:text-white">
                  <Icon icon="tabler:world" class="text-xl inline-block mr-3" />
                  <span class="">{{ webUrl }}</span>
                </a>
              </div> -->
              <div>
                <Link :href="'/layanan-mandiri'"
                  class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-primary-400 text-white hover:bg-primary-500 disabled:opacity-50 disabled:pointer-events-none">
                <span>Informasi Layanan Mandiri</span>
                <Icon icon="bx:bxs-right-arrow" class="text-lg" />
                </Link>
              </div>

            </div>
          </div>
        </div>
      </div>
      <!-- <div v-for="item in dataCategory.layanan" :key="item"
        v-show="dataCategory.displayLayanan == item.id && item.service.length" v-cloak>
        <div class="text-center mb-16">
          <h2 class="font-black text-3xl md:text-4xl font-poppins">
            Informasi Layanan {{ item.title }}
          </h2>
        </div>

        <div class="flex flex-wrap items-start gap-x-14 gap-y-4">
          <div class="w-full lg:w-[30%] xl:w-[30%] shadow-md rounded-md border-[1px]">
            <div v-for="(itemService, index) in item.service" :item="itemService"
              @click="displayDetailLayanan(itemService.id)" :class="[(dataCategory.serviceId == itemService.id ? 'border-primary-400 bg-primary-400' : 'border-neutral-200 hover:border-primary-400 hover:bg-primary-400'),
              (index == item.service.length - 1 ? 'rounded-b-lg' : 'border-b-2'), (index == 0 ? 'rounded-t-lg' : '')]"
              class="group px-4 py-3 cursor-pointer transition-all duration-200">
              <p :class="dataCategory.serviceId == itemService.id ? 'text-white' : 'group-hover:text-white text-primary-400'"
                class="text-base mb-0 font-medium">{{ itemService.title }}</p>
            </div>
          </div>
          <div v-for="(itemService, index) in item.service" :item="itemService"
            :class="dataCategory.serviceId == itemService.id ? 'w-full lg:w-[60%] xl:w-[65%]' : 'hidden'">
            <div v-show="dataCategory.serviceId == itemService.id" v-cloak
              class="rounded-lg shadow-lg border-2">
              <div class="card-header text-primary-400 py-3 px-5 border-b-2">
                <h3 class="font-semibold">{{ itemService.title }}</h3>
              </div>
              <div v-if="['FTIB', 'FTEIC', 'Pusat Bahasa & Perpustakaan', 'Linktree SSC'].includes(item.title)"
                class="px-7 py-5">
                <div class="hs-accordion-group" data-hs-accordion-always-open>
                  <div v-if="itemService.accordionService.length" v-for="accordion in itemService.accordionService"
                    class="hs-accordion mb-3" :id="`hs-basic-no-arrow-heading-${accordion.id}`">
                    <button
                      class="group hs-accordion-toggle w-full py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-gray-200 font-semibold bg-white text-primary-400 text-sm mb-1"
                      aria-controls="hs-basic-no-arrow-collapse-one">
                      {{ accordion.title }}
                    </button>
                    <div :id="`hs-basic-no-arrow-collapse-${accordion.id}`"
                      class="hs-accordion-content hidden w-full mb-5 justify-center items-center gap-2 rounded-md border border-gray-200 bg-white overflow-hidden transition-[height] duration-300"
                      :aria-labelledby="`hs-basic-no-arrow-heading-${accordion.id}`">
                      <div class="py-3 px-4">
                        <div class="mb-5 description">
                          <p class="text-sm font-semibold text-gray-700">Deskripsi: </p>
                          <span class="text-sm">{{ accordion.description }}</span>
                        </div>
                        <div v-if="accordion.duration != null" class="mb-5 duration">
                          <p class="text-sm font-semibold text-gray-700">Durasi Pengerjaaan: </p>
                          <span class="text-sm">{{ accordion.duration }}</span>
                        </div>
                        <div v-if="accordion.requirement.length" class="mb-5 req">
                          <p class="text-sm font-semibold text-gray-700">Persyaratan: </p>
                          <ul class="list-disc list-outside pl-4 text-sm">
                            <li v-for="req in accordion.requirement">
                              {{ req }}
                            </li>
                          </ul>
                        </div>
                        <div v-if="accordion.linkList.length" class="mb-5 link-list">
                          <p class="text-sm font-semibold text-gray-700">Link Akses: </p>
                          <ul class="list-disc list-outside pl-4 text-sm text-primary-200">
                            <li v-for="link in accordion.linkList">
                              <a :href="link" target="_blank" class="text-primary-200 font-medium hover:underline">
                                {{ link }}
                              </a>
                            </li>
                          </ul>
                        </div>
                      </div>

                    </div>
                  </div>

                </div>
              </div>
              <div v-else class="card-body py-5 px-7">
                <div class="description mb-4">
                  <p class="font-bold mb-2 text-base">Deskripsi : <span class="font-light">{{
                    itemService.description }}</span></p>
                  <p class="font-bold mb-2 text-base">Pengerjaaan : <span class="font-light">{{ itemService.duration
                      }}</span></p>
                  <p class="font-bold mb-0 text-base">Requirement : <span v-if="!itemService.requirement.length"
                      class="font-light">-</span></p>
                  <ul v-if="itemService.requirement.length" class="list-disc list-outside pl-4 text-sm">
                    <li v-for="req in itemService.requirement">
                      {{ req.title }}
                      <a v-if="req.link != null" :href="req.link" target="_blank"
                        class="text-primary-400 hover:underline font-semibold text-sm">
                        Link
                        <Icon icon="quill:link-out" class="inline-flex items-center mr-1" />
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
    </div>
  </section>
</template>
