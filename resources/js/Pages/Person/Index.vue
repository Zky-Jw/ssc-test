<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage, router } from '@inertiajs/vue3';
import ButtonAction from '@/Components/ButtonAction.vue';
import ButtonCreate from '@/Components/ButtonCreate.vue';
import { debounce } from 'lodash';
import { usePagination, useRowsPerPage } from "use-vue3-easy-data-table";
import { defineProps, onMounted, ref, watch } from 'vue';

const pageTitle = ref('Person');
const props = defineProps({
    person: Object,
});
const loading = ref(false);
const serverItemsLength = ref(0);
const isMobileView = ref(false);
const dataTable = ref();
const jumpToPageValue = ref(1);
const {
    currentPageFirstIndex,
    currentPageLastIndex,
    clientItemsLength,
    maxPaginationNumber,
    currentPaginationNumber,
    isFirstPage,
    isLastPage,
    nextPage,
    prevPage,
    updatePage,
} = usePagination(dataTable);

const {
    rowsPerPageOptions,
    rowsPerPageActiveOption,
    updateRowsPerPageActiveOption,
} = useRowsPerPage(dataTable);

const data = ref(props.person.data);
const searchValue = ref("");
const form = useForm({ id: '' });

// Check if mobile view should be used
const checkMobileView = () => {
    isMobileView.value = window.innerWidth < 768;
};

// Initialize mobile view check
if (typeof window !== 'undefined') {
    checkMobileView();
    window.addEventListener('resize', checkMobileView);
}

// Methods untuk mobile footer
const updateRowsPerPageSelect = (e) => {
    updateRowsPerPageActiveOption(Number(e.target.value));
};

const getVisiblePages = () => {
    const current = currentPaginationNumber.value;
    const total = maxPaginationNumber.value;

    if (total <= 7) return Array.from({ length: total }, (_, i) => i + 1);

    const pages = [];

    // Selalu tampilkan halaman 1
    pages.push(1);

    if (current > 4) pages.push('...');

    const start = Math.max(2, current - 1);
    const end = Math.min(total - 1, current + 1);

    for (let i = start; i <= end; i++) {
        if (i !== 1 && i !== total) {
            pages.push(i);
        }
    }

    if (current < total - 3) {
        pages.push('...');
    }

    if (total > 1) pages.push(total);

    return pages;
};

const getInitialFilters = () => {
    const urlParams = new URLSearchParams(window.location.search);

    return {
        search: urlParams.get('search') || "",
        page: parseInt(urlParams.get('page')) || 1,
        limit: parseInt(urlParams.get('limit')) || 10,
        sortBy: urlParams.get('sortBy') || "per_id",
        sortType: urlParams.get('sortType') || 'asc'
    };
};

const initialFilters = getInitialFilters();

const serverOptions = ref({
    page: initialFilters.page,
    rowsPerPage: initialFilters.limit,
    sortBy: initialFilters.sortBy,
    sortType: initialFilters.sortType,
});

const headers = ref([
    { text: "Nama", value: "person", sortable: true, fixed: true, width: 200 },
    { text: "NIM/NIP", value: "per_num", sortable: true },
    { text: "No. HP", value: "per_phone", width: 150 },
    { text: "Email", value: "per_email", width: 300 },
    { text: "Program Studi", value: "per_major", width: 200 },
    { text: "Grup", value: "per_group" },
    { text: "Action", value: "id" },
]);

const loadData = (filters, resetPage = true) => {
    loading.value = true
    const query = {};

    if (filters?.search) query.search = filters.search;

    if (resetPage) serverOptions.value.page = 1;

    query.limit = serverOptions.value.rowsPerPage;
    query.page = serverOptions.value.page;
    query.sortBy = serverOptions.value.sortBy;
    query.sortType = serverOptions.value.sortType;

    router.get('/dashboard/person', query, {
        only: ['person'],
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page) => {
            loading.value = false;
            data.value = page.props.person.data
            serverItemsLength.value = page.props.person.total;
        },
    });
};

const handleSearch = debounce(() => {
    loadData({ search: searchValue.value }, true);
}, 500);

watch(() => serverOptions.value, (newValue, oldValue) => {
    const isOnlyPageChange = newValue.page !== oldValue.page &&
        newValue.rowsPerPage === oldValue.rowsPerPage &&
        newValue.sortBy === oldValue.sortBy &&
        newValue.sortType === oldValue.sortType;

    loadData({ search: searchValue.value, }, !isOnlyPageChange);
});

watch(currentPaginationNumber, (newPage) => {
    jumpToPageValue.value = newPage;
});

onMounted(() => {
    loadData()
    serverItemsLength.value = props.person.total || 0;

    const urlParams = new URLSearchParams(window.location.search);
    const hasSpecificFilters = urlParams.has('search');

    if (!hasSpecificFilters) loadData({ search: '' }, true)
})
</script>

