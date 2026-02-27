<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  buttonText: {
    type: String,
    default: 'Create',
  },
  createRoute: {
    type: String,
    default: '',
  }
})
</script>

<template>
  <Link className="px-6 py-2 text-white text-sm bg-primary-400 hover:bg-primary-300 rounded-md focus:outline-none inline-flex items-center" :href="route(createRoute)">
    <Icon class="text-xl pr-2" icon="uiw:plus" />
    {{ buttonText }}
  </Link>
</template>
