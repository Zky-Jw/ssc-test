<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import { ref, defineProps } from 'vue';
import defaultPhoto from "../../../images/avatar2.png"
import axios from 'axios';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { component as CKEditor } from '@ckeditor/ckeditor5-vue';

/**
 * Initializes the editor and its configuration.
 *
 * @example
 * const editor = ClassicEditor;
 * const editorConfig = ref({
 *   toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
 * });
 *
 * @returns {void}
 */
const editor = ClassicEditor;
const editorConfig = ref({
	toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
});

/**
 * Initializes reactive variables based on the provided ticket object.
 *
 * @param {Array} ticket - The ticket object containing ticket information.
 * @returns {void}
 */
const props = defineProps({
	ticket: Array,
	creatorData: Object,
});
/**
 * Vue component for defining an object called `creatorData`.
 *
 *
 * @returns {Object} An object with the properties `id` and `name`, which contain the values of the `content` attributes of the `<meta>` elements.
 */
const creatorData = {
	'id': props.creatorData.id,
	'name': props.creatorData.name,
    'photo' : props.creatorData.photo
};


const arrProgress = ref(
	props.ticket.progress
		.filter(progress => !['progress-chat', 'content-original'].includes(progress.head))
		.reverse()
);

const arrProgressChat = ref(props.ticket.progress.filter(progress => progress.head === 'progress-chat'));

const originalProgressChat = ref(props.ticket.progress.filter(progress => progress.head === 'content-original'));

const prependProgressChat = (ticketId, content) => {
	arrProgressChat.value.unshift({
		ticketId,
		head: 'progress-chat',
		content,
		attachment: props.ticket.attachment.name || '',
		by: {
			name: props.ticket.person['creator']['name'],
			photo: props.ticket.person['creator']['photo'],
			id: props.ticket.person['creator']['id'],
			as: 'Pemilik Tiket'
		},
		timestamp: props.ticket.created['createdat'],
	});
};

if (originalProgressChat.value.length > 0) {
	prependProgressChat(props.ticket.id, originalProgressChat.value[0].content);
} else {
	prependProgressChat(props.ticket._id, props.ticket.content);
}
/**
 * Retrieves the milestone status, class, or code based on the last progress head.
 *
 * @param {string} ret - The desired return value ('status', 'class', or 'code').
 * @returns {string|number} - The status value, class, or code based on the value of `ret`.
 */
const getMilestone = (ret) => {
	const progress = ref(props.ticket.progress);
	const lastHead = progress.value[progress.value.length - 1].head;

	const statusMap = {
		'on-hold': {
			value: 'On Hold',
			class: 'bg-yellow-50  text-yellow-700  ring-yellow-600/10',
			code: 8,
		},
		'created': {
			value: 'Created',
			class: 'bg-red-50  text-red-700  ring-red-600/10',
			code: 2,
		},
		'progress': {
			value: 'Open',
			class: 'bg-red-50  text-red-700  ring-red-600/10',
			code: 3,
		},
		'content-original': {
			value: 'Open',
			class: 'bg-red-50  text-red-700  ring-red-600/10',
			code: 3,
		},
		'progress-chat': {
			value: 'Open',
			class: 'bg-red-50  text-red-700  ring-red-600/10',
			code: 3,
		},
		'document-generated': {
			value: 'Document Generated',
			class: 'bg-blue-50  text-blue-700  ring-blue-600/10',
			code: 4,
		},
		'closed': {
			value: 'Closed',
			class: 'bg-green-50  text-green-700  ring-green-600/10',
			code: 5,
		},
		'default': {
			value: 'Open',
			class: 'bg-red-50  text-red-700  ring-red-600/10',
			code: 1,
		},
	};
	const status = statusMap[lastHead] || statusMap['default'];

	// The code snippet is a switch statement that returns different values based on the value of the `ret` variable.

	switch (ret) {
		case 'status':
			return status.value;
		case 'class':
			return status.class;
		case 'code':
			return status.code;
		default:
			return status.value;
	}
}

/**
 * Triggers the file selection dialog by programmatically clicking on the hidden file input field.
 */
const chooseFiles = () => {
	document.getElementById("attachment-input").click();
};

/**
 * Displays the selected file names in the UI.
 *
 * @returns {string} The selected file names joined with a comma separator.
 */