<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout :page-title="pageTitle">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create or just look for the person
            </h2>
        </template>
        <div class="w-full mx-auto sm:px-6 lg:px-8 py-6">
            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <div class="bg-white border-b border-gray-200">
                    <!-- Header Section -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 sm:p-6 gap-4">
                        <div>
                            <h3 class="text-primary-400 text-center">Person List</h3>
                        </div>
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                            <ButtonCreate button-text="Create Person" create-route="person.create"></ButtonCreate>
                        </div>
                    </div>

                    <div class="px-4 sm:px-6 pb-4">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-4">
                            <div class="flex flex-col lg:flex-row lg:items-center w-full sm:w-auto">
                                <label for="search-person"
                                    class="text-sm hidden lg:block font-medium text-gray-700 mr-3 whitespace-nowrap">
                                    Pencarian
                                </label>
                                <input id="search-person" v-model="searchValue" type="text" @input="handleSearch"
                                    class="flex-1 sm:w-64 py-2 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-1 focus:ring-primary-300"
                                    placeholder="Search">
                            </div>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <div class="px-4 sm:px-6 pb-6">
                            <EasyDataTable ref="dataTable" v-model:server-options="serverOptions"
                                :server-items-length="serverItemsLength" :headers="headers"
                                :buttons-pagination="!isMobileView" :hide-footer="isMobileView" show-index alternating
                                must-sort :rows-items="[10, 25, 50, 100]" :loading="loading" :search-value="searchValue"
                                :items="data" class="min-w-full">
                                <template #header-per_major="header">
                                    <div class="text-center mx-auto">
                                        {{ header.text }}
                                    </div>
                                </template>
                                <template #item-id="item">
                                    <div class="whitespace-nowrap text-sm font-medium text-primary-300">

                                        <ButtonAction :item="item" edit-route="person.edit" :form="form"
                                            delete-route="person.destroy" />
                                    </div>
                                </template>
                                <template #item-per_major="item">
                                    <p class="text-xs text-center">
                                        {{ item.per_major.replace(/ - Kampus Surabaya/i, '') || '-' }}
                                    </p>
                                </template>
                            </EasyDataTable>

                            <!-- Custom Mobile Footer - tampil hanya di mobile -->
                            <div v-if="isMobileView"
                                class="mobile-footer bg-white border-t border-gray-200 p-4 mt-4 rounded-b-lg">
                                <!-- Rows per page selector -->
                                <div class="mobile-rows-section mb-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <span class="text-sm text-gray-600 font-medium">row per page:</span>
                                        <select :value="rowsPerPageActiveOption" @change="updateRowsPerPageSelect"
                                            class="mobile-select px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-400 bg-white min-w-[60px]">
                                            <option v-for="item in rowsPerPageOptions" :key="item" :value="item">
                                                {{ item }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Data info -->
                                <div class="text-center mb-4">
                                    <span class="text-sm text-gray-600">
                                        {{ currentPageFirstIndex }}-{{ currentPageLastIndex }} of {{ serverItemsLength }}
                                    </span>
                                </div>

                                <!-- Navigation Section -->
                                <div class="mobile-navigation-section">
                                    <!-- First/Previous/Next/Last buttons -->
                                    <div class="flex items-center justify-center space-x-1 mb-4">
                                        <!-- First page -->
                                        <button @click="updatePage(1)" :disabled="isFirstPage"
                                            class="mobile-nav-btn p-2 rounded border border-gray-300 bg-white disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors"
                                            title="First page">
                                            <Icon icon="heroicons:chevron-double-left" class="w-4 h-4" />
                                        </button>

                                        <!-- Previous page -->
                                        <button @click="prevPage" :disabled="isFirstPage"
                                            class="mobile-nav-btn p-2 rounded border border-gray-300 bg-white disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors"
                                            title="Previous page">
                                            <Icon icon="heroicons:chevron-left" class="w-4 h-4" />
                                        </button>

                                        <!-- Next page -->
                                        <button @click="nextPage" :disabled="isLastPage"
                                            class="mobile-nav-btn p-2 rounded border border-gray-300 bg-white disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors"
                                            title="Next page">
                                            <Icon icon="heroicons:chevron-right" class="w-4 h-4" />
                                        </button>

                                        <!-- Last page -->
                                        <button @click="updatePage(maxPaginationNumber)" :disabled="isLastPage"
                                            class="mobile-nav-btn p-2 rounded border border-gray-300 bg-white disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors"
                                            title="Last page">
                                            <Icon icon="heroicons:chevron-double-right" class="w-4 h-4" />
                                        </button>
                                    </div>

                                    <!-- Page Numbers Section -->
                                    <div class="page-numbers-section mb-3">
                                        <div class="flex justify-center items-center space-x-1 flex-wrap">
                                            <template v-for="(page, index) in getVisiblePages()" :key="index">
                                                <!-- Ellipsis -->
                                                <span v-if="page === '...'" class="px-2 py-1 text-gray-400 text-sm">
                                                    ...
                                                </span>
                                                <!-- Page number -->
                                                <button v-else @click="updatePage(page)"
                                                    class="mobile-page-btn px-3 py-2 text-sm border rounded transition-colors min-w-[40px]"
                                                    :class="{
                                                        'bg-green-500 text-white border-green-500 font-semibold': page === currentPaginationNumber,
                                                        'border-gray-300 hover:bg-gray-50 text-gray-700': page !== currentPaginationNumber
                                                    }">
                                                    {{ page }}
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
