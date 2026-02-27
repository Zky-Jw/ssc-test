<script setup>

  import MonthDropdown from './MonthDropdown.vue';
  defineProps({
    title: {
      type: String,
      default: 'Title',
    },
    hasDropdownMonth: {
      type: Boolean,
      default: false,
    },
    parentClass: {
      type: String,
      default: '',
    },
  });
</script>

<template>
  <div class="">
    <div class="">
      <h2 class="inline-flex align-middle font-bold text-primary-400 text-2xl lg:text-3xl"> {{ title }}</h2>
      <slot />
    </div>

    <MonthDropdown v-if="hasDropdownMonth" />
  </div>
</template>
