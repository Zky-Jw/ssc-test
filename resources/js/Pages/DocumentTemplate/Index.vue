<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ButtonAction from '@/Components/ButtonAction.vue';
import ButtonCreate from '@/Components/ButtonCreate.vue';

import { defineProps, ref } from 'vue';

const props = defineProps({
	template: Array,
});

const pageTitle = ref('Document Template');

const form = useForm({ id: '' });
// console log template with composition API

const headers = ref([
	{ text: "Nama Template", value: "title", sortable: true, fixed: true, width: 200 },
	{ text: "Action", value: "id" },
]);


const searchValue = ref("");

</script>

<template>
	<Head title="Dashboard" />
	<BreezeAuthenticatedLayout :page-title="pageTitle">
		<template #header>
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				Create or just look for the template
			</h2>
		</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
					<div class="bg-white border-b border-gray-200">
						<div className="flex items-center justify-between py-7 px-10">
							<div class="">
								<h3 class="text-primary-400 text-center">Document Template List</h3>
							</div>
							<ButtonCreate button-text="Create Template" create-route="document-template.create"></ButtonCreate>
						</div>
						<div class="flex flex-col">
							<div class="-m-1.5 overflow-x-auto">
								<div class="p-1.5 min-w-full inline-block align-middle">
									<div id="template_list" class="overflow-hidden">
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
											<EasyDataTable buttons-pagination :headers="headers" :items="props.template" class="w-full px-8"
												show-index alternating :search-value="searchValue">
												<template #item-id="item">
													<div class="twhitespace-nowrap text-sm font-medium text-primary-300">
														<ButtonAction :item="item" edit-route="document-template.edit" :form="form"
															delete-route="document-template.destroy" />
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