<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { component as CKEditor } from '@ckeditor/ckeditor5-vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

const pageTitle = ref('Service');

const props = defineProps({
	time: Array,
	order: Array,
	unit: Array,
	people: Array,
});


const form = useForm({
	service: '',
	unit: '',
	person: '',
	time: '',
	order: '',
	description: '',
	requirement: '',
	duration: '',
	active: 'Y',
	createdby: '999',
});

const editor = ClassicEditor;
// const editorData = ref('masukkan deskripsi yang diperlukan');
const editorConfig = ref({
	placeholder: 'Masukkan teks yang diperlukan',
	toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
})
const submit = () => {
	form.post(route('service.store'));
};
</script>
<template>

	<Head title="Dashboard" />
	<BreezeAuthenticatedLayout :page-title="pageTitle">
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Create service
			</h2>
		</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 bg-white border-b border-gray-200">
						<div className="flex items-center justify-between mb-6">
							<div class="">
								<h3 class="text-primary-400 text-center">Create Service</h3>
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
									<div>
										<CKEditor :editor="editor" v-model="form.description" :config="editorConfig" required>
										</CKEditor>
									</div>
									<span className="text-red-600" v-if="form.errors.description">
										{{ form.errors.description }}
									</span>
								</div>
								<div className="mb-4">
									<BreezeLabel for="requirement" value="Syarat & Ketentuan Khusus" />
									<div>
										<CKEditor :editor="editor" v-model="form.requirement" :config="editorConfig" required>
										</CKEditor>
									</div>
									<span className="text-red-600" v-if="form.errors.requirement">
										{{ form.errors.requirement }}
									</span>
								</div>
								<div className="mb-4">
									<BreezeLabel for="duration" value="Durasi pengerjaan" />
									<BreezeInput id="duration" type="number" class="mt-1 block w-full" v-model="form.duration"
										autofocus />
									<small class="italic">*dalam satuan hari</small>
									<span className="text-red-600" v-if="form.errors.duration">
										{{ form.errors.duration }}
									</span>
								</div>
							</div>
							<div className="mt-4">
								<button type="submit" className="px-12 py-1.5 font-semibold text-lg text-white bg-primary-300 rounded">
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
<style>
.ck-editor__editable_inline {
	padding: 0 25px !important;
	min-height: 250px;
}
</style>
