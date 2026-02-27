<script setup>
  defineProps({
    class: {
      type: String,
      default: 'mb-4',
    },
    title: {
      type: String,
      required: true,
    },
  });
</script>

<template>
  <div :class="class">
    <h2 class="font-bold text-primary-400" v-text="title"></h2>
  </div>
</template>