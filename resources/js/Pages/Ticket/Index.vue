<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed, toRefs, watch, onMounted } from 'vue';
import { router } from '@inertiajs/vue3'
import ButtonCreate from '@/Components/ButtonCreate.vue';
import ButtonAction from '@/Components/ButtonAction.vue';
import { usePage } from '@inertiajs/vue3';
import { Icon } from '@iconify/vue';
import { formatDueDate } from '@/Utils/date';
import { debounce } from 'lodash';
import { usePagination, useRowsPerPage } from "use-vue3-easy-data-table";

const props = defineProps({
    ticket: Object,
    recipient: Array,
    units: Array
});

const { ticket, recipient, units } = toRefs(props)
const page = usePage()
const { profile } = page.props
const pageTitle = ref('Ticket');

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

const encodeText = (text) => {
    return text.replace(/[\u00A0-\u9999<>\&]/gim, function (i) {
        return '&#' + i.charCodeAt(0) + ';';
    });
};

const getInitialFilters = () => {
    const urlParams = new URLSearchParams(window.location.search);

    return {
        unit: urlParams.get('unit') || "",
        status: urlParams.get('status') || "on progress",
        petugas: urlParams.get('petugas') || null,
        overdue: urlParams.get('overdue') || '',
        search: urlParams.get('search') || "",
        page: parseInt(urlParams.get('page')) || 1,
        limit: parseInt(urlParams.get('limit')) || 10,
        sortBy: urlParams.get('sortBy') || "ticketNumber",
        sortType: urlParams.get('sortType') || 'desc'
    };
};

// Inisialisasi dengan parameter dari URL
const initialFilters = getInitialFilters();

const filteredUnit = ref(initialFilters.unit);
const filteredStatus = ref(initialFilters.status);
const filteredPetugas = ref(initialFilters.petugas);
const filteredPetugasInput = ref('');
const filteredPetugasList = ref([]);
const filteredOverdue = ref(initialFilters.overdue);
const searchValue = ref(initialFilters.search);

const loading = ref(false);
const serverItemsLength = ref(0);

const serverOptions = ref({
    page: initialFilters.page,
    rowsPerPage: initialFilters.limit,
    sortBy: initialFilters.sortBy,
    sortType: initialFilters.sortType,
});

const form = useForm({ id: '' });

const decodeText = (text) => {
    return text.replace(/&#(\d+);/g, function (match, dec) {
        return String.fromCharCode(dec);
    });
};

const notValid = 'invalid data';

const showUnitFilter = ref(false);
const showStatusFilter = ref(false);
const showPetugasFilter = ref(false);
const showMobileFilters = ref(false);
const showOverdueFilter = ref(false);

const data = ref(ticket.value.data.map((item) => ({
    ...item,
    created: item.created.createdat ?? '',
    due_date: item.due_date,
    creator: decodeText(item.person['creator']['name']) ?? notValid,
    service: item.purpose.service.name ?? notValid,
    unit: item.purpose.unit.name ?? notValid,
    person: item.person['recipient']['name'] ?? notValid,
    number: item.ticketNumber ?? notValid,
    status: item.status,
    id: item._id,
})));

const headers = ref([
    { text: "Nomor tiket", value: "ticketNumber", sortable: true, fixed: true, width: !isMobileView ? 150 : 120, visibleTo: ['101', '102', '103', '104', '105', '106'] },
    { text: "Pemilik", value: "creator", width: 200, visibleTo: ['101', '102', '103', '104', '105', '106'] },
    { text: "Status", value: "status", width: 120, visibleTo: ['101', '102', '103', '104', '105', '106'] },
    { text: "Tanggal pengajuan", value: "created", width: 200, visibleTo: ['101', '102', '103', '104', '105', '106'] },
    { text: "Unit", value: "unit", width :200, visibleTo: ['101', '102', '103', '104', '105', '106'] },
    { text: "Layanan", value: "service", width : 150, visibleTo: ['101', '102', '103', '104', '105', '106'] },
    { text: "Petugas", value: "person", width : 200, visibleTo: ['102', '103', '104', '105', '106'] },
    { text: "Tenggat Waktu", value: "dueDate", width: 200, visibleTo: ['101', '102', '103', '104', '105', '106'] },
    { text: "Tanggal Penyelesaian", value: "closedDate", width: 200, visibleTo: ['101', '102', '103', '104', '105', '106'] },
    { text: "Action", value: "id", visibleTo: ['102', '106'] },
]);

