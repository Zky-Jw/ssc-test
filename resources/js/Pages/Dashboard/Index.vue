<script setup>
import { ref, toRefs, computed, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, usePage } from '@inertiajs/vue3';
import axios from 'axios';

import linechart from 'vue3-apexcharts';
import piechart from 'vue3-apexcharts';
import barchart from 'vue3-apexcharts';
import MonthDropdown from '@/Components/MonthDropdown.vue';
import LoadingSpinner from '@/Components/LoadingSpinner.vue';

const pageTitle = ref('Dashboard');

const props = defineProps({
    ticketSummary: Object,
    statistikPerBulan: Array,
    layananTerbanyak: Array,
    unitTerbanyak: Array,
    totalQuestion : Number
})

const page = usePage()
const { profile } = page.props

const { ticketSummary, statistikPerBulan, totalQuestion } = toRefs(props)

// Reactive data untuk unit statistics
const unitTerbanyak = ref(props.unitTerbanyak || []);
const selectedMonth = ref(new Date().getMonth() + 1);
const isLoadingUnit = ref(false);
const isInitialLoad = ref(true);

// Reactive data untuk layanan terbanyak - PERBAIKAN
const layananTerbanyak = ref(props.layananTerbanyak || []);
const selectedMonthLayanan = ref(new Date().getMonth() + 1);
const isLoadingLayanan = ref(false);
const isInitialLoadLayanan = ref(true);

const lineseries = ref([{
    name: "Data",
    data: statistikPerBulan.value,
}]);

const lineChartOptions = ref({
    chart: {
        height: 'auto',
        width: '100%',
        type: 'line',
        zoom: {
            enabled: false
        }
    },
    colors: ['#834A56'],
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        curve: 'straight',
        colors: '#834A56',
    },
    title: {
        text: 'Statistik Tahun 2025',
        align: 'left',
        style: {
            fontSize: '21px',
            fontWeight: 'bold',
        },
    },
    xaxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
    },
});

// Computed series dan labels
const pieseries = computed(() => {
    return layananTerbanyak.value.map(item => item.total)
})

// Computed untuk total layanan (untuk perhitungan persentase)
const totalLayanan = computed(() => {
    return layananTerbanyak.value.reduce((sum, item) => sum + item.total, 0)
})

const barSeries = computed(() => {
    return unitTerbanyak.value.map(item => item.total)
})

const chartLabels = computed(() => {
    return layananTerbanyak.value.map(item => item.service_name)
})

const barLabel = computed(() => {
    return unitTerbanyak.value.map(item => item.unit_name)
})

const pieChartOptions = computed(() => ({
    chart: {
        type: 'pie',
        fontFamily: 'Inter, Arial, sans-serif',
        toolbar: {
            show: false
        },
        background: 'transparent',
        width: '100%',
        height: 380
    },
    labels: chartLabels.value,
    colors: ['#BB6A6A', '#834A56', '#AF7E7E', '#A67B7B', '#D9D9D9'],
    legend: {
        show: false
    },
    dataLabels: {
        enabled: true,
        style: {
            fontSize: '13px',
            fontWeight: 'bold',
            colors: ['#fff']
        },
        formatter: function (val, opts) {
            const name = opts.w.globals.labels[opts.seriesIndex];
            const value = opts.w.globals.series[opts.seriesIndex];
            // Tampilkan persentase dan nilai
            return `${val.toFixed(1)}%`;
        }
    },
    tooltip: {
        y: {
            formatter: function (val) {
                const total = totalLayanan.value;
                const percentage = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                return val + " tiket (" + percentage + "%)";
            }
        }
    },
    plotOptions: {
        pie: {
            donut: {
                size: '0%'
            },
            expandOnClick: false,
            customScale: 0.9,
            dataLabels: {
                offset: -5,
                minAngleToShowLabel: 10
            }
        }
    },
    responsive: [{
        breakpoint: 768,
        options: {
            chart: {
                height: 320  // PERBAIKAN: Height mobile yang lebih baik
            },
            plotOptions: {
                pie: {
                    customScale: 0.85,
                    dataLabels: {
                        style: {
                            fontSize: '11px'
                        }
                    }
                }
            }
        }
    }]
}));

const barseries = computed(() => [{
    data: barSeries.value
}]);

const goToOverdueTickets = (status) => {
    router.visit(`/dashboard/ticket?overdue=true&status=${status}`, {
        method: 'get',
        preserveState: false,
        preserveScroll: false,
        replace: false
    });
}

