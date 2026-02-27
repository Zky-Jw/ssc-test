<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import { defineProps, ref } from 'vue';
import ButtonAction from '@/Components/ButtonAction.vue';

const props = defineProps({
	document: Array,
});

const pageTitle = ref('Document');

const data = ref(props.document.map((item) => ({
	...item,
	ticketNumber: item.ticketNumber ?? '',
	creator: item.content[1].value ?? '',
	template: item.template.name ?? '',
	approval: item.approval ?? '',
	id: item.id,
})));

const form = useForm({ id: '' });

const headers = ref([
	{ text: "Nomer Tiket", value: "ticketNumber", sortable: true, fixed: true, width: 100 },
	{ text: "Nama Pengaju", value: "creator", sortable: true },
	{ text: "Nama Surat", value: "template" },
	{ text: "Tanda Tangan", value: "approval", width: "200" },
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
								<h3 class="text-primary-400 text-center">Document List</h3>
							</div>
							<!-- <Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none flex"
								:href="route('document.create')">
							<Icon class="text-2xl pr-1" icon="uiw:plus" />
							Create Template
							</Link> -->
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
											<EasyDataTable buttons-pagination :headers="headers" :items="data"
												class="w-full px-8" show-index alternating :search-value="searchValue">
												<template #item-approval="item">
													<td class="font-regular" :class="item">
														<ol>
															<li v-for="(item, index) in item.approval" :key="item.id">
																<div class="flex">
																	<p>
																		{{ index + 1 }}. {{ item.name }}
																	</p>
																	<Icon v-if="item.approved" class="text-green-500 text-2xl" aria-label="approved"
																		icon="bx:check-double"></Icon>
																</div>
															</li>
														</ol>
													</td>
												</template>
												<template #item-id="item">
													<div
														class="whitespace-nowrap text-sm font-medium text-primary-300">

														<ButtonAction :item="item" :form="form"
															delete-route="document.destroy" print-route="document.print"
															show-route="document.show" />

														<!-- <button class=" py-2 text-sm rounded mr-2"
															@click="destroy(item._id)">
															<Icon class="text-2xl pr-1 hover:text-primary-100"
																icon="iconamoon:trash" />
														</button>
														<button className=" py-2 text-sm rounded mr-2">
															<a :href="route('document.show', item._id)">
																<Icon class="text-2xl pr-1  hover:text-primary-100"
																	icon="lucide:file-signature" />
															</a>
														</button>
														<button className=" py-2 text-sm rounded">
															<a :href="route('document.print', item._id)">
																<Icon class="text-2xl pr-1  hover:text-primary-100"
																	icon="streamline:computer-printer-scan-device-electronics-printer-print-computer" />
															</a>
														</button> -->
													</div>
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
<style>
p {
	font-size: 12px;
}
</style>