// Computed property untuk mendapatkan kolom yang terlihat
const getHeaders = computed(() => {
    return headers.value.filter(column => {
        // cek apakah role user boleh melihat kolom
        if (column.visibleTo && !column.visibleTo.includes(profile.role_id)) return false;

        if (column.value === "closedDate") return filteredStatus.value === "closed";

        return true;
    });
});

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

  if (total <= 7) {
    // Jika total halaman <= 7, tampilkan semua
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

  if (total > 1) pages.push(total);

  return pages;
};

watch(currentPaginationNumber, (newPage) => {
  jumpToPageValue.value = newPage;
});

const filterTickets = (filters, resetPage = true) => {
    loading.value = true
    const query = {};

    const canFilterUnit = ['102', '106'].includes(profile.role_id);
    const canFilterPetugas = ['102', '106'].includes(profile.role_id);
    const canFilterStatus = ['101', '102', '103', '104', '105', '106'].includes(profile.role_id);
    const canFilterOverdue = ['101', '102', '103', '104', '105', '106'].includes(profile.role_id);

    if (canFilterStatus && filters.status) {
        query.status = filters.status;
        showStatusFilter.value = false;
    }

    if (canFilterUnit && filters.unit) {
        query.unit = filters.unit;
        showUnitFilter.value = false;
    }

    if (canFilterPetugas && filters.petugas) {
        query.petugas = filters.petugas;
        showPetugasFilter.value = false;
    }

    if (canFilterOverdue && filters.overdue !== '') {
        query.overdue = filters.overdue;
        showOverdueFilter.value = false;
    }

    if (filters.search) {
        query.search = filters.search;
    }

    // Reset page ke 1 ketika ada filter baru (kecuali ketika pagination)
    if (resetPage) {
        serverOptions.value.page = 1;
    }

    query.limit = serverOptions.value.rowsPerPage;
    query.page = serverOptions.value.page;
    query.sortBy = serverOptions.value.sortBy;
    query.sortType = serverOptions.value.sortType;

    router.get('/dashboard/ticket', query, {
        only: ['ticket', 'recipient'],
        preserveScroll: true,
        preserveState: true,
        onSuccess: (page) => {
            loading.value = false;
            data.value = page.props.ticket.data.map((item) => ({
                ...item,
                created: item.created.createdat ?? '',
                dueDate: item.dueDate,
                creator: decodeText(item.person['creator']['name']) ?? notValid,
                service: item.purpose.service.name ?? notValid,
                unit: item.purpose.unit.name ?? notValid,
                person: item.person['recipient']['name'] ?? notValid,
                number: item.ticketNumber ?? notValid,
                isLate : item.isLate,
                status: item.status,
                id: item._id,
            }));

            serverItemsLength.value = page.props.ticket.total;
            filteredPetugasList.value = page.props.recipient;

            if (profile.role_id !== '101' && profile.role_id !== 101 && filters.unit && !filters.petugas) {
                filteredPetugas.value = null;
            }
        },
    });
};

const applyFilters = () => {
    filterTickets({
        unit: filteredUnit.value,
        status: filteredStatus.value,
        petugas: filteredPetugas.value,
        overdue: filteredOverdue.value
    }, true);
    filteredPetugasList.value = recipient.value
    showMobileFilters.value = false;
};