const showFiles = () => {
	const fileContainer = document.getElementById("file-container");
	fileContainer.classList.remove("hidden");

	const input = document.getElementById("attachment-input");
	const output = document.getElementById("files-name");
	const fileNames = [...input.files].map((file) => file.name).join(", ");

	// get all inputed file as array then push to form.attachment
	form.attachment = [...input.files];
	// form.attachment = input.files[0];
	// console.log(form.attachment);
	return (output.textContent = fileNames);
};

/**
 * Handles the form submission.
 * Sends a POST request to the server using axios and updates the UI based on the response.
 *
 * @param {Object} form - An object containing the form data, including the message content and attachment files.
 * @param {Object} ticket - An object containing the ticket data, including the ticket ID.
 */
const submit = () => {
	axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
	axios
		.post(route('ticket.store-progress', ticket.value.id), form)
		.then((res) => {
			if (res.status === 500) {
				// Scroll to the bottom of the chat box
				const chatBox = document.getElementById('chat-box');
				chatBox.scrollTop = chatBox.scrollHeight;
				// Show error message
				alert('Error: ' + res.data.error);
			} else if (res.status === 200) {
				const attachment = [];
				if (form.attachment !== null) {
					for (let i = 0; i < form.attachment.length; i++) {
						console.log(res.data.filename[0].name);
						attachment.push({
							name: res.data.filename[0].name,
							url: `/public/file_upload/${ticket.ticketNumber}/${res.data.filename[0].name}`,
						});
					}
				}
				arrProgressChat.value.push({
					ticketId: ticket.value.id,
					head: 'progress-chat',
					content: form.content,
					attachment: attachment || '',
					by: {
						// name use userdata which is login now
						name: creatorData.name,
						id: creatorData.id,
						as: res.data.as || ' ',
					},
					timestamp: new Date(),
				});
				// Reset form and hide file container
				form.reset();
				document.getElementById('file-container').classList.add('hidden');
				// Scroll to the bottom of the chat box
				const chatBox = document.getElementById('chat-box');
				chatBox.scrollTop = chatBox.scrollHeight;
			}
		});
};

const form = useForm({
	head: 'progress-chat',
	content: '',
	attachment: null,
});


</script>

