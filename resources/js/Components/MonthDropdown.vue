<script setup>
import { reactive, ref, watch } from 'vue';

const props = defineProps({
  selectedMonth: {
    type: Number,
    default: () => new Date().getMonth() + 1
  }
});

const emit = defineEmits(['month-changed']);

const month = reactive([
  'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
  'Juli', 'Agustus','September', 'Oktober', 'November', 'Desember'
]);

// Convert month number to month name untuk display
const selectedMonthName = ref(month[props.selectedMonth - 1]);

// Handle perubahan bulan
const handleMonthChange = (event) => {
  const selectedName = event.target.value;
  const monthIndex = month.findIndex(m => m === selectedName);
  const monthNumber = monthIndex + 1;

  selectedMonthName.value = selectedName;
  emit('month-changed', monthNumber);
};

// Watch props changes
watch(() => props.selectedMonth, (newMonth) => {
  selectedMonthName.value = month[newMonth - 1];
});
</script>

<template>
  <div class="ml-auto hs-dropdown relative inline-flex">
    <select
      v-model="selectedMonthName"
      @change="handleMonthChange"
      class="py-3 px-4 pr-9 block w-full border-gray-200 text-primary-400 font-bold rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-transparent"
    >
      <option
        v-for="(item, index) in month"
        :key="item"
        :value="item"
        class="text-primary-400 font-normal"
      >
        {{ item }}
      </option>
    </select>
  </div>
</template>
