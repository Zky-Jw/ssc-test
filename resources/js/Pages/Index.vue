<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import Hero from "@/Components/new/Hero.vue";
import AboutSection from "@/Components/new/AboutSection.vue";
import ServiceSection from "@/Components/new/ServiceSection.vue";
import CategoryService from "@/Components/new/CategoryService.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";


const accordionList = ref([
	{
		stringId: "hs-basic-one",
		title: "Kenapa harus dibuat paket untuk peminjaman logistik",
		content:
			"This is the first item's accordion body. It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions.",
	},
	{
		stringId: "hs-basic-two",
		title: "Kenapa sering ada peraturan dan ketentuan baru terus di SSC?",
		content:
			"This is the second item's accordion body. It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions.",
	},
	{
		stringId: "hs-basic-three",
		title: "Kenapa mengurus berkas di SSC lama sekali sih?",
		content:
			"This is the third item's accordion body. It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions.",
	},
]);

const thisStringIdAccordion = ref("hs-basic-one");

const toggleAccordion = (stringId) => {
	return thisStringIdAccordion.value === stringId
};
</script>

<template>
	<Head title="Beranda" />
	<BaseLayout>
		<Hero></Hero>
		<AboutSection></AboutSection>
		<ServiceSection></ServiceSection>
		<CategoryService></CategoryService>
		<!-- <section class="my-24 bg-section-ssc py-20">
			<div class="container mx-auto px-4 sm:px-6 lg:px-8">
				<div class="relative flex flex-col bg-white border shadow-sm rounded-xl overflow-hidden">
					<div class="flex flex-auto flex-col justify-center items-center px-5 py-20 md:px-24 md:text-center">
						<h2 class="font-black text-3xl md:text-4xl font-poppins">
							Butuh Layanan
							<span class="text-primary-400">Self Service?</span>
						</h2>
						<p class="text-neutral-600 my-6">
							<span class="font-bold">Layanan self-service </span>SSC
							memungkinkan mahasiswa untuk secara mandiri mengelola
							kebutuhan administratif kampus. Hal ini memberi
							mahasiswa kendali langsung atas administrasi mereka
							sendiri, sambil membebaskan waktu pihak administrasi
							untuk fokus pada tugas yang lebih kompleks.
						</p>
						<Link :href="'#'"
							class="px-7 py-1.5 border-2 bg-primary-400 text-white rounded-full font-bold inline-block">
						Layanan Online
						</Link>
						<div class="absolute bottom-0 right-0">
							<img class="w-56 h-auto" src="../../images/self-service.png" alt="..." />
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="my-24">
			<div class="container mx-auto px-4 sm:px-6 lg:px-8">
				<h2 class="font-black text-3xl md:text-4xl font-poppins text-center">
					Frequently Asked Questions
				</h2>
				<div class="grid lg:grid-cols-12 my-20 gap-4 items-center">
					<div class="lg:col-span-5">
						<img class="h-auto w-72 block mx-auto" src="../../images/faq-image.png" alt="..." />
					</div>
					<div class="lg:col-span-7">
						<div class="hs-accordion-group">


							<div v-for="(item, index) in accordionList" :key="index"
								:class="thisStringIdAccordion === item.stringId ? 'active' : ''"
								class="hs-accordion hs-accordion-active:shadow-lg border-b hs-accordion-active:border hs-accordion-active:border-gray-200 hs-accordion-active:rounded-xl py-5 px-10"
								:id="item.stringId">
								<button @click="toggleAccordion(item.stringId)"
									class="hs-accordion-toggle text-2xl hs-accordion-active:text-primary-400 py-3 inline-flex items-center justify-between gap-x-3 w-full font-semibold text-start hover:text-primary-400 rounded-lg"
									:aria-controls="item.stringId">
									{{ item.title }}
									<svg class="hs-accordion-active:hidden block size-4" xmlns="http://www.w3.org/2000/svg" width="24"
										height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
										stroke-linecap="round" stroke-linejoin="round">
										<path d="m6 9 6 6 6-6"></path>
									</svg>
									<svg class="hs-accordion-active:block hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24"
										height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
										stroke-linecap="round" stroke-linejoin="round">
										<path d="m18 15-6-6-6 6"></path>
									</svg>
								</button>
								<div :id="item.stringId" :class="thisStringIdAccordion === item.stringId ? '' : 'hidden'"
									class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 pr-5"
									:aria-labelledby="item.stringId">
									<p class="text-dark">
										{{ item.content }}
									</p>
								</div>
							</div>


						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="my-28">
			<div class="container mx-auto px-4 sm:px-6 lg:px-8">
				<div
					class="relative flex flex-col border border-gray-300 rounded-xl shadow-xl px-5 md:px-20 overflow-hidden">
					<div class="absolute top-0 left-0">
						<img class="w-56 h-auto" src="../../svg/pusaran.svg" alt="..." />
					</div>
					<div class="grid lg:grid-cols-2 gap-8 items-center">
						<div class="py-20">
							<h2 class="font-bold text-3xl lg:text-5xl mb-3">
								Anda Punya Keluhan Terhadap Kampus Kita Tercinta?
							</h2>
							<p class="text-primary-400 text-lg font-normal mb-5">
								Atau punya keluhan untuk SSC?
							</p>
							<Link :href="'#'"
								class="px-7 py-1.5 border-2 bg-primary-400 text-white rounded-full font-bold inline-block">
							Form Keluhan Pusat dan Saran
							</Link>
						</div>
						<div>
							<img class="h-auto w-auto block mx-auto" src="../../images/pusaran.png" alt="..." />
						</div>
					</div>
				</div>
			</div>
		</section> -->
	</BaseLayout>
</template>