<template>

	<Head title="Student Service Center" />
	<BaseLayout>
		<section class="py-12">
			<div class="container mx-auto px-4 md:px-6 lg:px-14">
				<h2 class="text-center text-xl md:text-2xl">Detail Pengajuan Tiket</h2>
				<div class="card my-4 md:my-7 flex flex-col bg-white border-[1px] border-neutral-200 shadow-lg rounded-lg">
					<div class="card-header border-b-[1px] border-neutral-200 py-5 px-10">
						<h3 class="font-bold text-primary-400">Timeline Tiket</h3>
					</div>
					<div class="card-body py-10">
						<div class="overflow-x-auto flex justify-normal xl:justify-center wrapper-guide">
							<!-- step 1 -->
							<div class="h-full">
								<div class="text-center flex flex-col justify-center w-[120px] sm:w-[150px]">
									<div class="flex items-center justify-center mb-3">
										<hr class="border-2 border-none w-full">
										<div v-if="getMilestone('code') > 0"
											class="bg-primary-400 p-1 rounded-full w-10 h-10 sm:w-14 sm:h-14 flex justify-center items-center">
											<Icon icon="bi:check" class="text-white text-3xl sm:text-5xl" />
										</div>
										<div v-else
											class="bg-neutral-400 p-1 rounded-full w-10 h-10 sm:w-14 sm:h-14 flex justify-center items-center">
											<Icon icon="bi:check" class="text-white text-3xl sm:text-5xl" />
										</div>
										<hr class="border-2 border-primary-400 w-full">
									</div>
									<p class="text-xs sm:text-sm">Input Tiket</p>
								</div>
							</div>
							<div>
								<div
									class="w-[40px] sm:w-[60px] lg:w-[70px] xl:w-[80px] h-14 flex justify-center items-center relative">
									<hr v-if="getMilestone('code') > 0"
										class="border-2 border-primary-400 w-[120px] sm:w-[150px] absolute">
									<hr v-else class="border-2 border-neutral-400 w-[120px] sm:w-[150px] absolute">
								</div>
							</div>

							<div class="h-full">
								<div class="text-center flex flex-col justify-center w-[150px]">
									<div class="flex items-center justify-center mb-3">
										<hr class="border-2 w-full"
											:class="getMilestone('code') > 2 ? 'border-primary-400' : 'border-neutral-400'">
										<div v-if="getMilestone('code') > 2"
											class="bg-primary-400 p-1 rounded-full w-14 h-14 flex justify-center items-center">
											<Icon icon="bi:check" class="text-white text-5xl" />
										</div>
										<div v-else
											class="bg-neutral-400 p-1 rounded-full w-14 h-14 flex justify-center items-center">
											<Icon icon="bi:check" class="text-white text-5xl" />
										</div>
										<hr class="border-2 w-full"
											:class="getMilestone('code') > 2 ? 'border-primary-400' : 'border-neutral-400'">
									</div>
									<p class="text-sm">Proses</p>
								</div>
							</div>
							<div>
								<div
									class="w-[60px] lg:w-[70px] xl:w-[80px] h-14 flex justify-center items-center relative">
									<hr v-if="getMilestone('code') > 2"
										class="border-2 border-primary-400 w-[150px] absolute">
									<hr v-else class="border-2 border-neutral-400 w-[150px] absolute">
								</div>
							</div>
							<div class="h-full">
								<div class="text-center flex flex-col justify-center w-[150px]">
									<div class="flex items-center justify-center mb-3">
										<hr class="border-2 w-full"
											:class="getMilestone('code') > 2 ? 'border-primary-400' : 'border-neutral-400'">
										<div v-if="getMilestone('code') > 3"
											class="bg-primary-400 p-1 rounded-full w-14 h-14 flex justify-center items-center">
											<Icon icon="bi:check" class="text-white text-5xl" />
										</div>
										<div v-else
											class="bg-neutral-400 p-1 rounded-full w-14 h-14 flex justify-center items-center">
											<Icon icon="bi:check" class="text-white text-5xl" />
										</div>
										<hr class="border-2 w-full"
											:class="getMilestone('code') > 3 ? 'border-primary-400' : 'border-neutral-400'">
									</div>
									<p class="text-sm">Berkas Dibuat</p>
								</div>
							</div>
							<div>
								<div
									class="w-[60px] lg:w-[70px] xl:w-[80px] h-14 flex justify-center items-center relative">
									<hr v-if="getMilestone('code') > 3"
										class="border-2 border-primary-400 w-[150px] absolute">
									<hr v-else class="border-2 border-neutral-400 w-[150px] absolute">
								</div>
							</div>
							<div class="h-full">
								<div class="text-center flex flex-col justify-center w-[150px]">
									<div class="flex items-center justify-center mb-3">
										<hr class="border-2 w-full"
											:class="getMilestone('code') > 3 ? 'border-primary-400' : 'border-neutral-400'">
										<div v-if="getMilestone('code') > 4"
											class="bg-primary-400 p-1 rounded-full w-14 h-14 flex justify-center items-center">
											<Icon icon="bi:check" class="text-white text-5xl" />
										</div>
										<div v-else
											class="bg-neutral-400 p-1 rounded-full w-14 h-14 flex justify-center items-center">
											<Icon icon="bi:check" class="text-white text-5xl" />
										</div>
										<hr class="border-2 border-none w-full">
									</div>
									<p class="text-sm">Tiket Selesai</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
					<div class="col-span-1 lg:col-span-8">
						<div class="card flex flex-col bg-white border-[1px] border-neutral-200 shadow-lg rounded-lg">
							<div class="card-header border-b-[1px] border-neutral-200 py-3 md:py-5 px-4 md:px-10">
								<h3 class="font-bold text-primary-400 text-lg md:text-xl">Respon Tiket</h3>
							</div>
							<div class="card-body py-6 md:py-10 pr-3 pl-0 xl:pr-10 xl:pl-3">
								<div>
									<!-- Start Progress foreach -->
									<div id="progress-box" v-for="(prog, i) in arrProgress" :key="i"
										class="relative pl-8 sm:pl-16 py-6 group">
										<div
											class="flex flex-col sm:flex-row items-start mb-1 group-last:before:hidden before:absolute before:left-2 sm:before:left-0 before:h-full before:px-px before:bg-primary-400 sm:before:ml-[2rem] before:self-start before:-translate-x-1/2 before:translate-y-3 after:absolute after:left-2 sm:after:left-0 after:w-2 after:h-2 after:bg-primary-400 after:border-2 after:box-content after:border-primary-400 after:rounded-full sm:after:ml-[2rem] after:-translate-x-1/2 after:translate-y-1.5">
											<div class="grid grid-cols-4 items-center w-full">
												<div class="inline-flex col-span-3 align-middle text-lg font-bold text-primary-400"
													v-html="prog.content.split(',')[0]"></div>
												<div class="text-sm self-center font-medium ml-auto text-gray-500"
													v-html="$toTimeAgo(prog.timestamp)"></div>
											</div>
										</div>
										<!-- Box inside -->
										<div
											class="hs-accordion-group card bg-white border-[1px] border-neutral-200 rounded-lg shadow-lg">
											<div class="hs-accordion active">
												<button :id="prog.head === 'progress' ? 'press-chat' : ''"
													:class="{ 'hs-accordion-toggle': prog.head === 'progress', }"
													class="border-b-[1px] border-neutral-200 py-3 px-5 inline-flex items-center justify-between gap-x-3 w-full text-left"
													aria-controls="">
													<p class="text-base" v-html="prog.content.split(',')[1]"></p>
													<Icon :class="{
											'block': prog.head === 'progress',
											'hidden': prog.head !== 'progress'
										}" class="hs-accordion-active:block text-2xl font-bold ml-auto hidden text-primary-400"
														icon="tabler:chevron-up" />
													<Icon :class="{
											'block': prog.head === 'progress',
											'hidden': prog.head !== 'progress'
										}" class="hs-accordion-active:hidden text-2xl font-bold ml-auto block text-primary-400"
														icon="tabler:chevron-down" />
												</button>
												<!-- :class="{ 'hidden': close === true, 'hidden': ticket.status === 'closed' }" -->
												<div v-if="prog.head === 'progress'"
													class="card-body hs-accordion-content w-full overflow-hidden transition-[height] duration-300">
													<div id="chat-box">
														<!-- Start Chat Foreach -->
														<div v-for="(chat, j) in arrProgressChat" :key="j"
															class="flex flex-col sm:flex-row gap-y-3 w-full h-full rounded-lg px-4 sm:px-6 py-3 sm:py-4">
															<div class="flex items-start gap-3">
																<img class="inline-block h-10 w-10 md:h-[3rem] md:w-[3rem] object-cover rounded-full"
																	:src="chat.by.photo || defaultPhoto"
																	alt="Image Description">
																<div class="w-full">
																	<div>
																		<div class="grid grid-cols-12 gap-2 sm:gap-4">
																			<div class="col-span-12 sm:col-span-8 flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
																				<span class="font-semibold text-gray-800 text-base">{{ $makeShortName(chat.by.name) }}</span>
																				<span class="inline-flex items-center justify-center py-1 px-4 rounded-full text-sm font-medium bg-red-100 text-primary-300">
																					{{ chat.by.as }}
																				</span>
																			</div>
																			<div class="col-span-12 sm:col-span-4 text-sm self-center font-medium text-gray-500">
																				<span v-html="$toTimeAgo(chat.timestamp)"></span>
																			</div>
																		</div>
																		<p class="mt-1 text-sm sm:text-base mt-3" v-html="chat.content"></p>
																		<div v-if="chat.attachment !== ''" class="bg-gray-100 rounded py-2 mt-2">
																			<ul>
																				<li v-for="(fileArr, k) in chat.attachment" :key="k">
																					<a :href="route('cdn-files', ['attachment-chat', ticket.ticketNumber, fileArr.name])"
																						target="_blank"
																						class="text-gray-600 font-normal inline-flex items-center hover:underline text-xs sm:text-sm">
																						<Icon class="ml-2" icon="ant-design:paper-clip-outlined" />
																						<span class="text-xs sm:text-sm" v-html="fileArr.name"></span>
																					</a>
																				</li>
																			</ul>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<!-- End Chat Foreach -->
														<form name="chatForm" id="chatForm" @submit.prevent="submit"
															class="px-5 py-3"
															:class="{ 'hidden': ticket.status === 'closed' }"
															enctype="multipart/form-data">
															<div class="grid grid-cols-12 gap-2 md:gap-4 items-center">
																<div class="col-span-12 md:col-span-8">
																	<input type="text"
																		class="bg-gray-200 py-2 px-3 block w-full border-gray-200 rounded-md text-sm focus:border-primary-500 focus:ring-primary-500 focus:bg-gray-100 focus:outline-none"
																		placeholder="isi teks" v-model="form.content">
																	<input type="file" class="hidden"
																		name="attachment-input" id="attachment-input"
																		multiple @change="showFiles()">
																	<input type="text" class="hidden" id="head"
																		v-model="form.head">
																</div>
																<div class="col-span-6 md:col-span-1">
																	<button type="button"
																		class="w-full p-2.5 hover:bg-gray-200 font-bold rounded inline-flex items-center justify-center"
																		@click="chooseFiles()">
																		<Icon class="text-xl"
																			icon="ant-design:paper-clip-outlined" />
																	</button>
																</div>
																<div class="col-span-6 md:col-span-3">
																	<button type="submit"
																		class="w-full py-2 px-2 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-primary-400 text-white hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-2 transition-all text-sm md:text-base">
																		Kirim
																	</button>
																</div>
																<div class="col-span-12 hidden" id="file-container">
																	<div class="bg-gray-100 text-gray-700 px-3 py-2 rounded-sm"
																		role="alert">
																		<p class="text-sm italic text-gray-400"
																			id="files-name"></p>
																	</div>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										<!-- End box inside -->
									</div>
									<!-- End Progress Foreach -->
								</div>
							</div>
						</div>
					</div>
					<!-- Tiket Detail -->
					<div class="col-span-1 lg:col-span-4">
						<div class="card flex flex-col bg-white border-[1px] border-neutral-200 shadow-lg rounded-lg">
							<div class="card-header border-b-[1px] border-neutral-200 py-3 md:py-5 px-4 md:px-7 xl:px-10">
								<h3 class="font-bold text-primary-400 text-lg md:text-xl">Data Tiket</h3>
							</div>
							<div class="card-body py-6 md:py-8 px-4 md:px-5 xl:px-8">
								<ul>
									<li class="mb-4 md:mb-7">
										<p class="font-semibold text-primary-400 text-sm md:text-base mb-1 md:mb-2">Nomor Tiket</p>
										<span
											class="inline-flex font-semibold items-center gap-1.5 py-1.5 rounded-full text-sm md:text-md"
											v-html="ticket.ticketNumber">
										</span>
									</li>
									<li class="mb-4 md:mb-7" id="status-box">
										<p class="font-semibold text-primary-400 text-sm md:text-base mb-1 md:mb-2">Status Tiket</p>
										<div class="flex flex-col md:flex-row items-start md:items-center gap-2">
											<span id="status-ticket"
												class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"
												:class="getMilestone('class')" v-html="getMilestone('value')">
											</span>
											<button v-if="getMilestone('code') > 3"
												class="inline-flex items-center rounded-md px-2 py-1 text-xs shadow-sm ring-1 ring-inset bg-cyan-600 text-white ring-cyan-600/10 hover:bg-cyan-50 hover:text-cyan-700">
												<a :href="route('document.print', ticket._id)" target="_blank">
												Cetak Surat
												</a>
												<Icon class="text-sm ml-2" icon="material-symbols:print-outline" />
											</button>
										</div>
									</li>
									<li class="mb-4 md:mb-7">
										<p class="font-semibold text-primary-400 text-sm md:text-base mb-1 md:mb-2">Jenis Tiket</p>
										<span class="text-sm md:text-base"
											v-html="'Tiket ' + ticket.category.order['name'] + ' dengan Urgensi ' + ticket.category.time['name']"></span>
									</li>
									<li class="mb-4 md:mb-7">
										<p class="font-semibold text-primary-400 text-sm md:text-base mb-1 md:mb-2">Subjek Ajuan</p>
										<span class="text-sm md:text-base" v-html="ticket.purpose['unit']['name']"></span>
									</li>
									<li class="mb-4 md:mb-7">
										<p class="font-semibold text-primary-400 text-sm md:text-base mb-1 md:mb-2">Layanan</p>
										<span class="text-sm md:text-base" v-html="ticket.purpose['service']['name']"></span>
									</li>
									<li class="mb-4 md:mb-7">
										<p class="font-semibold text-primary-400 text-sm md:text-base mb-1 md:mb-2">Waktu Pengajuan Tiket</p>
										<span class="text-sm md:text-base" v-html="$dateFormatIndoWithTime(ticket.created['createdat'])"></span>
									</li>
									<li class="mb-4 md:mb-7">
										<p class="font-semibold text-primary-400 text-sm md:text-base mb-1 md:mb-2">File Attachment</p>
										<div v-if="ticket.attachment.length > 0">
											<div v-for="(item, i) in ticket.attachment[0]" :key="i">
												<a :href="route('cdn-files', ['attachment-ticket', ticket.ticketNumber, item.name])"
													target="_blank"
													class="text-primary-400 font-normal inline-flex items-center hover:underline text-sm md:text-base">
													{{ item.name }}
												</a>
											</div>
										</div>
										<p v-if="ticket.attachment.length === 0" class="italic text-gray-500 text-sm md:text-base">
											tidak ada file
										</p>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</BaseLayout>
</template>
<style>
.ck-editor__editable_inline {
	padding: 0 15px !important;
	min-height: 150px;
}

p {
	font-size: 14px;
}
</style>
