<script setup>
  defineProps({
    codeStatus: {
      type: String,
      default: ""
    },
    messageCode: {
      type: String,
      default: ""
    },
    lordIcon: {
      type: String,
      default: ""
    }
  })

</script>

<template>
  <div class="h-screen flex items-center justify-center">
    <div class="text-center py-10 px-4 sm:px-6 lg:px-8">
      <lord-icon
        :src="`https://cdn.lordicon.com/${lordIcon}.json`"
        trigger="hover"
        colors="primary:#6d263c,secondary:#6d263c"
        style="width:150px;height:150px;obj">
      </lord-icon>
      <h1 class="block font-quicksand text-7xl font-bold text-gray-800 sm:text-9xl">{{ codeStatus }}</h1>
      <h2 class="block font-quicksand text-2xl font-semibold text-gray-800 sm:text-4xl">{{ messageCode }}</h2>
      <div class="mt-7">
        <slot></slot>
      </div>

    </div>
  </div>
 
</template>