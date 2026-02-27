<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import { defineProps, ref } from 'vue';

const props = defineProps({
	people: Array,
});

const pageTitle = ref('Document Template');

const pihakSelect = ref([
	{
		options: props.people,
	},
]);
const pihak = props.people;
const keteranganSelect = ref([
	{
		options: [
			{ value: 'mengetahui', label: 'Mengetahui' },
			{ value: 'menyetujui', label: 'Menyetujui' },
			{ value: 'menandatangani', label: 'Menandatangani' },
		],
	},
]);
// adding element html select after click button
const addPihakElement = () => {
	pihakSelect.value.push({
		options: [
			{ value: null, label: null },
		],
	});
};

const removePihakElement = (index) => {
	pihakSelect.value.splice(index, 1);
};

const tipeSelect = ref([
	{
		options: [
			{ value: 'text', label: 'Text' },
			{ value: 'number', label: 'Number' },
			{ value: 'date', label: 'Date' },
			{ value: 'textarea', label: 'Textarea' },
		],
	},
]);

const inputRows = ref([
	{
		name: '',
		type: 'Text',
	},
]);

const addInputRow = () => {
	// Add a new input row to the list
	inputRows.value.push({
		name: '',
		type: 'Text',
	});
};

const removeInputRow = (index) => {
	inputRows.value.splice(index, 1);
};

const form = useForm({
	title: '',
	content: [
		{ name: 'Nomor surat', type: 'Text' },
		{ name: 'Nama mahasiswa', type: 'Text' },
		{ name: 'NIM', type: 'Text' },
		{ name: 'Program studi', type: 'Text' },
		{ name: 'Perwakilan', type: 'Text' },
	],
	required_field: '',
	approval: '',
	active: 'Y',
	createdby: '999',
});

const submit = () => {
	form.required_field = inputRows.value.map((item) => {
		return { name: item.name, type: item.type };
	});
	form.approval = pihakSelect.value.map((item) => {
		return { name: item.name, };
	});
	form.post(route('document-template.store'));
};
</script>
<template>
	<Head content="Dashboard" />
	<BreezeAuthenticatedLayout :page-title="pageTitle">
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Create template
			</h2>
		</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 bg-white border-b border-gray-200">
						<div className="flex items-center justify-between mb-6">
							<div class="">
								<h3 class="text-primary-400 text-center">Create Document Template</h3>
							</div>
							<Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none"
								:href="route('document-template.index')">
							Back
							</Link>
						</div>
						<form name="createForm" @submit.prevent="submit">
							<div className="flex flex-col">
								<div className="mb-4">
									<BreezeLabel for="template" value="Nama Template" />
									<BreezeInput id="template" type="text" class="mt-1 block w-full" v-model="form.title"
										autofocus />
									<span className="text-red-600" v-if="form.errors.title">
										{{ form.errors.title }}
									</span>
								</div>
								<!-- Start Konten Surat -->
								<div class="mb-7">
									<label for="input-rich-text" class="block text-sm font-medium mb-2">Ditanda tangani
										Oleh</label>
									<div v-for="(select, index) in pihakSelect" :key="index">
										<div class="flex">
											<div :class="index > 0 ? 'w-11/12' : 'w-full'">
												<BreezeSearchSelect class="mt-1 mb-2 block" name="persons" id="person"
													v-model="select.name" :option="pihak" :custom-label="nameWithLang"
													placeholder="Cari Penandatangan" label="name" track-by="name">
												</BreezeSearchSelect>
											</div>
											<div v-if="index > 0" class="px-1 m-1">
												<button @click="removePihakElement(index)" type="button"
													class="px-2 py-2 border-none border-primary-300 text-primary-300 rounded-md focus:outline-none text-sm absolute hover:bg-primary-300 hover:text-white">
													<Icon class="text-2xl" icon="solar:trash-bin-2-linear" />
												</button>
											</div>
										</div>
									</div>

									<div class="relative mt-2">
										<div class=" absolute inset-y-0 right-0 h-12">
											<button @click="addPihakElement" type="button"
												class="px-3 py-1 border border-primary-300 text-primary-300 rounded-md focus:outline-none inline text-sm hover:bg-primary-300 hover:text-white">
												Tambahkan Penandatangan
											</button>
										</div>
									</div>
								</div>
								<div class="grid grid-cols-12 gap-4">
									<div class="col-span-5 md:col-span-6">
										<label class="block text-sm font-medium mb-2">Nama input lampiran</label>
									</div>
									<div class="col-span-5 md:col-span-6">
										<label class="block text-sm font-medium mb-2">Tipe Input</label>
									</div>
								</div>
								<div v-for="(input, index) in inputRows" :key="index" class="grid grid-cols-12 gap-4 mb-2">
									<div :class="index > 0 ? 'col-span-6 md:col-span-6' : 'col-span-full md:col-span-6'">
										<input type="text"
											class="py-3 px-4 block w-full border-gray-200 bg-neutral-100 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
											placeholder="ex: Nama kegiatan, waktu kegiatan dll" v-model="input.name">
									</div>
									<div :class="index > 0 ? 'col-span-5 md:col-span-5' : 'col-span-full md:col-span-6'">
										<div v-for="(select, index) in tipeSelect" :key="index">
											<select
												class="py-3 px-4 pr-9 block w-full border-gray-200 bg-neutral-100 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
												v-model="input.type">
												<option v-for="option in select.options" :key="option.value" :value="option.value">{{ option.label
												}}
												</option>
											</select>
										</div>
									</div>
									<div v-if="index > 0" class="col-span-1">
										<button @click="removeInputRow(index)" type="button"
											class="px-2 py-2 border-none border-primary-300 text-primary-300 rounded-md focus:outline-none text-sm absolute  hover:bg-primary-300 hover:text-white">
											<Icon class="text-2xl" icon="solar:trash-bin-2-linear" />
										</button>
									</div>
								</div>
								<div class="relative mt-4">
									<div class=" absolute inset-y-0 right-0 h-12">
										<button type="button" @click="addInputRow"
											class="px-3 py-1 border border-primary-300 text-primary-300 rounded-md focus:outline-none inline text-sm hover:bg-primary-300 hover:text-white">
											Tambahkan input
										</button>
									</div>
								</div>
							</div>
							<div className="mt-4">
								<button type="submit"
									className="px-12 py-1.5 font-semibold text-lg text-white bg-primary-300 rounded">
									Save
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</BreezeAuthenticatedLayout>
</template>