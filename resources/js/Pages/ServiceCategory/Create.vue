<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

let types = [{ id: 'time', name: 'Waktu', }, { id: 'order', name: 'Pengajuan', },];
const form = useForm({
	category: '',
	type: '',
	active: 'Y',
	createdby: '999',
});
const pageTitle = ref('Service Category');
const submit = () => {
	form.post(route('category.store'));
};
</script>
<template>
	<Head title="Dashboard" />
	<BreezeAuthenticatedLayout :page-title="pageTitle">
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Create Service Category
			</h2>
		</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 bg-white border-b border-gray-200">
						<div className="flex items-center justify-between mb-6">
							<div class="">
								<h3 class="text-primary-400 text-center">Create Service Category</h3>
							</div>
							<Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none"
								:href="route('category.index')">
							Back
							</Link>
						</div>
						<form name="createForm" @submit.prevent="submit">
							<div className="flex flex-col">
								<div className="mb-4">
									<BreezeLabel for="category" value="Nama Kategori" />
									<BreezeInput id="category" type="text" class="mt-1 block w-full" v-model="form.category"
										autofocus />
									<span className="text-red-600" v-if="form.errors.category">
										{{ form.errors.category }}
									</span>
								</div>
							</div>
							<div className="flex flex-col">
								<div className="mb-4">
									<BreezeLabel for="type" value="Jenis Kategori" />
									<BreezeSearchSelect class="mt-1 block w-full" v-model="form.type" name="type" id="type"
										:option="types" :custom-label="nameWithLang" placeholder="Cari Tipe" label="name"
										track-by="name">
									</BreezeSearchSelect>
									<span className="text-red-600" v-if="form.errors.type">
										{{ form.errors.type }}
									</span>
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