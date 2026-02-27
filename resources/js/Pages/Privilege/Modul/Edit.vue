<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
const props = defineProps({
	privilege: Object,
});
const form = useForm({
	privilege: props.privilege.privilege,
	active: props.privilege.active,
	updatedby: '999',
});
const submit = () => {
	form.put(route('privilege.update', props.privilege.id));
};
</script>
<template>
	<Head title="Dashboard" />
	<BreezeAuthenticatedLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Edit privilege
			</h2>
		</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 bg-white border-b border-gray-200">
						<div className="flex items-center justify-between mb-6">
							<div class="">
								<h3 class="text-primary-400 text-center">Edit Privilege</h3>
							</div>
							<Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none"
								:href="route('privilege.index')">
							Back
							</Link>
						</div>
						<form name="createForm" @submit.prevent="submit">
							<div className="flex flex-col">
								<div className="mb-4">
									<BreezeLabel for="privilege" value="Nama Privileges" />
									<BreezeInput id="privilege" type="text" class="mt-1 block w-full" v-model="form.privilege"
										autofocus />
									<span className="text-red-600" v-if="form.errors.privilege">
										{{ form.errors.privilege }}
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