<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps({
	role: Object,
});
const pageTitle = ref('Role');
const form = useForm({
	role: props.role.role,
	active: props.role.active,
	updatedby: '999',
});
const submit = () => {
	form.put(route('role.update', props.role.id));
};
</script>
<template>
	<Head title="Dashboard" />
	<BreezeAuthenticatedLayout :page-title="pageTitle">
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Edit role
			</h2>
		</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 bg-white border-b border-gray-200">
						<div className="flex items-center justify-between mb-6">
							<div class="">
								<h3 class="text-primary-400 text-center">Edit Role</h3>
							</div>
							<Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none"
								:href="route('role.index')">
							Back
							</Link>
						</div>
						<form name="createForm" @submit.prevent="submit">
							<div className="flex flex-col">
								<div className="mb-4">
									<BreezeLabel for="role" value="Nama Roles" />
									<BreezeInput id="role" type="text" class="mt-1 block w-full" v-model="form.role"
										autofocus />
									<span className="text-red-600" v-if="form.errors.role">
										{{ form.errors.role }}
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
</BreezeAuthenticatedLayout></template>