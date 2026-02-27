<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, defineProps, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { useToast } from "vue-toastification";
import defaultPhoto from "../../../images/avatar2.png"
import axios from 'axios';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { component as CKEditor } from '@ckeditor/ckeditor5-vue';
import AlertConfirm from '@/Components/ConfirmAlert.vue';
import { useConfirm } from '@/Composables/useConfirm';
import {formatDuration} from "@/Utils/date"
const { showConfirm, confirmMessage, ask, confirm, cancel } = useConfirm();

const editor = ClassicEditor;
const editorConfig = ref({
    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
});

const props = defineProps({
    ticket: Object,
    creatorData: Object,
});

const page = usePage()
const showTooltip = ref({})
const { profile } = page.props

const toast = useToast();

let ticket = ref(props.ticket);

const isStaff = computed(() => ['102', '106'].includes(profile.role_id));
const notClosed = computed(() => getMilestone('code') != 5);

const isActionVisible = computed(() => isStaff.value && notClosed.value);
const canNotifySSC = isActionVisible;
const canCloseTicket = isActionVisible;
const canNotifyUser = computed(() => isStaff.value);

const creatorData = {
    'id': props.creatorData.id,
    'name': props.creatorData.name,
    'nim': props.creatorData.nim,
    'photo': props.creatorData.photo,
    'phone': props.creatorData.phone,
};

const arrProgress = ref(
    props.ticket.progress
        .filter(progress => !['progress-chat', 'content-original'].includes(progress.head))
        .reverse()
);

console.log(props.ticket.progress)

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
            phone: props.ticket.person['creator']['phone'],
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

const chatByDate = computed(() => {
    const groups = {};
    arrProgressChat.value.forEach(chat => {
        const date = new Date(chat.timestamp).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        if (!groups[date]) groups[date] = [];
        groups[date].push(chat);
    });
    return groups;
});


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


