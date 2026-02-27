<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import { ref } from 'vue';
import TitleDashboard from '@/Components/TitleDashboard.vue';
// import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
// import { component as CKEditor } from '@ckeditor/ckeditor5-vue';
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


const encodeText = (text) => {
	return text.replace(/[\u00A0-\u9999<>\&]/gim, function (i) {
		return '&#' + i.charCodeAt(0) + ';';
	});
};


const decodeText = (text) => {
	return text.replace(/&#(\d+);/g, function (match, dec) {
		return String.fromCharCode(dec);
	});
};


const props = defineProps({
	template: Array,
	ticket: Array,
	people: Array,
	errors: Object,
});
const ticket = props.ticket;
const pihak = props.people;
const pihakSelect = ref([{ options: pihak, },]);
const contField = ref([{ name: 'data pemilik', type: 'text', },]);
let reqField = ref([{ name: 'data surat', type: 'text', },]);

const addPihakElement = () => {
	pihakSelect.value.push({
		options: [
			{ value: null, label: null },
		],
		name: '',
	});
};

const removePihakElement = (index) => {
	pihakSelect.value.splice(index, 1);
};

const setTemplate = () => {
	const tempId = form.template.id;
	// show btn-smb after select template
	const btnSmb = document.querySelector('.btn-smb');
	btnSmb.classList.remove('hidden');
	// 
	axios.get(`/get-json-template-by-id/${tempId}`)
		.then((response) => {
			const { code, data } = response.data;
			if (code === 200) {
				const { content, required_field, approval } = data;
				const cont = JSON.parse(content);
				const req = JSON.parse(required_field);
				const appr = JSON.parse(approval);
				let varCont, varReq;

				if (contField.value.length > 0) {
					contField.value.splice(0, contField.value.length);
				}
				for (let i = 0; i < cont.length; i++) {
					varCont = window['form.' + cont[i].name] = '';
					contField.value.push({
						name: cont[i].name,
						type: cont[i].type,
						value: '',
					});
				}
				if (reqField.value.length > 0) {
					reqField.value.splice(0, reqField.value.length);
				}
				for (let i = 0; i < req.length; i++) {
					reqField.value.push({
						name: req[i].name,
						type: req[i].type,
						value: '',
					});
				}
				if (pihakSelect.value.length > 0) {
					pihakSelect.value.splice(0, pihakSelect.value.length);
				}
				for (let i = 0; i < appr.length; i++) {
					pihakSelect.value.push({
						options: [
							{ value: null, label: null },
						],
						name: appr[i].name,
					});
				}
				reqField.value = reqField.value.filter(item => item.name !== null);
				pihakSelect.value = pihakSelect.value.filter(item => item.name !== null);
			} else if (code === 404) {
				console.log(data);
			}
		});
};

const form = useForm({
	ticketNumber: props.ticket.ticketNumber,
	template: '',
	approval: '',
	content: '',
	enclosure: '',
});

const submit = () => {
	form.approval = pihakSelect.value.map(item => ({ name: item.name }));
	form.content = contField.value.map(item => ({ name: item.name, value: item.value }));
	form.enclosure = reqField.value.map(item => ({ name: item.name, value: item.value }));
	form.post(route('document.store'));
};
</script>

