<script setup>
import { Icon } from '@iconify/vue';
import { defineProps, reactive, computed, ref } from 'vue';

const props = defineProps({
  services: Array,
});

const dataServices = reactive({
  displayLayanan: 1,
  serviceId: 1,
  layanan: props.services || []
});

const isModalOpen = ref(false);

const currentService = computed(() => {
  return dataServices.layanan.find(service => service.id === dataServices.displayLayanan) || {};
});

const currentServiceDetail = computed(() => {
  if (!currentService.value || !currentService.value.service) return null;
  return currentService.value.service.find(item => item.id === dataServices.serviceId) || null;
});


const hasServiceData = computed(() => {
  return currentService.value && currentService.value.service && currentService.value.service.length > 0;
});

const displayListLayanan = (id) => {
  dataServices.serviceId = 1;
  dataServices.displayLayanan = id;
  openModal();
};

const displayDetailLayanan = (id) => {
  dataServices.serviceId = id;
};

const openModal = () => {
  isModalOpen.value = true;
  document.body.classList.add('overflow-hidden');
};

const closeModal = () => {
  isModalOpen.value = false;
  document.body.classList.remove('overflow-hidden');
};

const processHtml = (htmlString) => {
  if (!htmlString) return '';

  const parser = new DOMParser();
  const doc = parser.parseFromString(htmlString, 'text/html');
  const links = doc.querySelectorAll('a');
  links.forEach(link => {
    link.setAttribute('target', '_blank');
    const href = link.getAttribute('href');
    if (href && !href.startsWith('http://') && !href.startsWith('https://')) {
      link.setAttribute('href', `https://${href}`);
    }
  });
  return doc.body.innerHTML;
};
</script>

<template>
  <div>
    <section class="my-16">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <button v-for="item in dataServices.layanan" :key="item.id" @click="displayListLayanan(item.id)"
            :class="dataServices.displayLayanan === item.id ? 'border-primary-400 bg-primary-400 text-white' : 'border-neutral-400 hover:border-primary-400 hover:bg-primary-400 hover:text-white'"
            class="group px-4 py-2 border-2 rounded-lg mr-5 font-semibold cursor-pointer text-base flex flex-col items-center mb-4">
            <span class="p-1.5 rounded-full mb-2">
              <Icon class="text-4xl md:text-5xl" :icon="item.icons"
                :class="dataServices.displayLayanan === item.id ? 'text-white' : 'text-primary-400 group-hover:text-white'" />
            </span>
            <span>{{ item.title }}</span>
          </button>
        </div>
      </div>
    </section>

    <!-- Init Modal -->
    <div :class="isModalOpen ? 'flex' : 'hidden'" class="fixed inset-0 z-50 bg-black bg-opacity-50 overflow-hidden">
      <div class="flex flex-col bg-white w-full h-full animate-fade-in">
        <!-- Modal Header -->
        <div class="flex justify-between items-center py-3 px-4 md:px-6 border-b border-gray-200">
          <h3 class="font-bold text-lg md:text-xl text-gray-800">
            {{ currentService.title }} - Detail Layanan
          </h3>
          <button type="button" @click="closeModal"
            class="w-9 h-8 md:w-10 md:h-10 flex justify-center items-center rounded-full border border-transparent bg-primary-200 text-white hover:bg-primary-300">
            <span class="sr-only">Close</span>
            <Icon class="text-lg md:text-xl" icon="material-symbols:close" />
          </button>
        </div>

        <!-- Modal Body -->
        <div class="flex flex-col md:flex-row flex-1 overflow-hidden">
          <!-- Left Side -->
          <div
            class="w-full md:w-1/3 lg:w-1/4 border-b md:border-r md:border-b-0 border-gray-200 px-3 py-6 md:p-4 overflow-y-auto">
            <h4 class="font-bold text-base md:text-lg mb-3 md:mb-4">Daftar Layanan Unit Terkait</h4>
            <div class="flex flex-col gap-2 md:gap-3">
              <button v-for="itemService in currentService.service || []" :key="itemService.id"
                @click="displayDetailLayanan(itemService.id)"
                :class="dataServices.serviceId === itemService.id ? 'bg-primary-400 text-white' : 'bg-gray-200 text-gray-800 hover:bg-primary-400 hover:text-white'"
                class="py-2 px-3 md:px-4 rounded-lg font-medium text-left text-sm md:text-base">
                {{ itemService.title }}
              </button>
            </div>
          </div>

          <!-- Right Side -->
          <div class="w-full md:w-2/3 lg:w-3/4 p-4 md:p-6 overflow-y-auto">
            <!-- Current service detail -->
            <div v-if="currentServiceDetail" class="flex flex-col">
              <div class="text-center mb-4 md:mb-6">
                <h2 class="font-bold text-xl md:text-2xl text-primary-400">Informasi Layanan Terkait</h2>
              </div>
              <div class="flex flex-col border border-primary-400 py-4 md:py-5 px-4 md:px-7 rounded-2xl">
                <h4 class="text-primary-500 font-semibold text-lg md:text-xl mb-5 md:mb-7">{{ currentServiceDetail.title
                  }}</h4>
                <div class="description mb-4">
                  <p class="font-bold mb-2 text-sm md:text-base">Deskripsi</p>
                  <p class="text-sm md:text-base font-poppins" v-html="currentServiceDetail.description"></p>
                </div>
                <div class="duration mb-4">
                  <p class="font-bold mb-2 text-sm md:text-base">Durasi</p>
                  <p class="text-sm md:text-base font-poppins">{{ currentServiceDetail.duration }}</p>
                </div>
                <div class="requirement mb-5 md:mb-7">
                  <p class="font-bold mb-2 text-sm md:text-base">Requirement</p>
                  <div class="text-sm md:text-base" v-html="processHtml(currentServiceDetail.requirement)"></div>
                </div>
                <div class="requirement mb-5 md:mb-7" v-if="currentServiceDetail.active !== 'Y'">
                  <p class="font-bold mb-2 text-sm md:text-base">Keterangan</p>
                  <div class="text-sm md:text-base" v-html="processHtml(currentServiceDetail.inactive_reason || '-')"></div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 md:gap-4">
                  <a href="#"
                    class="btn-off-full py-2 px-4 bg-gray-300 rounded-lg text-gray-800 text-center text-sm md:text-base"
                    v-if="currentServiceDetail.external_app === 'Y'">
                    Layanan Aplikasi Luar
                  </a>
                  <a
                    v-if="currentServiceDetail.active === 'Y'"
                    :href="`/buat-tiket/` + currentServiceDetail.uiid"
                     class="btn-ssc-1-full py-2 px-4 bg-primary-400 rounded-lg text-white text-center text-sm md:text-base">
                    Buat Tiket
                  </a>
                  <!-- <button @click="closeModal" class="py-2 px-4 border border-gray-300 rounded-lg text-sm md:text-base">
                    Tutup
                  </button> -->
                </div>
              </div>
            </div>

            <!-- Show when no service data is available -->
            <div v-if="!currentService.service || currentService.service.length === 0"
              class="flex justify-center items-center h-40 bg-gray-100 rounded-lg">
              <Icon icon="solar:danger-triangle-broken" class="mr-2 text-2xl md:text-3xl text-gray-600" />
              <p class="text-sm md:text-base text-gray-600 italic font-regular">Data belum ditambahkan</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.requirement div a {
  color: #6d263c;
  font-weight: bold;
  text-decoration: underline;
}

.animate-fade-in {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