const barChartOptions = computed(() => ({
    chart: {
        height: Math.max(500, unitTerbanyak.value.length * 40),
        width: '100%',
        type: 'bar',
        zoom: {
            enabled: false
        }
    },
    colors: ['#834A56'],
    dataLabels: {
        enabled: false
    },
    plotOptions: {
        bar: {
            horizontal: true,
            columnWidth: '70%',
            barHeight: '70%',
        }
    },
    xaxis: {
        categories: barLabel.value,
    },
    yaxis: {
        labels: {
            style: {
                colors: ['#834A56', '#834A56', '#834A56', '#834A56', '#834A56', '#834A56', '#834A56', '#834A56'],
                fontSize: '14px',
            },
        },
        offsetX: 0,
        offsetY: 0,
    },
    tooltip: {
        enabled: true,
        y: {
            formatter: (val) => val,
            title: {
                formatter: () => ''
            }
        }
    }
}));

// Function untuk fetch data unit berdasarkan bulan
const fetchUnitStatistics = async (bulan) => {
    try {
        isLoadingUnit.value = true;
        const response = await axios.get(route('get-statistik-tiket-by-unit'), {
            params: {
                bulan,
                person_id: profile.id,
                email: profile.email,
                role_id: profile.role_id,
                unit_id: profile.unit_id
            }
        });

        unitTerbanyak.value = response.data;
    } catch (error) {
        console.error('Error fetching unit statistics:', error);
        throw error
    } finally {
        isLoadingUnit.value = false;
        isInitialLoad.value = false;
    }
};

// PERBAIKAN: Fungsi fetch layanan yang hilang
const fetchLayananStatistics = async (bulan) => {
    try {
        isLoadingLayanan.value = true;
        const response = await axios.get(route('get-layanan-terbanyak'), {
            params: {
                bulan,
                person_id: profile.id,
                email: profile.email,
                role_id: profile.role_id,
                unit_id: profile.unit_id
            }
        });

        layananTerbanyak.value = response.data;
    } catch (error) {
        console.error('Error fetching layanan statistics:', error);
        throw error
    } finally {
        isLoadingLayanan.value = false;
        isInitialLoadLayanan.value = false;
    }
};

// Function untuk handle perubahan bulan dari MonthDropdown
const handleMonthChange = (bulan) => {
    selectedMonth.value = bulan;
    fetchUnitStatistics(bulan);
};

// PERBAIKAN: Handler layanan yang hilang
const handleMonthChangeLayanan = (bulan) => {
    selectedMonthLayanan.value = bulan;
    fetchLayananStatistics(bulan);
};

onMounted(() => {
    fetchUnitStatistics(selectedMonth.value);
    fetchLayananStatistics(selectedMonthLayanan.value);
});
</script>