const submit = () => {
    page.props.flash = {};

    // Validasi di frontend sebelum submit
    if (!form.content || form.content.trim() === '') {
        toast.error("Pesan tidak boleh kosong", {
            timeout: 3000,
        });
        return;
    }

    axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
    axios
        .post(route('ticket.store-progress', ticket.value.id), form)
        .then((res) => {

            const attachment = [];

            if (form.attachment !== null) {
                for (let i = 0; i < form.attachment.length; i++) {
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
                    name: creatorData.name,
                    id: creatorData.id,
                    nim: creatorData.nim,
                    photo: creatorData.photo,
                    phone: creatorData.phone,
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
        })
        .catch((error) => {
            let errorMessage = 'Terjadi kesalahan saat mengirim pesan';
            toast.error(errorMessage, {
                timeout: 3000,
            });

            const chatBox = document.getElementById('chat-box');
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}

const form = useForm({
    head: 'progress-chat',
    content: '',
    attachment: null,
});

let close = false;

const closeTicket = () => {
    close = true;
    const closeTicket = document.getElementById("close-ticket");
    closeTicket.classList.remove('hidden');
    document.getElementById("press-chat").click();

    const check = arrProgress.value.filter((progress) => progress.head === 'closing');
    if (check.length < 1) {
        arrProgress.value.unshift({
            ticketId: ticket.value.id,
            head: 'closing',
            content: 'Closing Ticket, Selesaikan tiket dengan mengisi form dibawah',
            close: true,
            attachment: '',
            by: {
                name: creatorData.name,
                id: creatorData.id,
            },
            timestamp: new Date(),
        });
    }
};

const notifySSC = async () => {
    const confirmed = await ask("Apakah Anda yakin ingin mengirim notifikasi WA ke Petugas Layanan ini?");
    if (!confirmed) return;

    axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
    axios.post(route('ticket.notifyOperator', ticket.value.id), formClose)
        .then((res) => {
            if (res.status === 500) {
                alert('Error: ' + res.data.error);
            } else if (res.status === 200) {
                alert('WA notifikasi telah dikirimkan ke SSC');
            }
        });
};

const submitClose = () => {

    page.props.flash = {};

    formClose.post(route('ticket.close', ticket.value.id), {
        preserveScroll: true,

        onSuccess: (page) => {
            close = false;

            if (page.props.flash && page.props.flash.error) return;

            document.getElementById('close-ticket')?.classList.add('hidden');

            const statusTicket = document.getElementById('status-ticket');
            statusTicket?.classList.remove('bg-red-50', 'text-red-700', 'ring-red-600/10');
            statusTicket?.classList.add('bg-green-50', 'text-green-700', 'ring-green-600/10');
            if (statusTicket) statusTicket.innerHTML = 'Closed';

            arrProgress.value.shift();
            arrProgress.value.unshift({
                ticketId: ticket.value.id,
                head: 'closed',
                content: `Ticket ${ticket.value.ticketNumber} ditutup oleh ${props.ticket.person.recipient.name}, Tiket ditutup dengan keterangan : ${formClose.response}`,
                attachment: '',
                by: { name: creatorData.name, id: creatorData.id },
                timestamp: new Date(),
            });

            formClose.reset();
            document.getElementById('file-container')?.classList.add('hidden');
            document.getElementById('action-box')?.classList.add('hidden');
            document.getElementById('chatForm')?.classList.add('hidden');

            const progressBox = document.getElementById('progress-box');
            progressBox && (progressBox.scrollTop = progressBox.scrollHeight);
        },

        onError: (errors) => {
            // console.log("error : ", errors)
            // Handle validation errors (422)
            alert('Validasi gagal. Periksa isian form.');
        },

        onFinish: (visit) => {
            // This catches exceptions passed from the backend
            if (visit && visit.page && visit.page.props && visit.page.props.errors) {
                const errorMessage = Object.values(visit.page.props.errors)[0];
                if (errorMessage) {
                    alert(errorMessage);
                }
            }

            const progressBox = document.getElementById('progress-box');
            progressBox && (progressBox.scrollTop = progressBox.scrollHeight);
        },
    });
};

const notifyUser = async () => {
    const confirmed = await ask("Apakah Anda yakin ingin mengirim notifikasi WA ke Pemilik Tiket?");
    if (!confirmed) return;

    try {
        await axios.post(route('ticket.notifyCreator', ticket.value.id), {
            status: ticket.value.status,
            service: ticket.value.purpose.service,
            content: ticket.value.content,
        });
        alert('✅ Notifikasi WA telah dikirimkan ke Pemilik Tiket');
    } catch (error) {
        alert('❌ Error: ' + (error.response?.data?.error || error.message));
    }
};

const formClose = useForm({
    head: 'closing',
    response: '',
    resolution: '',
});
</script>

<template>

    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <div class="py-1">
            <div class="container mx-auto px-2 md:px-2">
                <!-- Tiket Milestone -->
                <div class="card my-7 flex flex-col bg-white border-[1px] border-neutral-200 shadow-lg rounded-lg">
                    <div class="card-header border-b-[1px] border-neutral-200 py-5 px-10">
                        <h3 class="font-bold text-primary-400">Timeline Tiket</h3>
                    </div>
                    <div class="card-body py-10">
                        <div class="overflow-x-auto flex justify-normal xl:justify-center wrapper-guide">
                            <!-- step 1 -->
                            <div class="h-full">
                                <div class="text-center flex flex-col justify-center w-[150px]">
                                    <div class="flex items-center justify-center mb-3">
                                        <hr class="border-2 border-none w-full">
                                        <div v-if="getMilestone('code') > 0"
                                            class="bg-primary-400 p-1 rounded-full w-14 h-14 flex justify-center items-center">
                                            <Icon icon="bi:check" class="text-white text-5xl" />
                                        </div>
                                        <div v-else
                                            class="bg-neutral-400 p-1 rounded-full w-14 h-14 flex justify-center items-center">
                                            <Icon icon="bi:check" class="text-white text-5xl" />
                                        </div>
                                        <hr class="border-2 border-primary-400 w-full">
                                    </div>
                                    <p class="text-sm">Input Tiket</p>
                                </div>
                            </div>
                            <div>
                                <div
                                    class="w-[60px] lg:w-[70px] xl:w-[80px] h-14 flex justify-center items-center relative">
                                    <hr v-if="getMilestone('code') > 0"
                                        class="border-2 border-primary-400 w-[150px] absolute">
                                    <hr v-else class="border-2 border-neutral-400 w-[150px] absolute">
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
                                    <p class="text-sm">Proses Pengerjaan</p>
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
                                    <p class="text-sm">Review</p>
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
                <!-- Ticket Progressing -->
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 lg:col-span-8">
                        <div class="card flex flex-col bg-white border-[1px] border-neutral-200 shadow-lg rounded-lg">
                            <div class="card-header border-b-[1px] border-neutral-200 py-5 px-10">
                                <h3 class="font-bold text-primary-400">Respon Tiket</h3>
                            </div>
                            <div class="card-body py-10 pr-3 pl-0 xl:pr-10 xl:pl-3">
                                <div>
                                    <!-- Start Progress foreach -->
                                    <div id="progress-box" v-for="(prog, i) in arrProgress" :key="i"
                                        class="relative pl-8 sm:pl-16 py-6 group">
                                        <div
                                            class="flex flex-col sm:flex-row items-start mb-1 group-last:before:hidden before:absolute before:left-2 sm:before:left-0 before:h-full before:px-px before:bg-primary-400 sm:before:ml-[2rem] before:self-start before:-translate-x-1/2 before:translate-y-3 after:absolute after:left-4 sm:after:left-0 after:w-2 after:h-2 after:bg-primary-400 after:border-2 after:box-content after:border-primary-400 after:rounded-full sm:after:ml-[2rem] after:-translate-x-1/2 after:translate-y-1.5">
                                            <div class="grid grid-cols-1 sm:grid-cols-4 items-center w-full">
                                                <div class="inline-flex col-span-3 align-middle text-lg font-bold text-primary-400"
                                                    v-html="prog.content.split(',')[0]"></div>
                                                <div class="text-sm self-center font-medium sm:ml-auto text-gray-500"
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
                                                    <p class="text-base" v-html="prog.content.split(',').slice(1)"></p>
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
                                                        <div v-for="(chats, date) in chatByDate" :key="date"
                                                            class="mb-4">
                                                            <div class="flex items-center my-4">
                                                                <hr class="flex-grow border-gray-300" />
                                                                <span class="px-3 text-gray-500 text-sm font-medium">{{
                                                                    date }}</span>
                                                                <hr class="flex-grow border-gray-300" />
                                                            </div>

                                                            <!-- Komentar per tanggal -->
                                                            <div v-for="(chat, j) in chats" :key="j"
                                                                class="flex gap-y-3 w-full h-full rounded-lg px-6 py-4 relative border-gray-200">

                                                                <!-- Avatar dengan Tooltip -->
                                                                <div class="relative"
                                                                    @mouseenter="showTooltip[j] = true"
                                                                    @mouseleave="showTooltip[j] = false">
                                                                    <img class="inline-block h-[3rem] w-[3rem] object-cover rounded-full mr-3 cursor-pointer"
                                                                        :src="chat.by.photo || defaultPhoto"
                                                                        alt="Image Description">

                                                                    <!-- <div v-if="showTooltip[j] && (profile.role_id === '102' || profile.role_id === '106')"
                                                                        class="absolute left-0 top-[3rem] mt-2 w-48 p-3 bg-white text-gray-800 text-sm rounded-lg shadow-lg border border-gray-200 z-50">
                                                                        <div
                                                                            class="absolute -top-1 left-4 w-2 h-2 bg-white border-l border-t border-gray-200 rotate-45">
                                                                        </div>
                                                                        <div class="space-y-2">
                                                                            <div class="flex items-center gap-2">
                                                                                <Icon icon="mdi:identifier"
                                                                                    class="w-4 h-4 text-gray-500" />
                                                                                <span class="text-gray-700">{{
                                                                                    chat.by.nim || chat.by.id }}</span>
                                                                            </div>
                                                                            <div class="flex items-center gap-2">
                                                                                <Icon icon="mdi:phone"
                                                                                    class="w-4 h-4 text-gray-500" />
                                                                                <span class="text-gray-700">{{
                                                                                    chat.by.phone || 'Tidak tersedia'
                                                                                    }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div> -->
                                                                </div>

                                                                <!-- Konten komentar -->
                                                                <div class="w-full">
                                                                    <div class="grid grid-cols-12 gap-4">
                                                                        <span
                                                                            class="col-span-8 flex items-center font-semibold text-gray-800 text-sm">
                                                                            {{ $makeShortName(chat.by.name) }}
                                                                            <span
                                                                                class="inline-flex items-center ml-2 py-1 px-1.5 rounded-full text-xs font-medium bg-red-100 text-primary-300">
                                                                                {{ chat.by.as }}
                                                                            </span>
                                                                        </span>
                                                                        <div
                                                                            class="col-span-4 text-xs self-center font-medium ml-auto text-gray-500">
                                                                            <!-- <span
                                                                                v-html="$toTimeAgo(chat.timestamp)"></span> -->
                                                                        <p class="text-sm">{{ new Date(chat.timestamp).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) }}</p>

                                                                        </div>
                                                                    </div>
                                                                    <p class="mt-1" v-html="chat.content"></p>
                                                                    <!-- <div class="flex justify-between">
                                                                    </div> -->
                                                                    <div v-if="chat.attachment"
                                                                        class="bg-gray-100 rounded py-2">
                                                                        <ul>
                                                                            <li v-for="(fileArr, k) in chat.attachment"
                                                                                :key="k">
                                                                                <a :href="route('cdn-files', ['attachment-chat', ticket.ticketNumber, fileArr.name])"
                                                                                    target="_blank"
                                                                                    class="text-gray-600 font-normal inline-flex items-center hover:underline">
                                                                                    <Icon class="ml-2"
                                                                                        icon="ant-design:paper-clip-outlined" />
                                                                                    <span class="text-xs"
                                                                                        v-html="fileArr.name"></span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- End Chat Foreach -->

                                                        <form name="chatForm" id="chatForm" @submit.prevent="submit"
                                                            class="px-5 py-3"
                                                            :class="{ 'hidden': ticket.status === 'closed' }"
                                                            enctype="multipart/form-data">
                                                            <div class="grid grid-cols-12 gap-4 items-center">
                                                                <div class="col-span-8">
                                                                    <!-- <input type="text"
                                                                        class="bg-gray-200 py-2.5 px-3 block w-full border-gray-200 rounded-md text-sm focus:border-primary-500 focus:ring-primary-500 focus:bg-gray-100 focus:outline-none"
                                                                        placeholder="isi teks" v-model="form.content"> -->

                                                                    <textarea
                                                                        class="bg-gray-200 px-3 block w-full border-gray-200 rounded-md text-sm
                                                                    focus:border-primary-500 focus:ring-primary-500 focus:bg-gray-100 focus:outline-none resize-none"
                                                                        placeholder="isi pesan" v-model="form.content">
                                                                    </textarea>

                                                                    <input type="file" class="hidden"
                                                                        name="attachment-input" id="attachment-input"
                                                                        multiple @change="showFiles()">
                                                                    <input type="text" class="hidden" id="head"
                                                                        v-model="form.head">
                                                                </div>
                                                                <div class="col-span-1">
                                                                    <button type="button"
                                                                        class=" p-2.5 hover:bg-gray-200 font-bold rounded inline-flex items-center"
                                                                        @click="chooseFiles()">
                                                                        <Icon class="text-xl"
                                                                            icon="ant-design:paper-clip-outlined" />
                                                                    </button>
                                                                </div>
                                                                <div class="col-span-3">
                                                                    <button type="submit"
                                                                        class="w-full py-2 px-2 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-primary-400 text-white hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-2 transition-all text-base">
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
                                            <div id="close-ticket"
                                                class="hidden card-body hs-accordion-content w-full overflow-hidden transition-[height] duration-300">
                                                <form name="closeForm" @submit.prevent="submitClose" class="px-5 py-3"
                                                    enctype="multipart/form-data">
                                                    <div class="grid grid-cols-12 gap-4 items-center">
                                                        <div class="col-span-12 mb-4">
                                                            <CKEditor :editor="editor"
                                                                :config="{ editorConfig, placeholder: 'Response akan diisi dengan pesan yang akan ditampilkan kepada pemilik tiket' }"
                                                                v-model="formClose.response"></CKEditor>
                                                        </div>
                                                        <div class="col-span-12">
                                                            <CKEditor :editor="editor"
                                                                :config="{ editorConfig, placeholder: 'Resolution akan diisi dengan catatan pengerjaan tiket yang akan dijadikan evaluasi internal' }"
                                                                v-model="formClose.resolution" placeholder="Resolution">
                                                            </CKEditor>
                                                        </div>
                                                        <div class="col-span-12 hidden" id="file-container">
                                                            <div class="bg-gray-100 text-gray-700 px-3 py-2 rounded-sm"
                                                                role="alert">
                                                                <p class="text-sm italic text-gray-400" id="files-name">
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-span-12">
                                                            <button type="submit"
                                                                class="w-40 py-2 px-2 inline-flex justify-center items-center gap-2 rounded-md border border-transparent font-semibold bg-primary-400 text-white hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-2 transition-all text-base">
                                                                Submit
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
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
                    <div class="col-span-12 lg:col-span-4">
                        <div class="card flex flex-col bg-white border-[1px] border-neutral-200 shadow-lg rounded-lg">
                            <div class="card-header border-b-[1px] border-neutral-200 py-5 px-5 md:px-7 xl:px-10">
                                <h3 class="font-bold text-primary-400">Data Tiket</h3>
                            </div>
                            <div class="card-body py-8 px-5 xl:px-8">
                                <ul>
                                    <li id="action-box" class="mb-7">
                                        <p class="font-semibold text-primary-400 text-base mb-2" v-if="isActionVisible">
                                            Action</p>
                                        <div class="flex flex-wrap xl:flex-nowrap items-center gap-2">
                                            <!-- Notify SSC -->
                                            <button v-if="canNotifySSC && isActionVisible"
                                                class="inline-flex items-center rounded-md px-2 py-1 text-xs shadow-sm ring-1 ring-inset bg-cyan-600 text-white ring-cyan-600/10 hover:bg-cyan-50 hover:text-cyan-700 whitespace-nowrap"
                                                @click="notifySSC()">
                                                Notify SSC
                                                <Icon class="ml-1 text-sm flex-shrink-0" icon="carbon:notification" />
                                            </button>

                                            <!-- Close Ticket -->
                                            <button v-if="canCloseTicket && isActionVisible"
                                                class="inline-flex items-center rounded-md px-2 py-1 text-xs shadow-sm ring-1 ring-inset bg-green-700 text-white ring-green-600/10 hover:bg-green-50 hover:text-green-700 whitespace-nowrap"
                                                @click="closeTicket()">
                                                Close Tiket
                                                <Icon class="ml-1 text-sm flex-shrink-0" icon="pajamas:task-done" />
                                            </button>

                                            <!-- Notify User -->
                                            <button v-if="canNotifyUser"
                                                class="inline-flex items-center rounded-md px-2 py-1 text-xs shadow-sm ring-1 ring-inset bg-yellow-600 text-white ring-yellow-600/10 hover:bg-yellow-50 hover:text-yellow-700 whitespace-nowrap"
                                                @click="notifyUser()">
                                                Notify User
                                                <Icon class="ml-1 text-sm flex-shrink-0"
                                                    icon="material-symbols:notification-add-outline-rounded" />
                                            </button>
                                        </div>
                                    </li>


                                    <li class="mb-7">
                                        <p class="font-semibold text-primary-400 text-base mb-2">Nomor Tiket</p>
                                        <span
                                            class="inline-flex font-semibold items-center gap-1.5 py-1.5 rounded-full text-md"
                                            v-html="ticket.ticketNumber">
                                        </span>
                                    </li>
                                    <li class="mb-7" id="status-box">
                                        <p class="font-semibold text-primary-400 text-base mb-2">Status Tiket</p>
                                        <span id="status-ticket"
                                            class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset"
                                            :class="getMilestone('class')" v-html="getMilestone('value')">
                                        </span>
                                    </li>

                                    <li v-if="ticket.status === 'closed'" class="mb-7" id="status-box">
                                        <p class="font-semibold text-primary-400 text-base mb-2">Durasi Penyelesaian</p>
                                        <span id="duration"
                                            class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset">
                                            {{ formatDuration(ticket.created_at, ticket.updated_at) }}
                                        </span>
                                    </li>

                                    <li class="mb-7">
                                        <p class="font-semibold text-primary-400 text-base mb-2">Jenis Tiket</p>
                                        <span
                                            v-html="'Tiket ' + 'dengan Urgensi ' + ticket.category.time['name']"></span>
                                    </li>
                                    <li class="mb-7">
                                        <p class="font-semibold text-primary-400 text-base mb-2">Subjek Ajuan</p>
                                        <span v-html="ticket.purpose['unit']['name']"></span>
                                    </li>
                                    <li class="mb-7">
                                        <p class="font-semibold text-primary-400 text-base mb-2">Layanan</p>
                                        <span v-html="ticket.purpose['service']['name']"></span>
                                    </li>
                                    <li class="mb-7 flex flex-col"
                                        v-if="profile.role_id === '102' || profile.role_id === '106'">
                                        <p class="font-semibold text-primary-400 text-base mb-2">Petugas</p>
                                        <p>Nama : <span v-html="ticket.person['recipient']['name']" class="mb-1"></span>
                                        </p>
                                        <p>Nomor HP : <span v-html="ticket.person['recipient']['phone']"
                                                class="mb-1"></span></p>
                                    </li>
                                    <li class="mb-7 flex flex-col">
                                        <p class="font-semibold text-primary-400 text-base mb-2">Pemilik Tiket</p>
                                        <p>Nama : <span v-html="ticket.person['creator']['name']" class="mb-1"></span>
                                        </p>
                                        <p>NIM : <span v-html="ticket.person['creator']['id']" class="mb-1"></span></p>
                                        <p v-if="profile.role_id === '102' || profile.role_id === '106'">Nomor HP :
                                            <span v-html="ticket.person['creator']['phone']" class="mb-1"></span>
                                        </p>
                                    </li>
                                    <li class="mb-7">
                                        <p class="font-semibold text-primary-400 text-base mb-2">Waktu Pengajuan Tiket
                                        </p>
                                        <span v-html="$dateFormatIndoWithTime(ticket.created['createdat'])"></span>
                                    </li>
                                    <li class="mb-7">
                                        <p class="font-semibold text-primary-400 text-base mb-2">File Attachment</p>
                                        <div v-if="ticket.attachment.length > 0">
                                            <div v-for="(item, i) in ticket.attachment[0]" :key="i">
                                                <a :href="route('cdn-files', ['attachment-ticket', ticket.ticketNumber, item.name])"
                                                    target="_blank"
                                                    class="text-primary-400 font-normal inline-flex items-center hover:underline">
                                                    {{ item.name }}
                                                </a>
                                            </div>
                                        </div>
                                        <p v-if="ticket.attachment.length === 0" class="italic text-gray-500">
                                            tidak ada file
                                        </p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <AlertConfirm :show="showConfirm" :message="confirmMessage" type="warning" confirmText="Kirim"
            cancelText="Batal" @confirm="confirm" @cancel="cancel" />
    </BreezeAuthenticatedLayout>
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
