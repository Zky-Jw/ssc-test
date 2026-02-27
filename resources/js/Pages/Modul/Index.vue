<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import { defineProps, ref } from 'vue';

const props = defineProps({
	modul: Array,
});

const headers = ref([
	{ text: "Nama modul", value: "modul", sortable: true, fixed: true, width: 200 },
	{ text: "URL", value: "url", sortable: true },
	{ text: "#", value: "id" },
]);

const searchValue = ref("");

const form = useForm({ id: '' });
// console log modul with composition API

function destroy(id) {
	if (confirm("Are you sure you want to Delete")) {
		form.delete(route('modul.destroy', id));
	}
}
</script>

<template>
	<Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
			<template #header>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Create or just look for the Modul
				</h2>
			</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
					<div class="bg-white border-b border-gray-200">
						<div className="flex items-center justify-between py-7 px-10">
							<div class="">
								<h3 class="text-primary-400 text-center">Modul List</h3>
							</div>
							<Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none flex"
								:href="route('modul.create')">
							<Icon class="text-2xl pr-1" icon="uiw:plus" />
							Create Modul
							</Link>
						</div>
						<div class="flex flex-col">
							<div class="-m-1.5 overflow-x-auto">
								<div class="p-1.5 min-w-full inline-block align-middle">
									<div id="modul_list" class="overflow-hidden">
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
											<EasyDataTable buttons-pagination :headers="headers" :items="props.modul"
												class="w-full px-8" show-index alternating :search-value="searchValue">
												<template #item-id="item">
													<div
														class="text-center whitespace-nowrap text-sm font-medium text-primary-300">

														<button className=" py-2 text-sm rounded mr-2"
															:href="route('modul.edit', item.id)">
															<a :href="route('modul.edit', item.id)">
																<Icon class="text-2xl pr-1  hover:text-primary-100" icon="tabler:edit" />
															</a>
														</button>
														<button class=" py-2 text-sm rounded" @click="destroy(item.id)">
															<Icon class="text-2xl pr-1 hover:text-primary-100" icon="iconamoon:trash" />
														</button>
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