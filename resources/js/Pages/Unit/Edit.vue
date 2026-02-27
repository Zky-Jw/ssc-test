<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
const props = defineProps({
	unit: Object,
	units: Array,
	people: Array,
});

console.log(props.unit); // --- IGNORE ---
const pageTitle = ref('Unit');
const form = useForm({
	unit: props.unit.unit,
	icons: props.unit.icons,
	supervisor: props.unit.supervisor ? {
		id: props.unit.supervisor.id,
		name: props.unit.supervisor.person,
	} : null,
	unit_parent: props.unit.unit_parent ? {
		id: props.unit.unit_parent.id,
		name: props.unit.unit_parent.unit,
	} : null,
	showParenthesis: props.unit.unit_parent ? true : false,
	active: props.unit.active,
	updatedby: '999',
});
const submit = () => {
	form.put(route('unit.update', props.unit.id));
};
</script>
<template>
	<Head title="Dashboard" />
	<BreezeAuthenticatedLayout :page-title="pageTitle">
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Edit unit
			</h2>
		</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="p-6 bg-white border-b border-gray-200">
						<div className="flex items-center justify-between mb-6">
							<div class="">
								<h3 class="text-primary-400 text-center">Edit Unit</h3>
							</div>
							<Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none"
								:href="route('unit.index')">
							Back
							</Link>
						</div>
						<form name="createForm" @submit.prevent="submit">
							<div className="flex flex-col">
								<div className="mb-4">
									<BreezeLabel for="unit" value="Nama Unit" />
									<BreezeInput id="unit" type="text" class="mt-1 block w-full" v-model="form.unit"
										autofocus />
									<span className="text-red-600" v-if="form.errors.unit">
										{{ form.errors.unit }}
									</span>
								</div>
								<div className="mb-4">
									<BreezeLabel for="unit" value="Icon Unit" />
									<BreezeInput id="icons" type="text" class="mt-1 block w-full" v-model="form.icons"
										autofocus />
									<span className="text-red-600" v-if="form.errors.icons">
										{{ form.errors.icons }}
									</span>
								</div>
								<div className="mb-4">
									<BreezeLabel for="person_id" value="Supervisor" />
										<BreezeSearchSelect class="mt-1 block w-full" v-model="form.supervisor"
											name="person" id="service" :option="people" :custom-label="nameWithLang"
											placeholder="Cari penanggung jawab" label="name" track-by="name">
										</BreezeSearchSelect>
										<span className="text-red-600" v-if="form.errors.supervisor">
											{{ form.errors.supervisor }}
										</span>
								</div>
								<div className="mb-4">
									<Checkbox class="accen</div>t-gray-700 cursor-pointer" v-model="form.showParenthesis" @click="clearParentUnit" :checked="form.showParenthesis"/>
									<span class="ml-2">Memiliki Atasan</span>
								</div>
								<div className="mb-4"  v-if="form.showParenthesis">
									<BreezeLabel for="unit_parent" value="Unit Atasan" />
									<BreezeSearchSelect class="mt-1 block w-full" v-model="form.unit_parent" name="units"
											id="unit_parent" :option="units" :custom-label="nameWithLang"
											placeholder="Cari unit" label="name" track-by="name">
										</BreezeSearchSelect>
									<span className="text-red-600" v-if="form.errors.unit_parent">
										{{ form.errors.unit_parent }}
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