<template>

	<Head title="Dashboard" />
	<BreezeAuthenticatedLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Create or just look for the person
			</h2>
		</template>
		<div class="my-12">
			<TitleDashboard :title="`Generate Surat`"></TitleDashboard>
			<div class="card bg-white flex flex-col w-full shadow-lg rounded-lg border-[1px] border-neutral-200">
				<div class="card-header block md:flex justify-between items-center px-9 py-5 border-b-[1px] border-neutral-200">
					<h3 class="font-bold text-primary-400 mb-3 md:mb-0">Form isi surat</h3>
					<button type="button" data-hs-overlay="#hs-basic-modal"
						class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border-2 border-gray-200 font-semibold text-primary-400 hover:text-white hover:bg-primary-400 hover:border-primary-400 text-sm">
						Preview Surat
					</button>
				</div>
				<div class="card-body py-12 px-10">
					<div v-if="props.errors.content !== ''"
						class="font-regular relative block w-full rounded-lg bg-red-100 p-4 text-base leading-5 text-red-400 opacity-100"
						data-dismissible="alert">
						<div class="mr-12">
							<p v-for="(error, i) in props.errors" :key="i">{{ error }}</p>
						</div>
					</div>
					<form name="createForm" @submit.prevent="submit">
						<div>
							<div class="select mb-7">
								<label for="input-select" class="block text-sm font-medium mb-2">Pilih Template
									Surat</label>
								<BreezeSearchSelect class="mt-1 mb-5 block" name="title" id="personSign" v-model="form.template"
									@select="setTemplate" :option="props.template" :custom-label="nameWithLang"
									placeholder="Cari template surat" label="name" track-by="name">
								</BreezeSearchSelect>
							</div>
							<div class="mb-7">
								<label for="input-rich-text" class="block text-sm font-bold mb-2 text-primary-300">Data
									pemilik
									surat</label>
								<div id="term" class="mb-4 rounded-lg px-6 py-5 text-base text-gray-800 bg-gray-100" role="alert">
									<p class="font-bold">Data ticket {{ ticket.ticketNumber }}</p>
									<p class="text-sm">{{ decodeText(ticket.person.creator.name) }} dengan NIM {{
										ticket.person.creator.id }},
										{{ ticket.person.creator.major }} dari {{ ticket.person.creator.faculty }}
									</p>
								</div>
								<div class="flex flex-wrap">
									<div v-for="(field, index) in contField" :key="index" :class="index > 0 ? 'w-2/4' : 'w-full'"
										class="p-1 mb-1">
										<input :type="field.type" :name="field.name" :placeholder="field.name" required
											v-model="field.value"
											class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
									</div>
								</div>
							</div>
							<div class="mb-7">
								<label for="input-rich-text" class="block text-md font-bold mb-2 text-primary-300">Data
									surat</label>
								<div id="term" class="mb-4 rounded-lg px-6 py-5 text-base text-gray-800 bg-gray-100" role="alert">
									<p class="font-bold">Data ticket {{ ticket.ticketNumber }}</p>
									<p class="text-sm">Pengguna meminta layanan {{ ticket.purpose.service.name }} dengan
										detail <span class="text-sm" v-html="ticket.content"></span>
									</p>
								</div>
								<div class="flex flex-wrap">
									<div v-for="(field, index) in reqField" :key="index" class="p-1 mb-1"
										:class="field.type.toLowerCase() === 'textarea' ? 'w-full' : 'w-2/4'">
										<div v-if="field.type.toLowerCase() === 'text' || field.type.toLowerCase() === 'number'">
											<label class="block text-sm font-medium mb-2">{{ field.name }}</label>
											<input :type="field.type.toLowerCase()" :name="field.name" v-model="field.value" required
												class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
										</div>
										<div v-if="field.type.toLowerCase() === 'date'">
											<label for="textarea" class="block text-sm font-medium mb-2">{{ field.name
												}}</label>
											<VueDatePicker v-model="field.value" :minDate="new Date()"></VueDatePicker>
										</div>
										<div v-if="field.type.toLowerCase() === 'textarea'">
											<label for="textarea" class="block text-sm font-medium mb-2">{{ field.name
												}}</label>
											<textarea rows="3" :name="field.name" v-model="field.value"
												class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"></textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="mb-7">
								<label for="input-rich-text" class="block text-sm font-medium mb-2">Ditanda tangani
									Oleh</label>
								<div v-for="(select, index) in pihakSelect" :key="index">
									<div class="flex">
										<div :class="index > 0 ? 'w-11/12' : 'w-full'">
											<BreezeSearchSelect class="mt-1 mb-2 block" name="persons" id="person" v-model="select.name"
												:option="pihak" :custom-label="nameWithLang" placeholder="Cari Penandatangan" label="name"
												track-by="name">
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
							<div className="mt-12" class="btn-smb hidden">
								<button type="submit" className="px-12 py-1.5 font-semibold text-lg text-white bg-primary-300 rounded">
									Save
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div id="hs-basic-modal" v-if="form.template !== ''"
			class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[60] overflow-x-hidden overflow-y-auto">
			<div
				class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:ml-auto xl:mx-auto">
				<div class="flex flex-col bg-white border shadow-sm rounded-xl">
					<div class="flex justify-between items-center py-3 px-4 border-b">
						<h3 class="font-bold text-gray-800">
							Preview Surat
						</h3>
						<button type="button"
							class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded-md text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm"
							data-hs-overlay="#hs-basic-modal">
							<span class="sr-only">Close</span>
							<Icon icon="eva:close-fill" class="text-dark text-2xl" />
						</button>
					</div>
					<!-- Halaman Utama -->
					<div class="page-1 p-6">
						<div class="relative h-full w-full">
							<div class="kop-header absolute top-6 right-5">
								<img class="object-scale-down w-28 h-20" src="../../../images/logokop-telu.png" alt="" />
							</div>
							<p class="text-xs text-center italic m-1  text-gray-400">--- page 1 ---</p>
							<div class="content py-24 pb-48 px-5 border-2">
								<div class="text-center font-serif mb-7">
									<p class="font-semibold text-sm">{{ form.template.name }}</p>
									<p class="text-xs font-normal">{{ contField[0].value || '' }}</p>
								</div>
								<p class="text-xs font-normal mb-5">Bersamaan dengan surat ini saya,</p>
								<div class="mb-5">
									<table class="table-auto">
										<tbody>
											<tr v-for="item in contField" :key="item">
												<td class="text-xs font-normal" v-if="item.name !== 'Nomor surat'">
													{{item.name }}
												</td>
												<td class="pl-10" v-if="item.name !== 'Nomor surat'">:</td>
												<td class="text-xs font-normal pl-5" v-if="item.name !== 'Nomor surat'">{{ item.value }}</td>
											</tr>
											<tr>
												<td class="py-5"></td>
											</tr>
										</tbody>
									</table>
									<p class="text-xs font-normal mb-10">
										Dengan ini mengajukan {{ form.template.name }} melalui SSC dengan nomor tiket {{
											ticket.ticketNumber }},
										serta detail yang terlampir pada halaman selanjutnya.
										<br>Demikian permohonan ini saya buat dengan sesungguhnya, dan segala akibat yang
										ditimbulkan oleh
										permohonan ini sepenuhnya menjadi tanggung jawab saya.
									</p>
									<p class="text-xs font-normal mb-5">Surabaya, {{
										$dateFormatIndo(new Date().toLocaleDateString()) }}</p>
									<div class="flex flex-wrap">
										<div class="basis-4/12 text-center">
											<p class="text-xs font-normal mb-20">Yang mengajukan,</p>
											<p class="text-xs font-normal mb-2">{{
												$makeShortName(ticket.person.creator.name) }}</p>
										</div>
										<div class="basis-4/12 text-center" v-for="item in pihakSelect" :key="item">
											<p class="text-xs font-normal mb-20" v-if="item.name !== ''">Menandatangani,</p>
											<p class="text-xs font-normal mb-2">
												{{ item.name !== '' ? $makeShortName(item.name.name) : ''}}
												</p>
										</div>
									</div>
								</div>
							</div>
							<div class="kop-footer absolute bottom-0">
								<!-- <div class="pl-4 pb-3">
									<p class="font-kop-institut">Telkom University Surabaya</p>
									<p class="text-xs font-thin">Jl. Ketintang No. 156</p>
									<p class="text-xs font-medium">Kota Surabaya, Jawa Timur 60231</p>
									<p class="text-xs font-medium">Telp: (031) 8280800; (081)13980800</p>
									<p class="text-xs font-medium font-kop-link"></p>
								</div> -->

								<div class="w-full p-0 m-0">
									<img class="" src="../../../images/footer-surat.png" alt="" />
								</div>
							</div>
						</div>
					</div>
					<!-- Halaman Lampiran -->
					<div class="page-1 p-6">
						<div class="relative h-full w-full">
							<div class="kop-header absolute top-6 right-5">
								<img class="object-scale-down w-28 h-20" src="../../../images/logokop-telu.png" alt="" />
							</div>
							<p class="text-xs text-center italic m-1  text-gray-400">--- page 2 ---</p>
							<div class="content py-24 pb-48 px-5 border-2">
								<p class="text-sm font-bold mb-5">Lampiran</p>
								<p class="text-xs font-normal mb-5">Berikut detail pengajuan {{ form.template.name }}</p>
								<div class="mb-5">
									<table class="table-auto">
										<tbody>
											<tr v-for="item in reqField" :key="item">
												<td class="text-xs font-normal">{{ item.name }}</td>
												<td class="pl-10">:</td>
												<td class="text-xs font-normal pl-5" v-if="item.type!='date'">{{ item.value }}</td>
												<td class="text-xs font-normal pl-5" v-else>{{ $dateFormatIndo(item.value) }}</td>
											</tr>
											<tr class="">
												<td class="py-10"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="kop-footer absolute bottom-0">
								<!-- <div class="pl-4 pb-3">
									<p class="font-kop-institut">Telkom University Surabaya</p>
									<p class="text-xs font-thin">Jl. Ketintang No. 156</p>
									<p class="text-xs font-medium">Kota Surabaya, Jawa Timur 60231</p>
									<p class="text-xs font-medium">Telp: (031) 8280800; (081)13980800</p>
									<p class="text-xs font-medium font-kop-link"></p>
								</div> -->

								<div class="w-full p-0 m-0">
									<img class="" src="../../../images/footer-surat.png" alt="" />
								</div>
							</div>
						</div>
					</div>

					<div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t">
						<button type="button"
							class="hs-dropdown-toggle py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm"
							data-hs-overlay="#hs-basic-modal">
							Close
						</button>
					</div>
				</div>
			</div>
		</div>
	</BreezeAuthenticatedLayout>
</template>

<style>
.ck-editor__editable {
	min-height: 200px;
}

p {
	font-size: 14px;
}
</style>