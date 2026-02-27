<script setup>
import Navbar from '@/Components/new/Navbar.vue'

const arrPhoto = [
  '../../images/login-1.png',
  '../../images/login-2.png',
  '../../images/login-3.png',
  '../../images/login-4.png',
]
</script>

<template>
  <!-- Navbar -->
  <Navbar :is-login-page="true"></Navbar>

  <div class="relative h-full overflow-x-hidden mb-10">
    <div class="bg-login min-h-screen flex flex-col sm:justify-center items-center pt-6 mt-0 lg:mt-0 sm:pt-0">
      <div class="w-full sm:max-w-md mt-24 px-10 py-9 bg-white shadow-lg overflow--x-hidden rounded-xl z-[99]">
        <slot />
      </div>

    </div>
    <div class="absolute w-full bottom-0">
      <div class="bg-repeat h-full w-full">
        <img class="w-full" src="../../images/wave-login.svg" alt="Bottom Wave">
      </div>

    </div>
  </div>
  <!-- Main content -->
  <!-- SVG Image at the bottom -->
</template>

<style>
.bg-login {
  background: #F9F6F7;
}

html,
body {
  margin: 0;
  padding: 0;
  height: 100%;
  /* overflow: hidden; */
}
</style>
