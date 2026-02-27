<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
const form = useForm({
	modul: '',
	active: 'Y',
	createdby: '999',
});
const submit = () => {
	form.post(route('modul.store'));
};
</script>
<template>
	<Head title="Dashboard" />
	<BreezeAuthenticatedLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Create Modul
			</h2>
		</template>
		<div class="">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-B8">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-Modul $lg">
					<div class="p-6 bg-white border-b border-gray-200">
						<div className="flex items-center justify-between mb-6">
							<div class="">
								<h3 class="text-primary-400 text-center">Create Modul</h3>
							</div>
							<Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none"
								:href="route('modul')">
							Back
							</Link>
						</div>
						<form name="createForm" @submit.prevent="submit">
							<div className="flex flex-col">
								<div className="mb-4">
									<BreezeLabel for="modul" value="Nama Modul" />
									<BreezeInput id="modul" type="text" class="mt-1 block w-full" v-model="form.modul"
										autofocus />
									<span className="text-red-600" v-if="form.errors.modul">
										{{ form.errors.modul }}
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