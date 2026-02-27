<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import TitleDashboard from "@/Components/TitleDashboard.vue";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { component as CKEditor } from "@ckeditor/ckeditor5-vue";

// datepicker instance
// more config https://vue3datepicker.com/props/modes/
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const date = ref();

const editor = ClassicEditor;
// const editorData = ref('masukkan deskripsi yang diperlukan');
const editorConfig = ref({
	placeholder: "Masukkan isi surat",
	toolbar: [
		"heading",
		"|",
		"bold",
		"italic",
		"link",
		"bulletedList",
		"numberedList",
		"blockQuote",
	],
});

const pihakSelect = ref([
	{
		options: [
			{ value: "1", label: "Pihak 1" },
			{ value: "2", label: "Pihak 2" },
			{ value: "3", label: "Pihak 3" },
		],
	},
]);

// adding element html select after click button
const addPihakElement = () => {
	pihakSelect.value.push({
		options: [
			{ value: "1", label: "Pihak 1" },
			{ value: "2", label: "Pihak 2" },
			{ value: "3", label: "Pihak 3" },
		],
	});
};

const inputRows = ref([
	{
		name: "",
		type: "Tipe 1",
	},
]);

const addInputRow = () => {
	// Add a new input row to the list
	inputRows.value.push({
		name: "",
		type: "Tipe 1",
	});
};

const tableRows1 = [
	"Nama Ketua Pelaksana",
	"Nama Kegiatan",
	"Tanggal Kegiatan",
	"Tempat Kegiatan",
	"Waktu Kegiatan",
	"Total Peserta Kegiatan",
];

