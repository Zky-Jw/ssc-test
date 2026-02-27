<script setup>
import { defineProps, ref, reactive } from 'vue';
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
defineProps({
	roles: Array,
});
const form = useForm({
	per_id: '',
	privilege: '',
	active: 'Y',
	createdby: '999',
});
const submit = () => {
	form.post(route('privilege.store'));
};
const activeTabs = ref('all');
const tabs = reactive({
	listTabs: [
		{ name: 'User', key: 'user' },
		{ name: 'Modul', key: 'modul' },
	]
});
</script>
<template>
	<Head title="Dashboard" />
	<BreezeAuthenticatedLayout>
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Create privilege
			</h2>
		</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
					<div class="bg-white border-b border-gray-200">
						<div className="flex items-center justify-between mb-6 p-6">
							<div class="">
								<h3 class="text-primary-400 text-center">Assign Privilege</h3>
							</div>
							<Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none"
								:href="route('privilege')">
							Back
							</Link>
						</div>
						<div class="border-b-4 border-primary-400">
							<nav class="-mb-0.5 flex justify-center space-x-6 pt-5" aria-label="Tabs" role="tablist">
								<button v-for="(item, key) in tabs.listTabs" :key="item" @click="activeTabs = item.key;"
									type="button" :class="activeTabs == item.key ? 'active' : ''"
									class="hs-tab-active:text-white hs-tab-active:bg-primary-400 hs-tab-active:font-semibold text-primary-400 hover:bg-primary-400 hover:text-white border-t-2 border-x-2 border-primary-400 rounded-t-md py-2 px-14 inline-flex items-center gap-2 text-sm whitespace-nowrap"
									id="horizontal-alignment-item-1" data-hs-tab="#horizontal-alignment-1"
									aria-controls="horizontal-alignment-1" role="tab">
									{{ item.name }}
								</button>

							</nav>
						</div>
						<form v-show="activeTabs == 'user'" class=" py-5 px-7">
							<h3 class="text-primary-400 text-lg">Tambah Hak akses User</h3>
							<div class="my-10">
								<label for="input-label" class="block text-sm font-medium mb-2">Nama</label>
								<input type="text" id="input-label"
									class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm font-thin bg-slate-100"
									placeholder="Nama User">
							</div>

							<div class="border border-slate-300 rounded-md py-7 px-7">
								<p class="font-medium mb-4">Roles</p>
								<form class="grid grid-cols-1 md:grid-cols-2 gap-x-40 gap-y-5">
									<div v-for="item in roles" class="flex flex-wrap justify-between items-center">
										<div class="text-md">{{ item.role }}</div>
										<input id="roles_id" name="hs-checkbox-delete" type="checkbox"
											class="border-gray-400 rounded text-primary-400 focus:ring-primary-400 cursor-pointer"
											aria-describedby="hs-checkbox-delete-description" v-bind:value="item.id">
									</div>
								</form>
							</div>
							<button type="submit"
								className="my-5 px-12 py-1.5 font-semibold text-lg text-white bg-primary-300 rounded">
								Save
							</button>
						</form>
						<form v-show="activeTabs == 'modul'" class=" py-5 px-7">
							<h3 class="text-primary-400 text-lg">Tambah Hak akses Modul</h3>
							<div class="my-10">
								<label for="input-label" class="block text-sm font-medium mb-2">Nama</label>
								<input type="text" id="input-label"
									class="py-3 px-4 block w-full border-gray-200 rounded-md text-sm font-thin bg-slate-100"
									placeholder="Nama Modul">
							</div>

							<div class="border border-slate-300 rounded-md py-7 px-7">
								<p class="font-medium mb-4">Roles</p>
								<form class="grid grid-cols-1 md:grid-cols-2 gap-x-40 gap-y-5">
									<div v-for="item in roles" class="flex flex-wrap justify-between items-center">
										<div class="text-md">{{ item.role }}</div>
										<input id="roles_id" name="hs-checkbox-delete" type="checkbox"
											class="border-gray-400 rounded text-primary-400 focus:ring-primary-400 cursor-pointer"
											aria-describedby="hs-checkbox-delete-description" v-bind:value="item.id">
									</div>
								</form>
							</div>
							<button type="submit"
								className="my-5 px-12 py-1.5 font-semibold text-lg text-white bg-primary-300 rounded">
								Save
							</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</BreezeAuthenticatedLayout>
</template>