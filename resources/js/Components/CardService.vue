<script setup>
	import {ref} from 'vue'
	import SectionTitle from '@/Components/SectionTitle.vue';

	const serviceId = ref(1);
	const displayDetailLayanan = (id) => {
    serviceId.value = id
  }

	const defaultService = {
    description: '-',
    duration: '-',
    requirement: '-',
    linkTiket: '#',
    gformLink: '#',
  };

	const listService = [
		{
			id: 1,
			title: 'Surat Cuti / Ijazah / Transkrip / SKPI',
			...defaultService,
		},
		{
			id: 2,
			title: 'Ujian (UTS & UAS)',
			description: ' Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sed vitae, sunt consectetur, neque, obcaecati amet labore doloribus ducimus quasi dolorem magnam praesentium repudiandae inventore maxime aspernatur eius voluptates quidem! Odio?',
			duration: '3 Hari Kerja',
			requirement: 'Sudah Isi Form Permintaan Surat Keterangan Akademik MahasiswaUnduh dokumen di sini',
			linkTiket: '',
			gformLink: ''
		},
		{
			id: 3,
			title: 'Surat Keterangan Aktif',
			...defaultService,
		},
	]
</script>

<template>
  <div class="lg:mx-16 mx-5 my-20">
		<SectionTitle title="Informasi Layanan Akademik" />
		<div class="flex flex-wrap items-start gap-x-14 gap-y-4">
			<div class="w-full lg:w-[30%] xl:w-[30%] shadow-md rounded-md border-[1px]">
				<div v-for="(item, index) in listService" :item="item" @click="displayDetailLayanan(item.id)"
						:class="[(serviceId == item.id ? 'border-primary-400 bg-primary-400' : 'border-neutral-400 bg-neutral-100 hover:border-primary-400 hover:bg-primary-400' ), 
						(index == listService.length - 1 ? 'rounded-b-lg' : 'border-b-2'), (index == 0 ? 'rounded-t-lg' : '') ]"
						class="group px-4 py-3 cursor-pointer ">
					<p :class="serviceId == item.id ? 'text-white' : 'group-hover:text-white text-primary-400' " 
						class="text-base mb-0 font-medium">{{ item.title }}</p>
				</div>
			</div>
			<div v-for="(item, index) in listService" :item="item" :class="serviceId == item.id ? 'w-full lg:w-[60%] xl:w-[65%]' : 'hidden'">
				<div v-show="serviceId == item.id" v-cloak class="rounded-lg shadow-lg border-2 bg-neutral-100">
					<div class="card-header text-primary-400 py-3 px-5 border-b-2">
						<h3 class="font-semibold">{{ item.title }}</h3>
					</div>
					<div class="card-body py-5 px-7">
						<div class="description mb-4">
							<p class="font-bold mb-2 text-base">Deskripsi : <span class=" font-light">{{ item.description}}</span></p>
							<p class="font-bold mb-2 text-base">Pengerjaaan : <span class=" font-light">{{ item.duration }}</span></p>
							<p class="font-bold mb-2 text-base">Requirement : <span class=" font-light">{{ item.requirement }}</span></p>
						</div>
					</div>
			
				</div>
			</div>
		</div>
    
  </div>
</template>