<template>
    <AuthenticatedLayout :page-title="pageTitle">
        <div class="mb-12">
            <div
            class="grid grid-cols-1 md:gap-4 lg:gap-6 xl:gap-10"
            :class="profile.role_id === '106' || profile.role_id === '102' ? 'md:grid-cols-4' : 'md:grid-cols-3'"
            >
                <div class="px-7 py-5 mb-5 lg:mb-0 bg-white rounded-2xl shadow-lg">
                    <div class="mb-10">
                        <Icon icon="tabler:message-star" class="text-primary-400 text-5xl" />
                        <h2 class="font-bold text-primary-400 text-4xl lg:text-6xl mt-3 mb-5">{{
                            ticketSummary.totalTickets }}</h2>
                        <p class="font-bold mt-3 font-quicksand text-xl">Total Tiket</p>
                    </div>
                </div>
                <div class="px-7 py-5 mb-5 lg:mb-0 bg-white rounded-2xl shadow-lg" v-if="profile.role_id === '106' || profile.role_id === '102'">
                    <div class="mb-10">
                        <Icon icon="akar-icons:question" class="text-primary-400 text-5xl" />
                        <h2 class="font-bold text-primary-400 text-4xl lg:text-6xl mt-3 mb-5">{{totalQuestion }}</h2>
                        <p class="font-bold mt-3 font-quicksand text-xl">Total Question</p>
                    </div>
                </div>
                <div class="px-7 py-5 mb-5 lg:mb-0 bg-white rounded-2xl shadow-lg">
                    <div class="mb-10">
                        <Icon icon="tabler:message-2-up" class="text-orange-400 text-5xl" />
                        <h2 class="font-bold text-primary-400 text-4xl lg:text-6xl mt-3 mb-5">{{
                            ticketSummary.ticketsOnProgress }}</h2>
                        <p class="font-bold mt-3 font-quicksand text-xl">Tiket Open</p>
                        <p class="text-[1rem] font-medium mt-2 cursor-pointer">
                            Melebihi SLA:
                            <span @click="goToOverdueTickets('on progress')"
                                class="text-sky-500 hover:text-sky-600 transition-colors font-semibold inline-flex items-center gap-1 border-b border-current">
                                {{ ticketSummary.progressOverdue }} Ticket
                                <Icon icon="mingcute:arrow-right-line" class="text-lg font-bold" />
                            </span>
                        </p>
                    </div>
                </div>
                <div class="px-7 py-5 mb-5 lg:mb-0 bg-white rounded-2xl shadow-lg">
                    <div class="mb-10">
                        <Icon icon="tabler:message-check" class="text-green-400 text-5xl" />
                        <h2 class="font-bold text-primary-400 text-4xl lg:text-6xl mt-3 mb-5">{{
                            ticketSummary.ticketsClosed }}</h2>
                        <p class="font-bold mt-3 font-quicksand text-xl">Tiket Closed</p>
                        <p class="text-[1rem] font-medium mt-2 cursor-pointer">
                            Melebihi SLA:
                            <span @click="goToOverdueTickets('closed')"
                                class="text-sky-500 hover:text-sky-600 transition-colors font-semibold inline-flex items-center gap-1 border-b border-current">
                                {{ ticketSummary.closedOverdue }} Ticket
                                <Icon icon="mingcute:arrow-right-line" class="text-lg font-bold" />
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 md:gap-4 lg:gap-6 xl:gap-10">
                <div class="col-span-3 md:col-span-2 px-7 py-5 mb-5 lg:mb-0 bg-white rounded-2xl shadow-lg">
                    <div>
                        <linechart :options="lineChartOptions" :series="lineseries" />
                    </div>
                </div>

                <div class="px-5 py-5 mb-5 lg:mb-0 bg-white rounded-2xl shadow-lg">
                    <section class="grid grid-cols-2 items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">5 Layanan Terbanyak</h3>
                        <div class="justify-self-end">
                            <MonthDropdown
                                @month-changed="handleMonthChangeLayanan"
                                :selected-month="selectedMonthLayanan"
                            />
                        </div>
                    </section>

                    <div v-if="isLoadingLayanan || isInitialLoadLayanan" class="flex justify-center items-center h-80">
                        <LoadingSpinner />
                    </div>

                    <div v-else-if="layananTerbanyak.length > 0" class="pie-chart-container">
                        <div class="chart-wrapper">
                            <piechart :options="pieChartOptions" :series="pieseries" height="320" />
                        </div>
                        <div class="custom-legend mt-3">
                            <div v-for="(label, index) in chartLabels" :key="index" class="legend-item">
                                <div class="legend-color"
                                    :style="{ backgroundColor: ['#BB6A6A', '#834A56', '#AF7E7E', '#A67B7B', '#D9D9D9'][index] }">
                                </div>
                                <span class="legend-text">{{ label }}</span>
                                <span class="legend-value">({{ pieseries[index] }} tiket)</span>
                            </div>
                        </div>
                    </div>

                    <div v-else class="flex justify-center items-center h-80 text-gray-500">
                        Tidak ada data layanan
                    </div>

                </div>
            </div>
        </div>

        <div class="mb-12">
            <div class="w-full bg-white px-7 py-5 rounded-lg shadow-lg">
                <div class="mb-7">
                    <h3 class="block md:inline mb-5 md:mb-0 mr-0 md:mr-10">Statistik Unit per Bulan</h3>
                    <MonthDropdown @month-changed="handleMonthChange" :selected-month="selectedMonth" />
                </div>

                <!-- Loading indicator -->
                <div v-if="isLoadingUnit && !isInitialLoad" class="flex justify-center items-center h-64">
                    <LoadingSpinner />
                </div>

                <!-- Chart -->
                <div v-else>
                    <barchart :options="barChartOptions" :series="barseries" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.pie-chart-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.chart-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    margin-bottom: 0.75rem;
}

.custom-legend {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 100%;
    max-width: 320px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 4px 0;
}

.legend-color {
    width: 13px;
    height: 13px;
    border-radius: 50%;
    flex-shrink: 0;
}

.legend-text {
    font-size: 13px;
    line-height: 1.4;
    color: #333;
    font-weight: 500;
    word-wrap: break-word;
    flex: 1;
}

.legend-value {
    font-size: 12px;
    color: #666;
    font-weight: 400;
    margin-left: auto;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .custom-legend {
        max-width: 100%;
    }

    .legend-text {
        font-size: 12px;
    }

    .legend-value {
        font-size: 11px;
    }

    .legend-color {
        width: 12px;
        height: 12px;
    }
}

@media (max-width: 768px) {
    .legend-item {
        gap: 8px;
    }

    .legend-text {
        font-size: 11px;
    }

    .legend-value {
        font-size: 10px;
    }
}
</style>
