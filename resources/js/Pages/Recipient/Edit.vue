<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps({
	service: Object,
	recipients: Array,
	units: Array,
});

console.log(props.recipients)

const pageTitle = ref('Recipient');
const form = useForm({
	service: props.service.service.service_name,
	service_id: props.service.service.id,
	unit: {
		id: props.service.unit.id,
		name: props.service.unit.unit_name,
	},
	recipient: {
		id: props.service.person.id,
		name: props.service.person.person,
        phone : props.service.person.per_phone
	},
	active: props.service.active,
	updatedby: '999',
});
const submit = () => {
	form.put(route('recipient.update', props.service.id));
};
</script>
<template>
	<Head title="Dashboard" />
	<BreezeAuthenticatedLayout :page-title="pageTitle">
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Edit recipient
			</h2>
		</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 bg-white border-b border-gray-200">
						<div className="flex items-center justify-between mb-6">
							<div class="">
								<h3 class="text-primary-400 text-center">Edit Recipient</h3>
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
									<BreezeInput id="recipient" type="hidden" class="mt-1 block w-full"
										v-model="form.service_id" />
									<BreezeInput id="recipient" type="text" class="mt-1 block w-full" v-model="form.service"
										readonly />
									<span className="text-red-600" v-if="form.errors.service_id">
										{{ form.errors.service_id }}
									</span>
								</div>
								<div className="flex">
									<div className="flex-1 mb-4 pr-4">
										<BreezeLabel for="unit_id" value="Unit" />
										<BreezeSearchSelect class="mt-1 block w-full" v-model="form.unit" name="units"
											id="unit" :option="units" :custom-label="nameWithLang" placeholder="Cari Unit"
											label="name" track-by="name">
										</BreezeSearchSelect>
										<span className="text-red-600" v-if="form.errors.unit_id">
											{{ form.errors.unit_id }}
										</span>
									</div>
									<div className="flex-1 mb-4">
										<BreezeLabel for="person_id" value="Penanggung Jawab" />
										<BreezeSearchSelect class="mt-1 block w-full" v-model="form.recipient" name="person"
											id="recipient" :option="recipients" placeholder="Cari Penanggung Jawab"
											label="name" track-by="name">
										</BreezeSearchSelect>
										<span className="text-red-600" v-if="form.errors.person_id">
											{{ form.errors.person_id }}
										</span>
									</div>
								</div>
								<div className="mb-4">
									<BreezeLabel for="active-status" value="Active Status" />
									<div class="flex items-center mt-3">
										<label class="text-sm font-semibold text-primary-400 mr-3">Off</label>
										<input type="checkbox" :checked="form.active == 'Y'" id="active-status"
											class="switch-status">
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
