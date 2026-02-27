<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import { defineProps, ref } from 'vue';

const props = defineProps({
	document: Array,
	ticket: Array,
});
const document = props.document;
let approval = props.document.approval;
const content = props.document.content;
const enclosure = props.document.enclosure;

// remove the approval array where the approved is not empty
let listApproval = approval.filter((item) => item.approved === '');

const form = useForm({
	approvedby: '',
});

const submit = () => {
	if (form.approvedby === '') {
		alert('Pilih penandatangan');
		return;
	}
	form.post(route('document.approve', props.document.id), {
		onSuccess: () => {
			window.location.reload();
		},
	});
};

</script>

<template>

	<Head title="Dashboard" />
	<BreezeAuthenticatedLayout>
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
								<h3 class="text-primary-400 text-center">Approval Surat</h3>
							</div>
						</div>
						<div class="flex flex-wrap">
							<div class="-m-1.5 overflow-x-auto">
								<div class="p-1.5 min-w-full inline-block align-middle">
									<div class="content-field">
									</div>
									<div class="py-2 px-10 mb-4 approval-field">
										<div class="flex flex-col bg-white border shadow-sm rounded-sm">
											<!-- Halaman Utama -->
											<div class="page-1 p-6">
												<div class="relative h-full w-full">
													<div class="kop-header absolute top-6 right-5">
														<img class="object-scale-down w-28 h-20" src="../../../images/logokop-telu.png" alt="" />
													</div>
													<p class="text-xs text-center italic m-1  text-gray-400">--- page 1 ---
													</p>
													<div class="content py-24 pb-48 px-5 border-2">
														<div class="text-center font-serif mb-7">
															<p class="font-semibold text-sm">{{ document.template.name
																}}</p>
															<p class="text-xs font-normal">{{ content[0].value }}</p>
														</div>
														<p class="text-xs font-normal mb-5">Bersamaan dengan surat
															ini saya,</p>
														<div class="mb-5">
															<table class="table-auto">
																<tbody>
																	<tr v-for="item in content" :key="item">
																		<td class="text-xs font-normal" v-if="item.name !== 'Nomor surat'">{{
																			item.name }}</td>
																		<td class="pl-10" v-if="item.name !== 'Nomor surat'">:
																		</td>
																		<td class="text-xs font-normal mb-5 pl-10" v-if="item.name !== 'Nomor surat'">{{
																			item.value }}
																		</td>
																	</tr>
																	<tr class="">
																		<td class="py-5"></td>
																	</tr>
																</tbody>
															</table>
															<p class="text-xs font-normal mb-10">
																Dengan ini mengajukan {{ document.template.name }}
																melalui SSC dengan nomor tiket {{
																	ticket.ticketNumber }},
																serta detail yang terlampir pada halaman
																selanjutnya.
																<br>Demikian permohonan ini saya buat dengan
																sesungguhnya, dan segala akibat yang
																ditimbulkan oleh
																permohonan ini sepenuhnya menjadi tanggung jawab
																saya.
															</p>
															<p class="text-xs font-normal mb-5">Surabaya, {{
																$dateFormatIndo(new Date().toLocaleDateString()) }}</p>
															<div class="flex flex-wrap">
																<div class="basis-4/12 text-center mb-2">
																	<p class="text-xs font-normal mb-2 mt-2">Pengaju surat,
																	</p>
																	<figure class="qrcode"> <vue-qrcode
																			:value="route('document.creator-check', [ticket.id, ticket.person.creator.id])"
																			tag="svg" :options="{ errorCorrectionLevel: 'Q', width: 80, }"></vue-qrcode>
																		<img class="qrcode__image" src="../../../images/logo-base.png" alt="SSC ITTS" />
																	</figure>
																	<p class="text-xs font-bold underline ml-2">
																		{{ $makeShortName(ticket.person.creator.name) }}</p>
																	<p class="text-xs font-normal mb-2 ml-2">
																		NIM. {{ ticket.person.creator.id }}</p>
																</div>
																<div class="basis-4/12 text-center" v-for="item in approval" :key="item">
																	<p class="text-xs font-normal mt-2">
																		{{ item.position }}</p>
																	<figure class="qrcode my-2" v-if="item.approved !== ''">
																		<vue-qrcode
																			:value="route('document.approval-check', [document.id, item.approved.token])"
																			tag="svg" :options="{ errorCorrectionLevel: 'Q', width: 80, }"></vue-qrcode>
																		<img class="qrcode__image" src="../../../images/logo-base.png" alt="SSC ITTS" />
																	</figure>
																	<div v-else class="mb-20">
																		<div class="">&nbsp;</div>
																	</div>
																	<p class="text-xs font-bold underline">
																		{{ $makeShortName(item.name) }}</p>
																	<p class="text-xs font-normal">
																		NIP. {{ item.employeeid }}</p>
																</div>
															</div>
														</div>
													</div>
													<div class="kop-footer absolute bottom-0">
														<!-- <div class="pl-4 pb-3">
															<p class="font-kop-institut">Telkom University
																SURABAYA</p>
															<p class="text-xs font-thin">Jl. Ketintang No. 156</p>
															<p class="text-xs font-medium">Kota Surabaya, Jawa Timur
																60231</p>
															<p class="text-xs font-medium">Telp: (031) 8280800;
																(081)13980800</p>
															<p class="text-xs font-medium font-kop-link"></p>
														</div> -->

														<div class="w-full p-0 m-0">
															<img class="" src="../../../images/footer-surat.png" alt="" />
														</div>
													</div>
												</div>
											</div>
											<!-- Halaman Lampiran -->
											<div class="page-1 p-6">
												<div class="relative h-full w-full">
													<div class="kop-header absolute top-6 right-5">
														<img class="object-scale-down w-28 h-20" src="../../../images/logokop-telu.png" alt="" />
													</div>
													<p class="text-xs text-center italic m-1  text-gray-400">--- page 2 ---
													</p>
													<div class="content py-24 pb-48 px-5 border-2">
														<p class="text-sm font-bold mb-5">Lampiran</p>
														<p class="text-xs font-normal mb-5">Berikut detail pengajuan
															{{ document.template.name }}</p>
														<div class="mb-5">
															<table class="table-auto">
																<tbody>
																	<tr v-for="item in enclosure" :key="item">
																		<td class="text-xs font-normal">{{ item.name }}</td>
																		<td class="pl-10">:</td>
																		<td class="text-xs font-normal mb-5 pl-10">{{
																			$searchWord(item.name ?? '', 'Tanggal') ?
																				$dateFormatIndo(item.value) : item.value }}</td>
																	</tr>
																	<tr class="">
																		<td class="py-10"></td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="kop-footer absolute bottom-0">
														<!-- <div class="pl-4 pb-3">
															<p class="font-kop-institut">Telkom University
																SURABAYA</p>
															<p class="text-xs font-thin">Jl. Ketintang No. 156</p>
															<p class="text-xs font-medium">Kota Surabaya, Jawa Timur
																60231</p>
															<p class="text-xs font-medium">Telp: (031) 8280800;
																(081)13980800</p>
															<p class="text-xs font-medium font-kop-link"></p>
														</div> -->

														<div class="w-full p-0 m-0">
															<img class="" src="../../../images/footer-surat.png" alt="" />
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="my-4" v-if="listApproval.length > 0">
											<form name="createForm" @submit.prevent="submit">
												<BreezeSearchSelect class="mt-1 mb-2 block" name="persons" id="person" v-model="form.approvedby"
													:option="listApproval" :custom-label="nameWithLang" placeholder="Cari Penandatangan"
													label="name" track-by="name">
												</BreezeSearchSelect>
												<!-- <button type="button"
													class="text-sm py-2 px-3 w-3/12 mr-10 inline-flex justify-center items-center gap-2 rounded font-semibold border bg-white border-primary-400 text-primary-400 hover:border-primary-400 hover:bg-primary-400 hover:text-white ">
													Reject
												</button> -->
												<button type="submit"
													class="text-sm py-2 px-3 w-full inline-flex justify-center items-center gap-2 rounded border border-primary-400 bg-primary-400 font-semibold text-white hover:bg-white hover:border-primary-400 hover:text-primary-400">
													Approve
												</button>
											</form>
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
.ck-editor__editable {
	min-height: 200px;
}

.font-kop-institut {
	font-size: 0.75rem;
	line-height: 1rem;
	color: #e93f3d;
	font-weight: 700;
}

.font-kop-link {
	font-size: 0.75rem;
	line-height: 1rem;
	color: #0507ce;
	text-decoration: underline;
	font-weight: 500;
}
</style>
