<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { component as CKEditor } from '@ckeditor/ckeditor5-vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps({
	service: Object,
	unit: Array,
	people: Array,
	time: Array,
	order: Array,
});

const pageTitle = ref('Service');

// make const time and order, they r part of one string of props.service.category_id which separated by +
const times = {
	id: props.service.time_id,
	name: props.service.times,
};
const orders = {
	id: props.service.order_id,
	name: props.service.orders,
};
const form = useForm({
	service: props.service.service,
	time: times,
	order: orders,
	description: props.service.description,
	service_additional_id: props.service.additional_id,
	requirement: props.service.requirement,
	duration: props.service.duration,
	unit: {
		id: props.service.unit_id,
		name: props.service.unit,
	},
	person: {
		id: props.service.person_id,
		name: props.service.person,
	},
	active: props.service.active,
	updatedby: '999',
});

const editor = ClassicEditor;
const editorConfig = ref({
	placeholder: 'Masukkan teks yang diperlukan',
	toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
})

const submit = () => {
	form.put(route('service.update', props.service.id));
};
</script>
<template>

	<Head title="Dashboard" />
	<BreezeAuthenticatedLayout :page-title="pageTitle">
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Edit service
			</h2>
		</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 bg-white border-b border-gray-200">
						<div className="flex items-center justify-between mb-6">
							<div class="">
								<h3 class="text-primary-400 text-center">Edit Service</h3>
							</div>
							<Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none"
								:href="route('service.index')">
							Back
							</Link>
						</div>
						<form name="createForm" @submit.prevent="submit">
							<div className="flex flex-col">
								<div className="mb-4">
									<BreezeLabel for="service" value="Nama Layanan" />
									<BreezeInput id="service" type="text" class="mt-1 block w-full" v-model="form.service" autofocus />
									<span className="text-red-600" v-if="form.errors.service">
										{{ form.errors.service }}
									</span>
								</div>
								<div className="flex">
									<div className="flex-1 mb-4 pr-4">
										<BreezeLabel for="time" value="Urgensi Layanan" />
										<BreezeSearchSelect class="mt-1 block w-full" v-model="form.time" name="time" id="time"
											:option="time" :custom-label="nameWithLang" placeholder="Cari urgensi" label="name"
											track-by="name">
										</BreezeSearchSelect>
										<span className="text-red-600" v-if="form.errors.time">
											{{ form.errors.time }}
										</span>
									</div>
									<div className="flex-1 mb-4">
										<BreezeLabel for="order" value="Jenis Layanan" />
										<BreezeSearchSelect class="mt-1 block w-full" v-model="form.order" name="order" id="order"
											:option="order" :custom-label="nameWithLang" placeholder="Cari Jenis" label="name"
											track-by="name">
										</BreezeSearchSelect>
										<span className="text-red-600" v-if="form.errors.order">
											{{ form.errors.order }}
										</span>
									</div>
								</div>
								<div className="flex">
									<div className="flex-1 mb-4 pr-4">
										<BreezeLabel for="unit_id" value="Unit" />
										<BreezeSearchSelect class="mt-1 block w-full" v-model="form.unit" name="units" id="service"
											:option="unit" :custom-label="nameWithLang" placeholder="Cari unit" label="name" track-by="name">
										</BreezeSearchSelect>
										<span className="text-red-600" v-if="form.errors.unit">
											{{ form.errors.unit }}
										</span>
									</div>
									<div className="flex-1 mb-4">
										<BreezeLabel for="person_id" value="Penanggung Jawab" />
										<BreezeSearchSelect class="mt-1 block w-full" v-model="form.person" name="person" id="service"
											:option="people" :custom-label="nameWithLang" placeholder="Cari penanggung jawab" label="name"
											track-by="name">
										</BreezeSearchSelect>
										<span className="text-red-600" v-if="form.errors.person">
											{{ form.errors.person }}
										</span>
									</div>
								</div>
								<div className="mb-4">
									<BreezeLabel for="description" value="Deskripsi layanan" />
									<CKEditor :editor="editor" v-model="form.description" :config="editorConfig" required>
									</CKEditor>
									<BreezeInput id="service_additional_id" type="hidden" class="mt-1 block w-full"
										v-model="form.service_additional_id" autofocus />
									<span className="text-red-600" v-if="form.errors.description">
										{{ form.errors.description }}
									</span>
								</div>
								<div className="mb-4">
									<BreezeLabel for="requirement" value="Syarat & Ketentuan Khusus" />
									<CKEditor :editor="editor" v-model="form.requirement" :config="editorConfig" required>
									</CKEditor>
									<span className="text-red-600" v-if="form.errors.requirement">
										{{ form.errors.requirement }}
									</span>
								</div>
								<div className="mb-4">
									<BreezeLabel for="duration" value="Durasi Pengerjaan" />
									<BreezeInput id="duration" type="number" class="mt-1 block w-full" v-model="form.duration"
										autofocus />
									<small class="italic">*dalam satuan hari</small>
									<span className="text-red-600" v-if="form.errors.duration">
										{{ form.errors.duration }}
									</span>
								</div>
								<div className="mb-4">
									<BreezeLabel for="active-status" value="Active Status" />
									<div class="flex items-center mt-3">
										<label class="text-sm font-semibold text-primary-400 mr-3">Off</label>
										<input type="checkbox" :checked="form.active == 'Y'" id="active-status" class="switch-status">
										<label class="text-sm font-semibold text-primary-400 ml-3">On</label>
									</div>
									<span className="text-red-600" v-if="form.errors.active">
										{{ form.errors.active }}
									</span>
								</div>
								<div className="mt-4">
									<button type="submit"
										className="px-12 py-1.5 font-semibold text-lg text-white bg-primary-300 rounded">
										Save
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</BreezeAuthenticatedLayout>
</template>
