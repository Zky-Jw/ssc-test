<script setup>
  import { Head, Link } from '@inertiajs/vue3';
  import ErrorLayout from '@/Layouts/ErrorLayout.vue';
</script>

<template>
   <Head title="500" />
   <ErrorLayout :code-status="`500`" :message-code="`UNABLE TO LOAD`" :lord-icon="`sbiheqdr`">
    <p class="mt-3 text-gray-600">Maaf, layanan tidak tersedia untuk saat ini</p>
    <Link href="/" class="w-full sm:w-auto inline-flex justify-center items-center gap-x-3 text-center bg-primary-300 hover:bg-primary-400 border border-transparent text-white text-sm font-medium rounded-md py-3 px-4" >
      <Icon icon="formkit:arrowleft" /> Back to Home
    </Link>
   </ErrorLayout>
</template>