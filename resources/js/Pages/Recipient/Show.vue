<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';


import { onMounted } from 'vue';

defineProps({
	recipient: Array,
});

const form = useForm({ id: '' });
// console log recipient with composition API

function destroy(id) {
	if (confirm("Are you sure you want to Delete")) {
		form.delete(route('privilege.destroy', id));
	}
}
</script>

<template>
	<Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
			<template #header>
				<h2 class="font-semibold text-xl text-gray-800 leading-tight">
					Create or just look for the recipient
				</h2>
			</template>
		<div class="">
			<div class="mx-auto sm:px-6 lg:px-3">
				<div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
					<div class="bg-white border-b border-gray-200">
						<div className="flex items-center justify-between mb-8 py-7 px-10">
							<div class="">
								<h3 class="text-primary-400 text-center">Privilege List</h3>
							</div>
							<Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none flex"
								:href="route('privilege.create')">
							<Icon class="text-2xl pr-1" icon="uiw:plus" />
							Create Previlege
							</Link>
						</div>
						<div class="flex flex-col">
							<div class="-m-1.5 overflow-x-auto">
								<div class="p-1.5 min-w-full inline-block align-middle">
									<div class="overflow-hidden">
										<table class="min-w-full divide-y divide-gray-300">
											<thead>
												<tr>
													<th scope="col"
														class="px-3 py-4 text-center text-sm font-medium text-primary-400">
														#</th>
													<th scope="col"
														class="px-3 py-4 text-sm font-medium text-primary-400">
														Nama Recipients</th>
													<th scope="col"
														class="px-3 py-4 text-center text-sm font-medium text-primary-400">
														Action</th>
												</tr>
											</thead>
											<tbody class="divide-y divide-gray-300 ">
												<tr v-for="(post, key) in recipient" :key="post">
													<td
														class="px-3 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 ">
														{{ key + 1 }}</td>
													<td
														class="px-3 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 ">
														{{ post.recipient }}</td>
													<td
														class="px-3 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 ">
														<Link tabIndex="1"
															className="px-4 py-2 text-sm text-white bg-green-600 rounded mr-2"
															:href="route('privilege.show', post.id)">
															Show
														</Link>
														<Link tabIndex="2"
															className="px-4 py-2 text-sm text-white bg-blue-500 rounded mr-2"
															:href="route('privilege.edit', post.id)">
															Edit
														</Link>
														<button tabIndex="3"
															class="px-4 py-2 text-sm text-white bg-red-500 rounded"
															@click="destroy(post.id)">
															Delete
														</button>
													</td>
												
												</tr>
											</tbody>
										</table>
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