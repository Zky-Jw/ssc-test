<script setup>
import { reactive, computed, ref, onMounted, onUnmounted, watch } from 'vue';
import { Link } from "@inertiajs/vue3";
import Logo from "../../../images/logo-telu-sby.png";
import Modal from "../Modal.vue"
import { usePage } from "@inertiajs/vue3";
import { debounce } from "lodash";
import axios from 'axios';

const searchState = reactive({ show: false });
const searchQuery = ref('');
const searchInput = ref(null);
const searchResults = ref([]);
const isSearching = ref(false);
const searchTimeout = ref(null);
const popularServices = ref([]);

defineProps({
    isLoginPage: Boolean,
});

const page = usePage();

const isLogin = computed(() => page.props.auth.user);

// Handle ESC key to close modal
const handleEscKey = (event) => {
    if (event.key === 'Escape') {
        hideSearchModal();
    }
};

const lockBodyScroll = () => {
    document.body.style.overflow = 'hidden';
    document.body.style.paddingRight = getScrollbarWidth() + 'px';
};

const unlockBodyScroll = () => {
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
};

// Function to get scrollbar width to prevent layout shift
const getScrollbarWidth = () => {
    const outer = document.createElement('div');
    outer.style.visibility = 'hidden';
    outer.style.overflow = 'scroll';
    outer.style.msOverflowStyle = 'scrollbar';
    document.body.appendChild(outer);

    const inner = document.createElement('div');
    outer.appendChild(inner);

    const scrollbarWidth = outer.offsetWidth - inner.offsetWidth;
    outer.parentNode.removeChild(outer);

    return scrollbarWidth;
};

const showSearchModal = () => {
    searchState.show = true;
    lockBodyScroll();
    // Focus pada input setelah modal terbuka
    setTimeout(() => {
        if (searchInput.value) {
            searchInput.value.focus();
        }
    }, 200);
};

const hideSearchModal = () => {
    searchState.show = false;
    searchQuery.value = '';
    searchResults.value = [];
    isSearching.value = false;
};

// Main search method
const performSearch = debounce(async (query) => {
    if (!query || query.length < 2) {
        searchResults.value = [];
        return
    };

    isSearching.value = true;

    try {
        const response = await axios.get('/search/services', {
            params: {
                q: query,
                limit: 10
            }
        });

        if (response.data.code === 200) {
            searchResults.value = response.data.data;
        } else {
            searchResults.value = [];
        }
    } catch (error) {
        searchResults.value = [];
    } finally {
        isSearching.value = false;
    }
}, 500)

const selectSearchResult = (result) => {
    window.location.href = `/buat-tiket/${result.id}`;
    hideSearchModal();
};

const getPopularService = async () => {
    await axios.get('/sync-service-data')
        .then((res) => popularServices.value = res.data)
}

const navList = [
    {
        name: "Tentang Kami",
        link: "/#about",
        behavior: true,
    },
    {
        name: "Panduan",
        link: "/#panduan",
        behavior: true,
    },
    {
        name: "Kategori Layanan",
        link: "/#kategori-layanan",
        behavior: true,
    },
    {
        name: "Layanan Mandiri",
        link: "/layanan-mandiri",
        behavior: false,
    },
];

onMounted(async () => {
    document.addEventListener('keydown', handleEscKey);

    await getPopularService()
});

onUnmounted(() => {
    document.removeEventListener('keydown', handleEscKey);
    if (searchTimeout.value) {
        clearTimeout(searchTimeout.value);
    }

    unlockBodyScroll();
});
</script>


