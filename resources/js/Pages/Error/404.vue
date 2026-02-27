<script setup>
  import { Head, Link } from '@inertiajs/vue3';
  import ErrorLayout from '@/Layouts/ErrorLayout.vue';
  
</script>


<template>
  <Head title="404" />
  <ErrorLayout :code-status="`404`" :message-code="`Page Not Found`" :lord-icon="`nocovwne`">
    <p class="mt-3 text-gray-600">Halaman yang anda cari saat ini tidak ditemukan</p>
    <div class="mt-5 flex flex-col justify-center items-center gap-2 sm:flex-row sm:gap-3">
      <Link href="/" class="w-full sm:w-auto inline-flex justify-center items-center gap-x-3 text-center bg-primary-300 hover:bg-primary-400 border border-transparent text-white text-sm font-medium rounded-md py-3 px-4" >
        <Icon icon="formkit:arrowleft" /> Back to Home
      </Link>
    </div>
  </ErrorLayout>
</template>