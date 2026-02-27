<script setup>
  import { Head, Link } from '@inertiajs/vue3';
  import ErrorLayout from '@/Layouts/ErrorLayout.vue';
</script>

<template>
   <Head title="401" />
   <ErrorLayout :code-status="`401`" :message-code="`Unauthorized`" :lord-icon="`gqzfzudq`">
    <p class="mt-3 text-gray-600">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini </p>
   </ErrorLayout>
</template>