const onSearchPetugas = () => {
    const query = filteredPetugasInput.value.toLowerCase();
    filteredPetugasList.value = recipient.value.filter(item =>
        item.person.toLowerCase().includes(query)
    );
};

const handleExport = () => {
    const query = {};

    const canFilterUnit = ['102', '106', '105'].includes(profile.role_id);
    const canFilterPetugas = ['102', '106', '105'].includes(profile.role_id);
    const canFilterStatus = ['101', '102', '103', '104', '105', '106'].includes(profile.role_id);

    if (canFilterStatus && filteredStatus.value) {
        query.status = filteredStatus.value;
    }

    if (canFilterUnit && filteredUnit.value) {
        query.unit = filteredUnit.value;
    }

    if (canFilterPetugas && filteredPetugas.value) {
        query.petugas = filteredPetugas.value;
    }

    if (searchValue.value) {
        query.search = searchValue.value;
    }

    query.limit = serverOptions.value.rowsPerPage
    query.page = serverOptions.value.page
    query.sortBy = serverOptions.value.sortBy
    query.sortType = serverOptions.value.sortType

    const params = new URLSearchParams(query).toString();
    window.location.href = `/export/ticket?${params}`;
}

const selectPetugas = (item) => {
    filteredPetugas.value = item.person;
    filteredPetugasInput.value = ''
    showPetugasFilter.value = false;
    applyFilters();
};

watch(() => filteredUnit.value, (newUnit, oldUnit) => {
    if (newUnit !== oldUnit) {
        filteredPetugas.value = null;
        filterTickets({
            unit: newUnit,
            status: filteredStatus.value,
            petugas: null,
            overdue: filteredOverdue.value
        }, true);
    }
});

watch(() => serverOptions.value, (newValue, oldValue) => {
    const isOnlyPageChange = newValue.page !== oldValue.page &&
                           newValue.rowsPerPage === oldValue.rowsPerPage &&
                           newValue.sortBy === oldValue.sortBy &&
                           newValue.sortType === oldValue.sortType;

    filterTickets({
        unit: filteredUnit.value,
        status: filteredStatus.value,
        petugas: filteredPetugas.value,
        search: searchValue.value,
        overdue: filteredOverdue.value
    }, !isOnlyPageChange);
});

const handleSearch = debounce(() => {
    filterTickets({
        unit: filteredUnit.value,
        status: filteredStatus.value,
        petugas: filteredPetugas.value,
        search: searchValue.value,
        overdue: filteredOverdue.value
    }, true);
}, 500);

onMounted(() => {
    // Set initial server items length dari props
    serverItemsLength.value = ticket.value.total || 0;
    filteredPetugasList.value = recipient.value || [];

    // Jika tidak ada parameter URL yang spesifik, baru apply default filters
    const urlParams = new URLSearchParams(window.location.search);
    const hasSpecificFilters = urlParams.has('overdue') || urlParams.has('unit') || urlParams.has('petugas') || urlParams.has('search');

    if (!hasSpecificFilters) {
        applyFilters();
    }
});
</script>

