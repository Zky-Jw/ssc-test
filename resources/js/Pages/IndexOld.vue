<script setup>
import Navbar from '@/Components/Navbar.vue'
import Hero from '@/Components/Hero.vue';
import { Head, Link } from '@inertiajs/vue3';
// import CustomSection from '@/Components/CustomSection.vue';
import GuideServiceVue from '@/Components/GuideService.vue';
import SliderInfo from '@/Components/SliderInfo.vue';
import CategoryService from '@/Components/CategoryService.vue';
// import CardService from '@/Components/CardService.vue';
import ServiceOnline from '@/Components/ServiceOnline.vue';
// import CardNewsList from '@/Components/CardNewsList.vue';
import Footer from '@/Components/Footer.vue';
import Linktree from '@/Components/Linktree.vue';
defineProps({
		canLogin: {
				type: Boolean,
		},
		canRegister: {
				type: Boolean,
		},
		laravelVersion: {
				type: String,
				required: true,
		},
		phpVersion: {
				type: String,
				required: true,
		}
});
</script>

<template>
		<Head title="Student Service Center" />
		<Navbar class="absolute top-0 left-0 w-full z-20"></Navbar>
		<Hero></Hero>
		<GuideServiceVue />
		<SliderInfo />
		<CategoryService />
		<Linktree/>
		<!-- <CardService/> -->
		<ServiceOnline/>
		
		<!-- <CardNewsList/> -->
		<Footer :is-footer-simple="false"/>
</template>

