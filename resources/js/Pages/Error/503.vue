<script setup>
  import { Head, Link } from '@inertiajs/vue3';
  import ErrorLayout from '@/Layouts/ErrorLayout.vue';
</script>

<template>
   <Head title="401" />
   <ErrorLayout :code-status="`503`" :message-code="`Service Unavailable`" :lord-icon="`sbiheqdr`">
    <p class="mt-3 text-gray-600">Maaf, layanan tidak tersedia untuk saat ini</p>
   </ErrorLayout>
</template>