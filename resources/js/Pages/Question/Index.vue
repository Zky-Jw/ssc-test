<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, toRefs, watch, onMounted } from 'vue';
import { router } from '@inertiajs/vue3'
import ButtonCreate from '@/Components/ButtonCreate.vue';
import ButtonAction from '@/Components/ButtonAction.vue';
import { Icon } from '@iconify/vue';
import { debounce } from 'lodash';
import { usePagination, useRowsPerPage } from "use-vue3-easy-data-table";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { component as CKEditor } from '@ckeditor/ckeditor5-vue';
import { usePage } from '@inertiajs/vue3';


const props = defineProps({
    data: Object,
    units: Array
});

const { data, units } = toRefs(props)

const page = usePage()
const { profile } = page.props

const getInitialFilters = () => {
    const urlParams = new URLSearchParams(window.location.search);

    return {
        unit: urlParams.get('unit') || "",
        search: urlParams.get('search') || "",
        page: parseInt(urlParams.get('page')) || 1,
        limit: parseInt(urlParams.get('limit')) || 10,
        sortBy: urlParams.get('sortBy') || "questionNumber",
        sortType: urlParams.get('sortType') || 'desc'
    };
};

const dataTable = ref();
const jumpToPageValue = ref(1);
const loading = ref(false);
const serverItemsLength = ref(0);
const isMobileView = ref(false);
const initialFilters = getInitialFilters();
const searchValue = ref(initialFilters.search)
const filteredUnit = ref(initialFilters.unit);
const showUnitFilter = ref(false);
const showMobileFilters = ref(false);

const serverOptions = ref({
    page: initialFilters.page,
    rowsPerPage: initialFilters.limit,
    sortBy: initialFilters.sortBy,
    sortType: initialFilters.sortType,
});

const form = useForm({
    title: '',
    question: '',
    category: null
})

const editor = ClassicEditor;
const readOnlyConfig = ref({
    toolbar: [],
    isReadOnly: true,
    placeholder: ''
});

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

const headers = ref([
    { text: "Nomor", value: "questionNumber", sortable: true, fixed: true, width: !isMobileView ? 150 : 120},
    { text: "Judul", value: "title", width: 300 },
    { text: "Tanggal",value: "date", width: 200 },
    { text: "Unit", value: "category.unit.name", width: 200 },
    { text: "Layanan", value: "category.service.name", width: 200 },
    { text: "Action", value: "action" },
]);

const checkMobileView = () => {
    isMobileView.value = window.innerWidth < 768;
};

if (typeof window !== 'undefined') {
    checkMobileView();
    window.addEventListener('resize', checkMobileView);
}

const updateRowsPerPageSelect = (e) => {
    updateRowsPerPageActiveOption(Number(e.target.value));
};

const getVisiblePages = () => {
    const current = currentPaginationNumber.value;
    const total = maxPaginationNumber.value;

    if (total <= 7) {
        return Array.from({ length: total }, (_, i) => i + 1);
    }

    const pages = [];

    // Selalu tampilkan halaman 1
    pages.push(1);

    if (current > 4) {
        pages.push('...');
    }

    // Tampilkan 3 halaman di sekitar halaman aktif
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

    // Selalu tampilkan halaman terakhir jika lebih dari 1
    if (total > 1) {
        pages.push(total);
    }

    return pages;
};

const filterTickets = (filters, resetPage = true) => {
    loading.value = true
    const query = {};

    if (filters.search) {
        query.search = filters.search;
    }

    if (filters.unit) {
        query.unit = filters.unit;
        showUnitFilter.value = false;
    }

    if (resetPage) {
        serverOptions.value.page = 1;
    }

    query.limit = serverOptions.value.rowsPerPage;
    query.page = serverOptions.value.page;
    query.sortBy = serverOptions.value.sortBy;
    query.sortType = serverOptions.value.sortType;

    console.log("jenis query : ", query.sortType)

    router.get('/dashboard/question', query, {
        only: ['data'],
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page) => {
            loading.value = false;
            serverItemsLength.value = page.props.data.total;
        },
    });
};

const applyFilters = () => {
    filterTickets({
        unit: filteredUnit.value,
    }, true);
    showMobileFilters.value = false;
};

const handleSearch = debounce(() => {
    filterTickets({
        unit: filteredUnit.value,
        search: searchValue.value,
    }, true);
}, 500);

const handleExport = () => {
    const query = {};

    const canFilterUnit = ['102', '106'].includes(profile.role_id);



    if (canFilterUnit && filteredUnit.value) {
        query.unit = filteredUnit.value;
    }

    if (searchValue.value) {
        query.search = searchValue.value;
    }

    query.limit = serverOptions.value.rowsPerPage
    query.page = serverOptions.value.page
    query.sortBy = serverOptions.value.sortBy
    query.sortType = serverOptions.value.sortType

    const params = new URLSearchParams(query).toString();
    window.location.href = `/export/question?${params}`;
}

