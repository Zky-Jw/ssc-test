<!-- components/FlashModal.vue -->
<template>
    <Teleport to="body">
      <Transition name="fade">
        <div v-if="visible" class="fixed inset-0 flex items-center justify-center z-[999] bg-black bg-opacity-50">
          <div class="bg-white rounded-xl shadow-xl p-6 max-w-md w-full text-center">
            <h2 class="text-xl font-semibold text-red-600 mb-4">Error</h2>
            <p class="text-gray-700">{{ message }}</p>
            <button @click="close" class="mt-6 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
              Tutup
            </button>
          </div>
        </div>
      </Transition>
    </Teleport>
  </template>

  <script setup>
  import { ref, watch } from 'vue'
  import { usePage } from '@inertiajs/vue3'

  const page = usePage()
  const visible = ref(false)
  const message = ref('')

  watch(
    () => page.props.flash?.error,
    (newVal) => {
      if (newVal) {
        message.value = newVal
        visible.value = true
      }
    },
    { immediate: true }
  )

  const close = () => {
    visible.value = false
  }
  </script>

  <style scoped>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s ease;
  }
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  </style>
