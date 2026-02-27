<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
const form = useForm({
	service: '',
	unit_id: '',
	person_id: '',
	category_id: '',
	unit_id: '',
	person_id: '',
	active: 'Y',
	createdby: '999',
});
const pageTitle = ref('Recipient');
const submit = () => {
	form.post(route('recipient.store'));
};
</script>
<template>
	<Head title="Dashboard" />
	<BreezeAuthenticatedLayout :page-title="pageTitle">
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Create recipient
			</h2>
		</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 bg-white border-b border-gray-200">
						<div className="flex items-center justify-between mb-6">
							<div class="">
								<h3 class="text-primary-400 text-center">Create Recipient</h3>
							</div>
							<Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none"
								:href="route('recipient')">
							Back
							</Link>
						</div>
						<form name="createForm" @submit.prevent="submit">
							<div className="flex flex-col">
								<div className="mb-4">
									<BreezeLabel for="recipient" value="Nama Layanan" />
									<BreezeInput id="recipient" type="text" class="mt-1 block w-full" v-model="form.service"
										autofocus />
									<span className="text-red-600" v-if="form.errors.service">
										{{ form.errors.service }}
									</span>
								</div>
								<div className="flex">
									<div className="flex-1 mb-4 pr-4">
										<BreezeLabel for="category_id" value="Kategori Layanan" />
										<!-- ubah ke select, datanya $recipientCategory sudah ku pass dari controller -->
										<BreezeInput id="category_id" type="text" class="mt-1 block w-full"
											v-model="form.category_id" autofocus />
										<span className="text-red-600" v-if="form.errors.category_id">
											{{ form.errors.category_id }}
										</span>
									</div>
									<!-- <div className="flex-1 mb-4">
										<BreezeLabel for="recipient_category_id" value="Urgensi Layanan" />
										<BreezeInput id="recipient_category_id" type="number" class="mt-1 block w-full"
											v-model="form.service_category_id" autofocus />
										<span className="text-red-600" v-if="form.errors.service_category_id">
											{{ form.errors.service_category_id }}
										</span>
									</div> -->
								</div>
								<div className="flex">
									<div className="flex-1 mb-4 pr-4">
										<BreezeLabel for="unit_id" value="Unit" />
										<BreezeInput id="unit_id" type="text" class="mt-1 block w-full"
											v-model="form.unit_id" autofocus />
										<span className="text-red-600" v-if="form.errors.unit_id">
											{{ form.errors.unit_id }}
										</span>
									</div>
									<div className="flex-1 mb-4">
										<BreezeLabel for="person_id" value="Penanggung Jawab" />
										<BreezeInput id="person_id" type="text" class="mt-1 block w-full" v-model="form.person_id"
											autofocus />
										<span className="text-red-600" v-if="form.errors.person_id">
											{{ form.errors.person_id }}
										</span>
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