<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import { ref } from 'vue';

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

	<Head>
		<title>Cetak {{ document.template.name }} </title>
	</Head>
	<div class="page-1 break-inside-avoid">
		<div class="kop-header fixed top-0 right-0 px-10 py-10">
			<img class="object-scale-down w-28 h-20" src="../../../images/logokop-telu.png" alt="">
		</div>
		<div class="content py-32 pb-48 px-7">
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
								:value="route('document.creator-check', [ticket.id, ticket.person.creator.id])" tag="svg"
								:options="{ errorCorrectionLevel: 'Q', width: 80, }"></vue-qrcode>
							<img class="qrcode__image" src="../../../images/logo-base-telu.png" alt="SSC TUS" />
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
							<vue-qrcode :value="route('document.approval-check', [document.id, item.approved.token])" tag="svg"
								:options="{ errorCorrectionLevel: 'Q', width: 80, }"></vue-qrcode>
							<img class="qrcode__image" src="../../../images/logo-base-telu.png" alt="SSC TUS" />
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
		<div class="kop-footer fixed bottom-0">
			<!-- <div class="px-5 pb-3">
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
	<div class="page-1 break-inside-avoid">
		<div class="kop-header fixed top-0 right-0 px-10 py-10">
			<img class="object-scale-down w-28 h-20" src="../../../images/logokop-telu.png" alt="">
		</div>
		<div class="content py-32 pb-48 px-7">
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
					</tbody>
				</table>
			</div>
		</div>
		<div class="kop-footer fixed bottom-0">
			<!-- <div class="px-5 pb-3">
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
</template>

<style>
@page {
	margin: 0mm
}

.page-1 {
	page-break-before: always;
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

.qrcode {
	display: inline-block;
	font-size: 0;
	margin-bottom: 0;
	position: relative;
}

.qrcode__image {
	background-color: #fff;
	border: 0.25rem solid #fff;
	border-radius: 0.25rem;
	box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.25);
	height: 25%;
	width: 20%;
	left: 50%;
	top: 50%;
	overflow: hidden;
	position: absolute;
	transform: translate(-50%, -50%);
}
</style>
