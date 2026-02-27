<script setup>
  import { Head, Link } from '@inertiajs/vue3';
  import ErrorLayout from '@/Layouts/ErrorLayout.vue';
</script>

<template>
   <Head title="401" />
   <ErrorLayout :code-status="`416`" :message-code="`Range Not Satisfiable`" :lord-icon="`jzjtyyqx`">
    <p class="mt-3 text-gray-600">Pastikan URL anda sudah benar!</p>
   </ErrorLayout>
</template>