watch(currentPaginationNumber, (newPage) => {
    jumpToPageValue.value = newPage;
});

watch(
    [() => serverOptions.value, () => data.value.total],
    ([newServerOptions, newTotal], [oldServerOptions, oldTotal]) => {
        const isOnlyPageChange =
            newServerOptions.page !== oldServerOptions.page &&
            newServerOptions.rowsPerPage === oldServerOptions.rowsPerPage;

        filterTickets(
            {
                unit: filteredUnit.value,
                search: searchValue.value,
            },
            !isOnlyPageChange
        );
    }
);


onMounted(() => {
    serverItemsLength.value = data.value.total || 0;
});
</script>

<template>

    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create or just look for the question
            </h2>
        </template>

        <div class="w-full mx-auto sm:px-6 lg:px-8 py-6">
            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <!-- Header Section -->
                <div class="bg-white border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 sm:p-6 gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-primary-400">Question List</h3>
                        </div>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                            <button
                                class="px-4 py-2 text-white text-sm bg-primary-400 hover:bg-primary-300 rounded-md focus:outline-none inline-flex items-center justify-center"
                                @click="handleExport"
                            >
                                <Icon class="text-lg mr-2" icon="streamline:computer-printer-scan-device-electronics-printer-print-computer" />
                                Export Question
                            </button>
                            <ButtonCreate button-text="Create Question" create-route="question.create" />
                        </div>
                    </div>

                    <div class="px-4 sm:px-6 pb-4">
                        <!-- Search and Filters Section -->
                        <!-- Search & Mobile Filter Toggle -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-4">
                            <!-- Search -->
                            <div class="flex items-center w-full sm:w-auto">
                                <label class="text-sm font-medium text-gray-700 mr-3 hidden lg:block whitespace-nowrap">
                                    Pencarian
                                </label>
                                <input v-model="searchValue" type="text" placeholder="Search Question..."
                                    @input="handleSearch"
                                    class="flex-1 sm:w-64 py-2 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-400" />
                            </div>

                            <button
                                class="lg:hidden flex items-center px-3 py-2 text-sm border border-gray-300 rounded-md"
                                @click="showMobileFilters = !showMobileFilters">
                                <Icon icon="prime:filter" class="mr-2" />
                                Filters
                            </button>
                        </div>

                        <!-- Desktop Filters -->
                        <div class="hidden lg:flex flex-wrap items-center gap-4">
                            <div class="flex items-center space-x-2">
                                <label class="text-sm font-medium text-gray-700">Unit:</label>
                                <select v-model="filteredUnit" @change="applyFilters"
                                    class="min-w-[160px] py-2 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 bg-white">
                                    <option value="">Semua Unit</option>
                                    <option v-for="(item, index) in units" :key="index" :value="item">
                                        {{ item }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Mobile Filters -->
                        <div v-if="showMobileFilters" class="lg:hidden mt-4 p-4 bg-gray-50 rounded-lg space-y-4">
                            <!-- Unit Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                                <select v-model="filteredUnit"
                                    class="w-full py-2 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-400">
                                    <option value="">Semua Unit</option>
                                    <option v-for="(item, index) in units" :key="index" :value="item">
                                        {{ item }}
                                    </option>
                                </select>
                            </div>

                            <!-- Apply Button -->
                            <button @click="applyFilters"
                                class="w-full py-2 px-4 bg-primary-400 text-white rounded-md hover:bg-primary-500 text-sm font-medium">
                                Apply Filters
                            </button>
                        </div>
                    </div>

                    <!-- Table Container -->
                    <div class="overflow-x-auto">
                        <div class="px-4 sm:px-6 pb-6">
                            <div>
                                <EasyDataTable
                                    ref="dataTable"
                                    v-model:server-options="serverOptions"
                                    :server-items-length="serverItemsLength"
                                    :buttons-pagination="!isMobileView"
                                    :hide-footer="isMobileView"
                                    :headers="headers" :rows-items="[10, 25, 50, 100]"
                                    :items="data.questions"
                                    show-index
                                    alternating
                                    must-sort
                                    :loading="loading"
                                    :search-value="searchValue"
                                    class="min-w-full"
                                >

                                    <template #item-questionNumber="item">
                                        <p
                                            class="hover:text-primary-200 text-xs hover:font-bold font-semibold flex items-center">
                                            {{ item.questionNumber }}
                                        </p>
                                    </template>

                                    <template #item-category.service.name="item">
                                        <p
                                            v-if="category?.service.name"
                                            class="text-xs">
                                            {{ item.category.service.name}}
                                        </p>
                                        <p
                                            v-else
                                            class="text-xs">
                                            -
                                        </p>
                                    </template>

                                    <template #expand="item">
                                        <div
                                            class="mx-4 my-2">
                                            <!-- Question Section -->
                                            <div class="px-3 py-2">
                                                <div>
                                                    <h3 class="text-sm font-semibold text-primary-500 mb-2">Pertanyaan
                                                    </h3>
                                                    <div class="ckeditor-readonly-question">
                                                        <CKEditor :editor="editor"
                                                            :model-value="item.question"
                                                            :config="readOnlyConfig"
                                                            :disabled="true">
                                                        </CKEditor>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Answer Section -->
                                            <div class="px-3 py-2">
                                                <div>
                                                    <h3 class="text-sm font-semibold text-primary-500 mb-2">Jawaban</h3>
                                                    <div class="ckeditor-readonly-answer">
                                                        <CKEditor :editor="editor" :model-value="item.answer"
                                                            :config="readOnlyConfig" :disabled="true">
                                                        </CKEditor>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    <template #item-date="item">
                                        <span class="font-regular">
                                            {{ item.date === null ? $dateFormatIndo(item.created_at) :
                                                $dateFormatIndo(item.date) }}
                                        </span>
                                    </template>

                                    <template #item-action="item">
                                        <div class="whitespace-nowrap text-sm font-medium text-primary-300">
                                            <ButtonAction v-if="item" :item="item" edit-route="question.edit"
                                                delete-route="question.destroy" :form="form" />
                                        </div>
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
                                            {{ currentPageFirstIndex }}-{{ currentPageLastIndex }} of {{
                                                serverItemsLength
                                            }}
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
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style scoped>
/* Existing styles... */
.filter-column {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.filter-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 9999;
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    min-width: 200px;
    margin-top: 4px;
}

.filter-selector {
    border: none;
    outline: none;
    box-shadow: none;
    padding: 8px 12px;
    border-radius: 4px;
}

.filter-selector:focus {
    border: none;
    outline: none;
    box-shadow: none;
}

.filter-icon {
    cursor: pointer;
    font-size: 14px;
    color: #6b7280;
    transition: color 0.2s;
}

.filter-icon:hover {
    color: #6366f1;
}


/* CKEditor read-only styles */
.ckeditor-readonly-question :deep(.ck-editor),
.ckeditor-readonly-answer :deep(.ck-editor) {
    border: none !important;
    box-shadow: none !important;
}

.ckeditor-readonly-question :deep(.ck-editor__main),
.ckeditor-readonly-answer :deep(.ck-editor__main) {
    padding: 0 !important;
}

.ckeditor-readonly-question :deep(.ck-editor__editable),
.ckeditor-readonly-answer :deep(.ck-editor__editable) {
    border: none !important;
    box-shadow: none !important;
    padding: 0 !important;
    background: transparent !important;
    font-size: 14px !important;
    line-height: 1.25 !important;
}

.ckeditor-readonly-question :deep(.ck-editor__editable.ck-read-only),
.ckeditor-readonly-answer :deep(.ck-editor__editable.ck-read-only) {
    background: transparent !important;
    color: inherit !important;
}

/* Hide toolbar completely for read-only */
.ckeditor-readonly-question :deep(.ck-toolbar),
.ckeditor-readonly-answer :deep(.ck-toolbar) {
    display: none !important;
}

/* Styling untuk semua elemen text di dalam CKEditor agar konsisten dengan text-sm */
.ckeditor-readonly-question :deep(.ck-editor__editable) p,
.ckeditor-readonly-question :deep(.ck-editor__editable) div,
.ckeditor-readonly-question :deep(.ck-editor__editable) span,
.ckeditor-readonly-question :deep(.ck-editor__editable) li,
.ckeditor-readonly-question :deep(.ck-editor__editable) h1,
.ckeditor-readonly-question :deep(.ck-editor__editable) h2,
.ckeditor-readonly-question :deep(.ck-editor__editable) h3,
.ckeditor-readonly-question :deep(.ck-editor__editable) h4,
.ckeditor-readonly-question :deep(.ck-editor__editable) h5,
.ckeditor-readonly-question :deep(.ck-editor__editable) h6,
.ckeditor-readonly-answer :deep(.ck-editor__editable) p,
.ckeditor-readonly-answer :deep(.ck-editor__editable) div,
.ckeditor-readonly-answer :deep(.ck-editor__editable) span,
.ckeditor-readonly-answer :deep(.ck-editor__editable) li,
.ckeditor-readonly-answer :deep(.ck-editor__editable) h1,
.ckeditor-readonly-answer :deep(.ck-editor__editable) h2,
.ckeditor-readonly-answer :deep(.ck-editor__editable) h3,
.ckeditor-readonly-answer :deep(.ck-editor__editable) h4,
.ckeditor-readonly-answer :deep(.ck-editor__editable) h5,
.ckeditor-readonly-answer :deep(.ck-editor__editable) h6 {
    font-size: 14px !important;
    line-height: 1.25 !important;
    margin: 0.5rem 0 !important;
}

/* Khusus untuk heading agar tetap proporsional tapi tidak terlalu besar */
.ckeditor-readonly-question :deep(.ck-editor__editable) h1,
.ckeditor-readonly-answer :deep(.ck-editor__editable) h1 {
    font-size: 16px !important;
    font-weight: 600 !important;
}

.ckeditor-readonly-question :deep(.ck-editor__editable) h2,
.ckeditor-readonly-answer :deep(.ck-editor__editable) h2 {
    font-size: 15px !important;
    font-weight: 600 !important;
}

.ckeditor-readonly-question :deep(.ck-editor__editable) h3,
.ckeditor-readonly-question :deep(.ck-editor__editable) h4,
.ckeditor-readonly-question :deep(.ck-editor__editable) h5,
.ckeditor-readonly-question :deep(.ck-editor__editable) h6,
.ckeditor-readonly-answer :deep(.ck-editor__editable) h3,
.ckeditor-readonly-answer :deep(.ck-editor__editable) h4,
.ckeditor-readonly-answer :deep(.ck-editor__editable) h5,
.ckeditor-readonly-answer :deep(.ck-editor__editable) h6 {
    font-size: 14px !important;
    font-weight: 600 !important;
}

/* List styling */
.ckeditor-readonly-question :deep(.ck-editor__editable) ul,
.ckeditor-readonly-question :deep(.ck-editor__editable) ol,
.ckeditor-readonly-answer :deep(.ck-editor__editable) ul,
.ckeditor-readonly-answer :deep(.ck-editor__editable) ol {
    margin: 0.5rem 0 !important;
    padding-left: 1.5rem !important;
}

.ckeditor-readonly-question :deep(.ck-editor__editable) li,
.ckeditor-readonly-answer :deep(.ck-editor__editable) li {
    margin: 0.25rem 0 !important;
}

/* Remove excessive margin dari paragraph terakhir */
.ckeditor-readonly-question :deep(.ck-editor__editable) p:last-child,
.ckeditor-readonly-answer :deep(.ck-editor__editable) p:last-child {
    margin-bottom: 0 !important;
}

/* Remove excessive margin dari paragraph pertama */
.ckeditor-readonly-question :deep(.ck-editor__editable) p:first-child,
.ckeditor-readonly-answer :deep(.ck-editor__editable) p:first-child {
    margin-top: 0 !important;
}

/* Mobile styles remain the same... */
.mobile-select {
    min-width: 70px;
    font-weight: 500;
}

.mobile-nav-btn {
    min-width: 36px;
    min-height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.mobile-nav-btn:focus,
.mobile-page-btn:focus {
    outline: none;
}

.mobile-nav-btn:hover:not(:disabled) {
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    transform: translateY(-1px);
}

.mobile-page-btn {
    min-width: 40px;
    min-height: 36px;
    font-weight: 500;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
}

.mobile-page-btn:hover {
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    transform: translateY(-1px);
}

.page-numbers-section {
    max-width: 100%;
    overflow-x: auto;
    padding: 0 4px;
}

.page-numbers-section::-webkit-scrollbar {
    height: 4px;
}

.page-numbers-section::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 2px;
}

.page-numbers-section::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 2px;
}

.page-numbers-section::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Responsive adjustments */
@media (max-width: 480px) {
    .mobile-footer {
        padding: 16px 12px;
    }

    .mobile-rows-section {
        margin-bottom: 16px;
    }

    .mobile-navigation-section .flex {
        padding: 0 4px;
    }

    .mobile-nav-btn,
    .mobile-page-btn {
        min-width: 32px;
        min-height: 32px;
        font-size: 12px;
    }

    .page-numbers-section {
        margin-bottom: 12px;
    }
}

@media (max-width: 360px) {
    .mobile-footer {
        padding: 12px 8px;
    }

    .mobile-nav-btn,
    .mobile-page-btn {
        min-width: 28px;
        min-height: 28px;
        padding: 4px;
    }

    .flex.space-x-1 {
        gap: 2px;
    }
}

.mobile-nav-btn,
.mobile-page-btn {
    transition: all 0.2s ease-in-out;
}

.mobile-nav-btn:disabled {
    background-color: #f8fafc;
    color: #cbd5e1;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.mobile-nav-btn:disabled:hover {
    transform: none;
    box-shadow: none;
}
</style>
