<script setup>
  import { Head, Link } from '@inertiajs/vue3';
  import ErrorLayout from '@/Layouts/ErrorLayout.vue';
</script>

<template>
   <Head title="401" />
   <ErrorLayout :code-status="`403`" :message-code="`Forbidden`" :lord-icon="`wcjauznf`">
    <p class="mt-3 text-gray-600">Anda tidak diizinkan untuk mengakses halaman ini</p>
   </ErrorLayout>
</template>