const tableRows2 = [
	"Tanggal Peminjaman",
	"Waktu Peminjaman",
	"Paket Peminjaman",
	"Tambahan Peminjaman",
];
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
					<h3 class="font-bold text-primary-400 mb-3 md:mb-0">
						Form isi surat
					</h3>
					<button type="button" data-hs-overlay="#hs-basic-modal"
						class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border-2 border-gray-200 font-semibold text-primary-400 hover:text-white hover:bg-primary-400 hover:border-primary-400 text-sm">
						Preview Surat
					</button>
				</div>
				<div class="card-body py-12 px-10">
					<form action="">
						<div>
							<div class="datepicker mb-7">
								<label for="input-datepicker" class="block text-sm font-medium mb-2">Tanggal Surat</label>
								<VueDatePicker v-model="date"></VueDatePicker>
							</div>
							<div class="select mb-7">
								<label for="input-select" class="block text-sm font-medium mb-2">Pilih Template Surat</label>
								<select id="input-select"
									class="py-3 px-4 pr-9 block w-full border-gray-200 bg-neutral-100 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500">
									<option v-for="index in 5" :key="index">
										Template {{ index }}
									</option>
								</select>
							</div>
							<div class="rich-text mb-10">
								<label for="input-rich-text" class="block text-sm font-medium mb-2">Isi Surat</label>
								<CKEditor :editor="editor" v-model="editorData" :config="editorConfig" style="height: 300px">
								</CKEditor>
							</div>
							<div class="mb-7">
								<label for="input-rich-text" class="block text-sm font-medium mb-2">Ditanda tangani Oleh</label>
								<div v-for="(select, index) in pihakSelect" :key="index">
									<select
										class="py-3 px-4 pr-9 mb-5 block w-full border-gray-200 bg-neutral-100 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500">
										<option v-for="option in select.options" :key="option.value">
											{{ option.label }}
										</option>
									</select>
								</div>
								<button @click="addPihakElement" type="button"
									class="w-full py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border-2 border-primary-400 bg-primary-400 font-semibold text-white hover:bg-primary-500 hover:border-primary-500 text-sm">
									Tambahkan Pihak
								</button>
							</div>
							<div v-for="(input, index) in inputRows" :key="index" class="grid grid-cols-12 gap-4 mb-5">
								<div class="col-span-full md:col-span-6">
									<label class="block text-sm font-medium mb-2">Nama input lampiran</label>
									<input type="text"
										class="py-3 px-4 block w-full border-gray-200 bg-neutral-100 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
										placeholder="Masukkan pihak yang akan menandatangani surat ini" v-model="input.name" />
								</div>
								<div class="col-span-full md:col-span-6">
									<label class="block text-sm font-medium mb-2">Tipe Input</label>
									<select
										class="py-3 px-4 pr-9 block w-full border-gray-200 bg-neutral-100 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
										v-model="input.type">
										<option v-for="index in 5" :key="index">
											Tipe {{ index }}
										</option>
									</select>
								</div>
							</div>
							<button type="button" @click="addInputRow"
								class="py-2 px-3 inline-flex justify-center items-center gap-2 rounded-md border-2 border-primary-400 bg-primary-400 font-semibold text-white hover:bg-primary-500 hover:border-primary-500 text-sm">
								Tambahkan Lampiran
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</BreezeAuthenticatedLayout>
	<div id="hs-basic-modal"
		class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[60] overflow-x-hidden overflow-y-auto">
		<div
			class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:ml-auto xl:mx-auto">
			<div class="flex flex-col bg-white border shadow-sm rounded-xl">
				<div class="flex justify-between items-center py-3 px-4 border-b">
					<h3 class="font-bold text-gray-800">Preview Surat</h3>
					<button type="button"
						class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center h-8 w-8 rounded-md text-gray-500 hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 focus:ring-offset-white transition-all text-sm"
						data-hs-overlay="#hs-basic-modal">
						<span class="sr-only">Close</span>
						<Icon icon="eva:close-fill" class="text-dark text-2xl" />
					</button>
				</div>
				<!-- Halaman Utama -->
				<div class="page-1 p-6">
					<div class="relative h-full w-full overflow-hidden">
						<div class="kop-header absolute top-6 right-5">
							<img class="object-scale-down w-28 h-20" src="../../../images/logokop-telu.png" alt="" />
						</div>
						<p class="text-xs text-center italic m-1 text-gray-400">
							--- page 1 ---
						</p>
						<div class="content py-24 pb-48 px-5 border-2">
							<div class="text-center font-serif mb-7">
								<p class="font-semibold text-sm">
									SURAT PEMINJAMAN LOGISTIK
								</p>
								<p class="text-xs font-normal">
									No. 012/AKD/XI/2023
								</p>
							</div>
							<p class="text-xs font-normal mb-5">
								Bersamaan dengan surat ini saya,
							</p>
							<div class="mb-5">
								<table class="table-auto">
									<tbody>
										<tr v-for="text in tableRows1" :key="text">
											<td class="text-xs font-normal">
												{{ text }}
											</td>
											<td class="pl-10">:</td>
										</tr>
										<tr class="">
											<td class="py-5"></td>
										</tr>
									</tbody>
								</table>
								<p class="text-xs font-normal mb-5">
									Dengan ini mengajukan Permohonan Cuti
									Akademik sebagai mahasiswa Institut
									Teknologi Telkom Surabaya, dengan detail
									terlampir.
									<br />Demikian permohonan ini saya buat
									dengan sesungguhnya, dan segala akibat yang
									ditimbulkan oleh permohonan ini sepenuhnya
									menjadi tanggung jawab saya.
								</p>
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
					<div class="relative h-full w-full overflow-hidden">
						<div class="kop-header absolute top-6 right-5">
							<img class="object-scale-down w-28 h-20" src="../../../images/logokop-telu.png" alt="" />
						</div>
						<p class="text-xs text-center italic m-1 text-gray-400">
							--- page 2 ---
						</p>
						<div class="content py-24 pb-48 px-5 border-2">
							<p class="text-xs font-normal mb-5">
								Berikut detail pengajuan Peminjaman Aset
								Logistik
							</p>
							<div class="mb-5">
								<table class="table-auto">
									<tbody>
										<tr v-for="text in tableRows1" :key="text">
											<td class="text-xs font-normal">
												{{ text }}
											</td>
											<td class="pl-10">:</td>
										</tr>
										<tr class="">
											<td class="py-5"></td>
										</tr>
										<tr v-for="text in tableRows2" :key="text">
											<td class="text-xs font-normal">
												{{ text }}
											</td>
											<td class="pl-10">:</td>
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
					<a class="py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all text-sm"
						href="#">
						Save changes
					</a>
				</div>
			</div>
		</div>
	</div>
</template>

<style>
.ck-editor__editable {
	min-height: 200px;
}

.font-kop-institut {
	font-size: 0.75rem;
	line-height: 1rem;
	color: #e93f3d;
	font-weight: 700;
}

.font-kop-link {
	font-size: 0.75rem;
	line-height: 1rem;
	color: #0507ce;
	text-decoration: underline;
	font-weight: 500;
}
</style>