<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout :page-title="pageTitle">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create or just look for the ticket
            </h2>
        </template>

        <div class="w-full mx-auto sm:px-6 lg:px-8 py-6">
            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <!-- Header Section -->
                <div class="bg-white border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 sm:p-6 gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-primary-400">Ticket List</h3>
                        </div>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                            <button
                                v-if="profile.role_id === '106' || profile.role_id === '102'"
                                class="px-4 py-2 text-white text-sm bg-primary-400 hover:bg-primary-300 rounded-md focus:outline-none inline-flex items-center justify-center"
                                @click="handleExport"
                            >
                                <Icon class="text-lg mr-2" icon="streamline:computer-printer-scan-device-electronics-printer-print-computer" />
                                Export Ticket
                            </button>

                            <ButtonCreate
                                button-text="Create Ticket"
                                create-route="ticket.create"
                                v-if="profile.role_id === '106' || profile.role_id === '102'"
                            />
                        </div>
                    </div>

                    <div class="px-4 sm:px-6 pb-4">
                        <!-- Search & Mobile Filter Toggle -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 mb-4">
                            <!-- Search -->
                            <div class="flex items-center w-full sm:w-auto">
                                <label class="text-sm font-medium text-gray-700 mr-3 hidden lg:block whitespace-nowrap">
                                    Pencarian
                                </label>
                                <input
                                    v-model="searchValue"
                                    type="text"
                                    placeholder="Search tickets..."
                                    @input="handleSearch"
                                    class="flex-1 sm:w-64 py-2 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"
                                />
                            </div>

                            <!-- Mobile Filter Button -->
                            <button
                            class="lg:hidden flex items-center px-3 py-2 text-sm border border-gray-300 rounded-md"
                            @click="showMobileFilters = !showMobileFilters"
                            >
                            <Icon icon="prime:filter" class="mr-2" />
                            Filters
                            </button>
                        </div>

                        <!-- Desktop Filters -->
                        <div class="hidden lg:flex flex-wrap items-center gap-4">
                            <!-- Status Filter -->
                            <div class="flex items-center space-x-2">
                            <label class="text-sm font-medium text-gray-700">Status:</label>
                            <select
                                v-model="filteredStatus"
                                @change="applyFilters"
                                class="min-w-[140px] py-2 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 bg-white"
                            >
                                <option value="on progress">On Progress</option>
                                <option value="closed">Closed</option>
                            </select>
                            </div>

                            <!-- Status SLA Filter -->
                            <div class="flex items-center space-x-2">
                            <label class="text-sm font-medium text-gray-700">Status SLA:</label>
                            <select
                                v-model="filteredOverdue"
                                @change="applyFilters"
                                class="min-w-[140px] py-2 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 bg-white"
                            >
                            <option value="" default>Semua Status</option>
                                <option :value="true">Overdue</option>
                                <option :value="false" v-if="filteredStatus === 'closed'">On Time</option>
                                <option :value="false" v-else>In Progress</option>
                            </select>
                            </div>

                            <!-- Unit Filter -->
                            <div class="flex items-center space-x-2" v-if="profile.role_id === '102' || profile.role_id === '106' || profile.role_id === '105'">
                            <label class="text-sm font-medium text-gray-700">Unit:</label>
                            <select
                                v-model="filteredUnit"
                                @change="applyFilters"
                                class="min-w-[160px] py-2 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 bg-white"
                            >
                                <option value="">Semua Unit</option>
                                <option v-for="(item, index) in units" :key="index" :value="item">
                                {{ item }}
                                </option>
                            </select>
                            </div>

                            <!-- Petugas Filter -->
                            <div class="relative flex items-center space-x-2" v-if="profile.role_id === '102' || profile.role_id === '106' || profile.role_id === '105'">
                            <label class="text-sm font-medium text-gray-700">Petugas:</label>
                            <button
                                @click="showPetugasFilter = !showPetugasFilter"
                                class="py-2 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 bg-white flex items-center"
                            >
                                {{ filteredPetugas || 'Semua Petugas' }}
                                <Icon icon="heroicons:chevron-down" class="ml-1" />
                            </button>

                            <!-- Dropdown Petugas -->
                            <div
                                v-if="showPetugasFilter"
                                class="absolute top-full left-0 mt-1 w-64 bg-white border border-gray-300 rounded-md shadow-lg z-50"
                            >
                                <input
                                type="text"
                                v-model="filteredPetugasInput"
                                @input="onSearchPetugas"
                                placeholder="Cari petugas..."
                                class="w-full px-3 py-2 border-b border-gray-200 text-sm focus:outline-none"
                                />
                                <ul class="max-h-40 overflow-y-auto">
                                <li
                                    @click="filteredPetugas = null; showPetugasFilter = false; applyFilters()"
                                    class="px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm border-b border-gray-100"
                                >
                                    Semua Petugas
                                </li>
                                <li
                                    v-for="(item, index) in filteredPetugasList"
                                    :key="index"
                                    @click="selectPetugas(item)"
                                    class="px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm border-b border-gray-100"
                                >
                                    {{ item.person }}
                                </li>
                                </ul>
                            </div>
                            </div>
                        </div>

                        <!-- Mobile Filters -->
                        <div v-if="showMobileFilters" class="lg:hidden mt-4 p-4 bg-gray-50 rounded-lg space-y-4">
                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select
                                    v-model="filteredStatus"
                                    class="w-full py-2 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"
                                >
                                    <option value="on progress">On Progress</option>
                                    <option value="closed">Closed</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status SLA:</label>
                                <select
                                    v-model="filteredOverdue"
                                    class="w-full py-2 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"
                                >
                                <option value="" default>Semua Status</option>
                                    <option :value="true">Overdue</option>
                                    <option :value="false" v-if="filteredStatus === 'closed'">On Time</option>
                                    <option :value="false" v-else>In Progress</option>
                                </select>
                            </div>

                            <!-- Unit Filter -->
                            <div v-if="profile.role_id === '102' || profile.role_id === '106'">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                            <select
                                v-model="filteredUnit"
                                class="w-full py-2 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-400"
                            >
                                <option value="">Semua Unit</option>
                                <option v-for="(item, index) in units" :key="index" :value="item">
                                {{ item }}
                                </option>
                            </select>
                            </div>

                            <!-- Petugas Filter -->
                            <div v-if="profile.role_id === '106'">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Petugas</label>
                            <input
                                type="text"
                                v-model="filteredPetugasInput"
                                @input="onSearchPetugas"
                                placeholder="Cari dan pilih petugas..."
                                class="w-full py-2 px-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 mb-2"
                            />
                            <div class="max-h-32 overflow-y-auto border border-gray-300 rounded-md">
                                <div
                                @click="filteredPetugas = null; applyFilters()"
                                class="px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm border-b border-gray-100"
                                :class="{ 'bg-primary-50': !filteredPetugas }"
                                >
                                Semua Petugas
                                </div>
                                <div
                                v-for="(item, index) in filteredPetugasList"
                                :key="index"
                                @click="selectPetugas(item)"
                                class="px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm border-b border-gray-100"
                                :class="{ 'bg-primary-50': filteredPetugas === item.person }"
                                >
                                {{ item.person }}
                                </div>
                            </div>
                            </div>

                            <!-- Apply Button -->
                            <button
                            @click="applyFilters"
                            class="w-full py-2 px-4 bg-primary-400 text-white rounded-md hover:bg-primary-500 text-sm font-medium"
                            >
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
                                    :headers="getHeaders"
                                    :rows-items="[10, 25, 50, 100]"
                                    :items="data"
                                    show-index
                                    alternating
                                    must-sort
                                    :loading="loading"
                                    :search-value="searchValue"
                                    class="min-w-full"
                                >
                                    <template #item-ticketNumber="item">
                                        <a :href="route('ticket.show', item.id)"
                                            class="hover:text-primary-200 hover:font-bold font-semibold flex items-center">
                                            {{ item.ticketNumber }}
                                            <Icon icon="pepicons-pop:open" class="text-md ml-1" />
                                        </a>
                                    </template>

                                    <template #item-id="item">
                                        <div class="whitespace-nowrap text-sm font-medium text-primary-300">
                                            <ButtonAction
                                                v-if="item.status !== 'closed'"
                                                :item="item"
                                                edit-route="ticket.edit"
                                                :form="form"
                                                document-route="document.generate"
                                                reminder-route="ticket.notifyOperator"
                                            />
                                        </div>
                                    </template>

                                    <template #item-status="item">
                                            <span class="font-semibold uppercase" :class="{
                                                'text-red-700': item.status.toUpperCase() === 'ON PROGRESS',
                                                'text-green-700': item.status.toUpperCase() === 'CLOSED'
                                            }">{{ item.status }}</span>
                                    </template>

                                    <template #item-created="item">
                                        <span class="font-regular">
                                            {{ item.created === '' ? notValid : formatDueDate(item.created) }}
                                        </span>
                                    </template>

                                    <template #item-person="item">
                                        <span class="font-regular">
                                            {{ ($makeTitle($makeShortName(item.person)) ?? $makeTitle('belum ada petugas')) ?? notValid }}
                                        </span>
                                    </template>

                                    <template #item-dueDate="item">
                                        <span class="font-regular" :class="item.isLate ? 'text-red-700 font-semibold' : ''">
                                            {{ formatDueDate(item.dueDate) }}
                                        </span>
                                    </template>

                                    <template #item-closedDate="item">
                                        <span class="font-regular" :class="item.isLate ? 'text-red-700 font-semibold' : ''">
                                            {{ formatDueDate(item.closedDate) }}
                                        </span>
                                    </template>
                                </EasyDataTable>

                                <!-- Custom Mobile Footer - tampil hanya di mobile -->
                                <div v-if="isMobileView" class="mobile-footer bg-white border-t border-gray-200 p-4 mt-4 rounded-b-lg">
                                    <!-- Rows per page selector -->
                                    <div class="mobile-rows-section mb-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <span class="text-sm text-gray-600 font-medium">row per page:</span>
                                            <select
                                                :value="rowsPerPageActiveOption"
                                                @change="updateRowsPerPageSelect"
                                                class="mobile-select px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-400 bg-white min-w-[60px]"
                                            >
                                                <option
                                                    v-for="item in rowsPerPageOptions"
                                                    :key="item"
                                                    :value="item"
                                                >
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
                                            <button
                                                @click="updatePage(1)"
                                                :disabled="isFirstPage"
                                                class="mobile-nav-btn p-2 rounded border border-gray-300 bg-white disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors"
                                                title="First page"
                                            >
                                                <Icon icon="heroicons:chevron-double-left" class="w-4 h-4" />
                                            </button>

                                            <!-- Previous page -->
                                            <button
                                                @click="prevPage"
                                                :disabled="isFirstPage"
                                                class="mobile-nav-btn p-2 rounded border border-gray-300 bg-white disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors"
                                                title="Previous page"
                                            >
                                                <Icon icon="heroicons:chevron-left" class="w-4 h-4" />
                                            </button>

                                            <!-- Next page -->
                                            <button
                                                @click="nextPage"
                                                :disabled="isLastPage"
                                                class="mobile-nav-btn p-2 rounded border border-gray-300 bg-white disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors"
                                                title="Next page"
                                            >
                                                <Icon icon="heroicons:chevron-right" class="w-4 h-4" />
                                            </button>

                                            <!-- Last page -->
                                            <button
                                                @click="updatePage(maxPaginationNumber)"
                                                :disabled="isLastPage"
                                                class="mobile-nav-btn p-2 rounded border border-gray-300 bg-white disabled:opacity-30 disabled:cursor-not-allowed hover:bg-gray-50 transition-colors"
                                                title="Last page"
                                            >
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
                                                    <button
                                                        v-else
                                                        @click="updatePage(page)"
                                                        class="mobile-page-btn px-3 py-2 text-sm border rounded transition-colors min-w-[40px]"
                                                        :class="{
                                                            'bg-green-500 text-white border-green-500 font-semibold': page === currentPaginationNumber,
                                                            'border-gray-300 hover:bg-gray-50 text-gray-700': page !== currentPaginationNumber
                                                        }"
                                                    >
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

button:focus,
select:focus,
input:focus {
    outline: 2px solid transparent;
    outline-offset: 2px;
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
}


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
