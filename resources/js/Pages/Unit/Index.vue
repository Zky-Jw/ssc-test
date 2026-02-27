<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import { defineProps, ref } from 'vue';
import ButtonAction from '@/Components/ButtonAction.vue';
import ButtonCreate from '@/Components/ButtonCreate.vue';

const props = defineProps({
	unit: Array,
});

const pageTitle = ref('Unit');

const headers = ref([
	{ text: "Nama unit", value: "unit", sortable: true, fixed: true, width: 200 },
	{ text: "Action", value: "id" },
]);

const searchValue = ref("");

const form = useForm({ id: '' });
</script>

<template>
	<Head title="Dashboard" />
    <BreezeAuthenticatedLayout :page-title="pageTitle">
			<template #header>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Create or just look for the unit
				</h2>
			</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
					<div class="bg-white border-b border-gray-200">
						<div className="flex items-center justify-between py-7 px-10">
							<div class="">
								<h3 class="text-primary-400 text-center">Unit List</h3>
							</div>
							<ButtonCreate button-text="Create Unit" create-route="unit.create"></ButtonCreate>
						</div>
						<div class="flex flex-col">
							<div class="-m-1.5 overflow-x-auto">
								<div class="p-1.5 min-w-full inline-block align-middle">
									<div id="unit_list" class="overflow-hidden">
										<div class="min-w-full divide-y divide-gray-300">
											<div
												class="card-header block md:flex justify-between items-center px-10 py-5 border-b-[1px] border-neutral-200">
												<div class="flex items-center">
													<p class="text-base">Pencarian</p>
													<input v-model="searchValue" type="text"
														class="search py-1 px-5 ml-2 block w-full border-neutral-500 rounded-md text-sm "
														placeholder="Search">
												</div>
											</div>
											<EasyDataTable buttons-pagination :headers="headers" :items="props.unit"
												class="w-full px-8" show-index alternating :search-value="searchValue">
												<template #item-id="item">
													<div
														class="whitespace-nowrap text-sm font-medium text-primary-300">

														<ButtonAction :item="item" edit-route="unit.edit" :form="form" delete-route="unit.destroy" />
													</div>
												</template>
												<template #item-href="item">
													<td class="py-2">
														<a :href="item.href"
															class="py-2 px-2 inline-flex justify-center items-center gap-2 text-xs rounded-md border border-transparent font-semibold bg-primary-400 text-white hover:bg-primary-500">
															Lihat Detail
														</a>
													</td>
												</template>
											</EasyDataTable>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</BreezeAuthenticatedLayout>
</template>
