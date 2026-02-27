<script setup>
// import Navbar from '@/Components/Navbar.vue'
// import Footer from '@/Components/Footer.vue';
import Navbar from "@/Components/new/Navbar.vue";
import Footer from "@/Components/new/Footer.vue";
</script>

<template>
  <Navbar></Navbar>
    <slot></slot>
  <Footer></Footer>
</template>