<template>
    <!-- ========== HEADER ========== -->
    <header
        class="flex flex-wrap lg:justify-start lg:flex-nowrap bg-white py-4 fixed w-full z-20 top-0 start-0 shadow shadow-neutral-200/40">
        <nav class="relative max-w-[90rem] w-full flex flex-wrap lg:grid lg:grid-cols-12 basis-full items-center px-4 mx-auto"
            aria-label="Global">
            <div class="lg:col-span-2 text-center">
                <!-- Logo -->
                <a class="flex-none rounded-xl text-xl inline-block font-semibold focus:outline-none focus:opacity-80"
                    href="/" aria-label="Preline">
                    <img :src="Logo" alt="Flowbite Logo" class="" />
                </a>
                <!-- End Logo -->
            </div>

            <!-- Button Group -->
            <div v-if="!isLoginPage" class="flex items-center gap-x-2 ms-auto py-1 lg:ps-6 lg:order-3"
                :class="!isLogin ? 'lg:col-span-2' : 'lg:col-span-4'">
                <!-- Desktop Search Button -->
                <button @click="showSearchModal"
                    class="items-center px-5 py-2 border-2 text-primary-400 hover:bg-primary-400 hover:text-white border-primary-400 rounded-full font-bold transition-all duration-200 text-sm whitespace-nowrap hidden lg:flex">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Cari Layanan</span>
                </button>

                <Link v-if="!isLogin" :href="'/operator-sign-in'"
                    class="px-7 py-1.5 border-2 bg-primary-400 hover:bg-primary-500 text-white rounded-full font-bold hidden lg:block transition-all duration-200">
                Masuk
                </Link>

                <Link v-if="isLogin" href="/dashboard"
                    class="px-7 py-1.5 border-2 text-primary-400 hover:bg-primary-400 hover:text-white border-primary-400 rounded-full font-bold hidden lg:block transition-all duration-200">
                Dashboard
                </Link>

                <Link v-if="isLogin"
                    href="/logout"
                    method="post"
                    as="button"
                    class="px-7 py-1.5 border-2 bg-primary-400 hover:bg-primary-500 text-white rounded-full font-bold hidden lg:block transition-all duration-200">
                    Keluar
                </Link>

                <!-- Mobile Search Button -->
                <button @click="showSearchModal"
                    class="flex items-center px-3 py-1.5 border-2 bg-primary-400 hover:bg-primary-500 text-white rounded-full font-bold transition-all duration-200 text-sm lg:hidden"
                    aria-label="Search">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="inline">Cari Layanan</span>
                </button>

                <div class="lg:hidden">
                    <button type="button"
                        class="hs-collapse-toggle size-[38px] flex justify-center items-center text-sm font-semibold text-black"
                        data-hs-collapse="#navbar-collapse-with-animation"
                        aria-controls="navbar-collapse-with-animation" aria-label="Toggle navigation">
                        <svg class="hs-collapse-open:hidden flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" x2="21" y1="6" y2="6" />
                            <line x1="3" x2="21" y1="12" y2="12" />
                            <line x1="3" x2="21" y1="18" y2="18" />
                        </svg>
                        <svg class="hs-collapse-open:block hidden flex-shrink-0 size-4"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- End Button Group -->

            <!-- Collapse -->
            <div v-if="!isLoginPage" id="navbar-collapse-with-animation"
                class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow lg:block lg:w-auto lg:basis-auto lg:order-2"
                :class="!isLogin ? 'lg:col-span-7' : 'lg:col-span-6'">
                <div
                    class="flex flex-col gap-y-4 gap-x-0 mt-5 lg:flex-row lg:justify-center lg:items-center lg:gap-y-0 lg:gap-x-7 lg:mt-0">
                    <!-- Gunakan v-if untuk menyembunyikan elemen -->
                    <div v-for="(item, index) in navList" :key="index">
                        <template v-if="item.behavior">
                            <a class="relative inline-block text-black text-sm hover-link-navbar" :href="item.link">
                                {{ item.name }}
                            </a>
                        </template>
                        <template v-else>
                            <Link class="relative inline-block text-black text-sm hover-link-navbar" :href="item.link">
                            {{ item.name }}
                            </Link>
                        </template>
                    </div>
                    <Link v-if="isLogin" class="relative inline-block text-black text-sm hover-link-navbar"
                        href="/riwayat-pengajuan">
                    Histori Layanan
                    </Link>

                    <div>
                        <Link v-if="!isLogin" :href="'/operator-sign-in'"
                            class="px-7 py-1.5 border-2 bg-primary-400 hover:bg-primary-500 text-white rounded-full font-bold inline-block lg:hidden transition-all duration-200">
                        Masuk
                        </Link>
                        <Link v-if="isLogin" :href="'/dashboard'"
                            class="px-7 py-1.5 border-2 text-primary-400 hover:bg-primary-400 hover:text-white border-primary-400 mr-2 rounded-full font-bold inline-block lg:hidden transition-all duration-200">
                        Dashboard
                        </Link>
                        <Link v-if="isLogin" href="/logout" method="post" as="button"
                            class="px-7 py-1.5 border-2 bg-primary-400 hover:bg-primary-500 text-white rounded-full font-bold inline-block lg:hidden transition-all duration-200">
                        Keluar
                        </Link>
                    </div>
                </div>
            </div>
            <!-- End Collapse -->
        </nav>
    </header>
    <!-- ========== END HEADER ========== -->

    <Modal :show="searchState.show" @close="hideSearchModal" max-width="2xl" max-height="h-fit" :shadow="false"
        :closeable="true">
        <template #overlay>
            <div @click="hideSearchModal" class="absolute inset-0 bg-gray-500 bg-opacity-50" aria-hidden="true"></div>
        </template>

        <template #default>
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-4 text-center sm:block sm:p-0">
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full max-h-[90vh] overflow-y-auto">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-medium text-gray-900" id="modal-title">
                                        Pencarian Layanan
                                    </h3>
                                    <button @click="hideSearchModal" type="button"
                                        class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-150">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="relative mb-4">
                                    <input ref="searchInput" v-model="searchQuery" type="text"
                                        @input="performSearch(searchQuery)"
                                        placeholder="Masukkan nama layanan yang dicari..."
                                        class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent transition-all duration-200" />
                                    <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>

                                    <!-- Loading indicator -->
                                    <div v-if="isSearching" class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                        <svg class="animate-spin h-5 w-5 text-primary-400"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Search Results Area -->
                                <div class="mb-4 min-h-[200px]">
                                    <!-- Search Results -->
                                    <div v-show="searchResults.length > 0" class="max-h-64 overflow-y-auto">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Hasil Pencarian</h4>
                                        <div class="space-y-2">
                                            <button v-for="result in searchResults" :key="result.id"
                                                @click="selectSearchResult(result)"
                                                class="w-full text-left p-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-primary-200 transition-all duration-200">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex-1">
                                                        <h5 class="font-medium text-gray-900">{{ result.name }}
                                                        </h5>
                                                        <p v-if="result.description" class="text-sm text-gray-600 mt-1">
                                                            {{ result.description }}</p>
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-200 text-white mt-2">
                                                            {{ result.unit }}
                                                        </span>
                                                    </div>
                                                    <svg class="w-5 h-5 text-gray-400 ml-2 transition-colors duration-150"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </div>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Default/No Results -->
                                    <div
                                    v-if="searchResults.length === 0 && !isSearching" class="text-center">
                                        <p class="text-sm text-gray-500">
                                            <span v-if="searchQuery.length >= 2">
                                                Tidak ada layanan yang ditemukan untuk "<strong>{{ searchQuery}}</strong>"
                                            </span>
                                            <span v-else>
                                                <button v-for="(item, index) in popularServices" :key="index"
                                                    @click="selectSearchResult(item)"
                                                    class="w-full text-left mb-2 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-primary-200 transition-all duration-200">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex-1">
                                                            <h5 class="font-medium text-gray-900">{{ item.service_name}}</h5>
                                                            <!-- <p v-if="result.description" class="text-sm text-gray-600 mt-1">
                                                        {{ result.description }}</p> -->
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-200 text-white mt-2">
                                                                {{ item.unit_name }}
                                                            </span>
                                                        </div>
                                                        <svg class="w-5 h-5 text-gray-400 ml-2 transition-colors duration-150"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                        </svg>
                                                    </div>
                                                </button>
                                            </span>
                                        </p>
                                    </div>

                                    <!-- Loading State -->
                                    <div v-show="isSearching" class="text-center py-8">
                                        <svg class="animate-spin mx-auto h-8 w-8 text-primary-400 mb-4"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <p class="text-sm text-gray-500">Mencari layanan...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </Modal>
</template>

<style scoped>
.shadow-navbar {
    box-shadow: 0px 4px 30px 0px rgba(0, 0, 0, 0.05);
}

/* Modal Transitions */
.modal-enter-active {
    transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

/* Focus Styles */
button:focus {
    outline: none;
}

.focus\:ring-2:focus {
    --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
    --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color);
    box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
}
</style>
