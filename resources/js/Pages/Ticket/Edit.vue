<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { defineProps, ref } from 'vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { component as CKEditor } from '@ckeditor/ckeditor5-vue';
import DropFile from '@/Components/DropFile.vue';

const props = defineProps({
    ticket: Object,
    services: Array,
    time: Array,
    order: Array,
    people: Array,
});

const pageTitle = ref('Ticket');

const editor = ClassicEditor;

const editorConfig = ref({
    placeholder: 'Masukkan deskripsi yang diperlukan',
})

const { person, purpose } = props.ticket;

const form = useForm({
    ticketNumber: props.ticket.ticketNumber,
    creator: person.creator.id,
    creator_name: person.creator.name,
    major: person.creator.major,
    faculty: person.creator.faculty,
    years: person.creator.years,
    creator_phone: person.creator.phone,
    creator_email: person.creator.email,
    service: purpose.service,
    unit: purpose.unit.name,
    unit_id: purpose.unit.id,
    supervisor: person.supervisor.name,
    supervisor_id: person.supervisor.id,
    recipient: person.recipient.name,
    recipient_id: person.recipient.id,
    recipient_phone: person.recipient.phone,
    recipient_email: person.recipient.email,
    time: props.ticket.category.time,
    order: props.ticket.category.order,
    content: props.ticket.content,
    file: props.ticket.attachment,
    file_existing: props.ticket.attachment,
    active: 'Y',
});

const submit = () => {
    form.put(route('ticket.update', props.ticket.id));
};

const setFoundBadge = () => {
    const creator = document.getElementById('creator');
    const found = document.getElementById('found');
    const notFound = document.getElementById('not-found');
    const canChange = document.getElementById('can-change');
    const canChangeToo = document.getElementById('can-change-too');

    creator.classList.add('border-green-500', 'focus:border-green-500', 'focus:ring-green-500', 'focus:ring-opacity-50');
    creator.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
    found.classList.remove('hidden');
    notFound.classList.add('hidden');
    canChange.classList.remove('hidden');
    canChangeToo.classList.remove('hidden');
};

const setNotFoundBadge = () => {
    const creator = document.getElementById('creator');
    const found = document.getElementById('found');
    const notFound = document.getElementById('not-found');
    const canChange = document.getElementById('can-change');
    const canChangeToo = document.getElementById('can-change-too');

    creator.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500', 'focus:ring-opacity-50');
    creator.classList.remove('border-green-500', 'focus:border-green-500', 'focus:ring-green-500');
    found.classList.add('hidden');
    notFound.classList.remove('hidden');
    canChange.classList.add('hidden');
    canChangeToo.classList.add('hidden');
};

const onStudentSelected = async (val) => {
    await axios.get(`/get-json-person-by-id/${val}`)
        .then((response) => {
            const { code, data } = response.data;
            const { person, unit, unit_parent_name, start_date, per_phone, per_email } = data || {};
            if (code === 200) {
                setFoundBadge();
                form.creator_name = person;
                form.major = unit;
                form.faculty = unit_parent_name;
                form.years = start_date.substring(0, 4);
                form.phone = per_phone;
                form.email = per_email;
            } else if (code === 404) {
                setNotFoundBadge();
                form.creator_name = '';
                form.major = '';
                form.faculty = '';
                form.years = '';
                form.phone = '';
                form.email = '';
            }
        });
};

const clearAttachmentErrors = () =>  {
  delete form.errors.attachment
  Object.keys(form.errors).forEach(key => {
    if (key.startsWith('attachment.')) delete form.errors[key]
  })
}

// make function setUnit which gonna get service as array using service select value as parameter
const setUnit = (e) => {
    axios.get('/get-json-service-by-id/' + e.id).then((response) => {
        if (response.data.code == 200) {
            const { data } = response.data;
            const {
                unit,
                unit_id,
                supervisor,
                supervisor_id,
                recipient,
                recipient_id,
                term_condition,
                duration,
                recipient_phone,
                recipient_email,
                time_id,
                times,
                order_id,
                orders,
            } = data;

            form.unit = unit;
            form.unit_id = unit_id;
            form.supervisor = supervisor;
            form.supervisor_id = supervisor_id;
            form.recipient = recipient;
            form.recipient_id = recipient_id;
            form.recipient_phone = recipient_phone;
            form.recipient_email = recipient_email;

            let terms = '<b>Disclaimer!</b><br>';
            terms += term_condition ? term_condition + '<br>' : 'Tidak ada syarat dan ketentuan<br>';
            terms += 'Durasi pengerjaan layanan adalah ' + (duration || '3') + ' hari';

            const termElement = document.getElementById('term');
            termElement.innerHTML = terms;
            termElement.classList.remove('hidden');
        } else if (response.data.code == 404) {
            form.unit_id = '';
            form.unit = '';
            form.supervisor_id = '';
            form.supervisor = '';
            form.recipient_id = '';
            form.recipient = '';
            form.recipient_phone = '';
            form.recipient_email = '';
            form.time = '';
            form.order = '';

            const termElement = document.getElementById('term');
            termElement.classList.add('hidden');
        }
    });
};

</script>
<template>

    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout :page-title="pageTitle">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit ticket
            </h2>
        </template>
        <div class="">
            <div class="mx-auto sm:px-6 lg:px-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-between mb-6">
                            <div class="">
                                <h3 class="text-primary-400 text-center">Edit Ticket</h3>
                            </div>
                            <Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none"
                                :href="route('ticket.index')">
                            Back
                            </Link>
                        </div>
                        <form name="createForm" @submit.prevent="submit">
                            <div className="flex flex-col">
                                <div class="flex">
                                    <div class="flex-1 mb-4 pr-4">
                                        <BreezeLabel for="creator" value="Data Mahasiswa" />
                                        <BreezeSearchSelect class="mt-1 block w-full" required v-model="form.creator"
                                            name="student" id="creator" placeholder="Cari Nama atau NIM Mahasiswa"
                                            apiUrl="/students/search" @selected="onStudentSelected" />
                                        <span class="text-red-600" v-if="form.errors.creator">
                                            {{ form.errors.creator }}
                                        </span>
                                        <div id="found" class="mt-2">
                                            <span
                                                class="inline-flex items-center gap-1.5 py-1.5 pl-3 pr-2 rounded-full text-xs font-medium text-green-800 bg-green-100">
                                                NIM Found
                                                <Icon class="text-xl pr-1" icon="uil:check" />
                                            </span>
                                        </div>
                                        <div id="not-found" class="hidden mt-2">
                                            <span
                                                class="inline-flex items-center gap-1.5 py-1.5 pl-3 pr-2 rounded-full text-xs font-medium text-red-800 bg-red-100">
                                                NIM Not Found
                                                <Icon class="text-xl pr-1" icon="uil:check" />
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex-1 mb-4">
                                        <BreezeLabel for="creator_name" value="&nbsp;" />
                                        <BreezeInput id="creator_name" type="text" class="mt-1 block w-full"
                                            v-model="form.creator_name" autofocus placeholder="Nama" readonly />
                                        <span class="text-red-600" v-if="form.errors.creator_name">
                                            {{ form.errors.creator_name }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mb-4 pr-4">
                                        <BreezeInput id="major" type="text" class="mt-1 block w-full"
                                            v-model="form.major" placeholder="Program Studi" readonly />
                                        <span class="text-red-600" v-if="form.errors.major">
                                            {{ form.errors.major }}
                                        </span>
                                    </div>
                                    <div class="flex-1 mb-4 pr-4">
                                        <BreezeInput id="faculty" type="text" class="mt-1 block w-full"
                                            v-model="form.faculty" autofocus placeholder="Fakultas" readonly />
                                        <span class="text-red-600" v-if="form.errors.faculty">
                                            {{ form.errors.faculty }}
                                        </span>
                                    </div>
                                    <div class="flex-1 mb-4">
                                        <BreezeInput id="years" type="text" class="mt-1 block w-full"
                                            v-model="form.years" autofocus placeholder="Angkatan" readonly />
                                        <span class="text-red-600" v-if="form.errors.years">
                                            {{ form.errors.years }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mb-4 pr-4">
                                        <BreezeInput id="creator_phone" type="text" class="mt-1 block w-full"
                                            v-model="form.creator_phone" autofocus placeholder="Nomor whatsapp" />
                                        <span class="text-red-600" v-if="form.errors.creator_phone">
                                            {{ form.errors.creator_phone }}
                                        </span>
                                        <div id="can-change" class="mt-2">
                                            <span
                                                class="inline-flex items-center gap-1.5 py-1.5 pl-3 pr-2 rounded-full text-xs font-medium text-gray-500 bg-gray-200">
                                                Dapat diubah jika tidak sesuai
                                                <Icon class="text-xl pr-1" icon="ri:information-line" />
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex-1 mb-4">
                                        <BreezeInput id="creator_email" type="text" class="mt-1 block w-full"
                                            v-model="form.creator_email" autofocus placeholder="creator_email" />
                                        <span class="text-red-600" v-if="form.errors.creator_email">
                                            {{ form.errors.creator_email }}
                                        </span>
                                        <div id="can-change-too" class="mt-2">
                                            <span
                                                class="inline-flex items-center gap-1.5 py-1.5 pl-3 pr-2 rounded-full text-xs font-medium text-gray-500 bg-gray-200">
                                                Dapat diubah jika tidak sesuai
                                                <Icon class="text-xl pr-1" icon="ri:information-line" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <hr className="mb-2">
                                <div className="flex-1 mb-4">
                                    <BreezeLabel for="service" value="Layanan" />
                                    <!-- <BreezeInput id="service" type="text" class="mt-1 block w-full"
										v-model="form.service" autofocus /> -->
                                    <BreezeSearchSelect class="mt-1 block w-full" v-model="form.service" name="services"
                                        id="service" :option="services" :custom-label="nameWithLang"
                                        placeholder="Cari layanan" v-on:select="setUnit" label="name" track-by="name">
                                    </BreezeSearchSelect>
                                    <span className="text-red-600" v-if="form.errors.service">
                                        {{ form.errors.service }}
                                    </span>
                                </div>
                                <div className="flex">
                                    <div className="flex-1 mb-4 pr-4">
                                        <BreezeLabel for="order" value="Jenis Layanan" />
                                        <BreezeSearchSelect class="mt-1 block w-full" v-model="form.order" name="order"
                                            id="order" :option="order" :custom-label="nameWithLang"
                                            placeholder="Cari Jenis" label="name" track-by="name" disabled>
                                        </BreezeSearchSelect>
                                        <span className="text-red-600" v-if="form.errors.order">
                                            {{ form.errors.order }}
                                        </span>
                                    </div>
                                    <div className="flex-1 mb-4">
                                        <BreezeLabel for="time" value="Urgensi Layanan" />
                                        <BreezeSearchSelect class="mt-1 block w-full" v-model="form.time" name="time"
                                            id="time" :option="time" :custom-label="nameWithLang"
                                            placeholder="Cari urgensi" label="name" track-by="name">
                                        </BreezeSearchSelect>
                                        <span className="text-red-600" v-if="form.errors.time">
                                            {{ form.errors.time }}
                                        </span>
                                    </div>
                                </div>
                                <div className="flex">
                                    <div className="flex-1 mb-4 pr-4">
                                        <BreezeLabel for="unit_id" value="Unit tujuan" />
                                        <BreezeInput id="unit_id" type="hidden" class="mt-1 block w-full"
                                            v-model="form.unit_id" />
                                        <BreezeInput id="unit" type="text" class="mt-1 block w-full" readonly
                                            v-model="form.unit" />
                                        <!-- <BreezeSearchSelect class="mt-1 block w-full" v-model="form.unit" name="units"
											:option="units" :custom-label="nameWithLang" placeholder="Cari unit"
											label="name" track-by="name">
										</BreezeSearchSelect> -->
                                        <span className="text-red-600" v-if="form.errors.unit_id">
                                            {{ form.errors.unit_id }}
                                        </span>
                                    </div>
                                    <div className="flex-1 mb-4 pr-4">
                                        <BreezeLabel for="unit_id" value="&nbsp;" />
                                        <BreezeInput id="supervisor_id" type="hidden" class="mt-1 block w-full"
                                            v-model="form.supervisor_id" />
                                        <BreezeInput id="supervisor" type="text" class="mt-1 block w-full"
                                            v-model="form.supervisor" autofocus placeholder="Penanggung Jawab"
                                            readonly />
                                        <span className="text-red-600" v-if="form.errors.supervisor">
                                            {{ form.errors.supervisor }}
                                        </span>
                                    </div>
                                    <div className="flex-1 mb-4">
                                        <BreezeLabel for="unit_id" value="&nbsp;" />
                                        <BreezeInput id="recipient_id" type="hidden" class="mt-1 block w-full"
                                            v-if="person.recipient.length !== 0" v-model="form.recipient_id" />
                                        <BreezeInput id="recipient" type="text" class="mt-1 block w-full"
                                            v-if="person.recipient.length !== 0" v-model="form.recipient" autofocus
                                            placeholder="Pelaksana" readonly />
                                        <BreezeSearchSelect v-if="person.recipient.length === 0"
                                            class="mt-1 block w-full" v-model="form.recipient" name="per" id="people"
                                            :option="props.people" :custom-label="nameWithLang"
                                            placeholder="Cari penerima layanan" label="name" track-by="name">
                                        </BreezeSearchSelect>
                                        <span className="text-red-600" v-if="form.errors.recipient">
                                            {{ form.errors.recipient }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="flex-1 mb-4 pr-4">
                                        <BreezeInput id="recipient_phone" type="text" class="mt-1 block w-full"
                                            v-model="form.recipient_phone" autofocus placeholder="Nomor whatsapp" />
                                        <span class="text-red-600" v-if="form.errors.recipient_phone">
                                            {{ form.errors.recipient_phone }}
                                        </span>
                                        <div id="can-change-tree" class="mt-2">
                                            <span
                                                class="inline-flex items-center gap-1.5 py-1.5 pl-3 pr-2 rounded-full text-xs font-medium text-gray-500 bg-gray-200">
                                                Nomor pelaksana Dapat diubah jika tidak sesuai
                                                <Icon class="text-xl pr-1" icon="ri:information-line" />
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex-1 mb-4">
                                        <BreezeInput id="recipient_email" type="text" class="mt-1 block w-full"
                                            v-model="form.recipient_email" autofocus placeholder="Email" />
                                        <span class="text-red-600" v-if="form.errors.recipient_email">
                                            {{ form.errors.recipient_email }}
                                        </span>
                                        <div id="can-change-for" class="mt-2">
                                            <span
                                                class="inline-flex items-center gap-1.5 py-1.5 pl-3 pr-2 rounded-full text-xs font-medium text-gray-500 bg-gray-200">
                                                Email pelaksana Dapat diubah jika tidak sesuai
                                                <Icon class="text-xl pr-1" icon="ri:information-line" />
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div id="term"
                                    class="hidden mb-4 rounded-lg px-6 py-5 text-base text-gray-800 bg-gray-200"
                                    role="alert">
                                    A simple info alert—check it out!
                                </div>

                                <div className="mb-4">
                                    <BreezeLabel for="content" value="Deskripsi tiket" />
                                    <div>
                                        <CKEditor :editor="editor" v-model="form.content" :config="editorConfig">
                                        </CKEditor>
                                    </div>
                                    <span className="text-red-600" v-if="form.errors.content">
                                        {{ form.errors.content }}
                                    </span>
                                </div>
                                <div className="mb-4 mt-3">
                                    <BreezeLabel for="file" value="Files" />
                                    <!-- <BreezeInput id="file" type="text" class="mt-1 block w-full" v-model="form.file"
										autofocus placeholder="Auto-fill" />
									<span className="text-red-600" v-if="form.errors.file">
										{{ form.errors.file }}
									</span> -->
                                    <DropFile v-model="form.attachment" @update:modelValue="clearAttachmentErrors" />
                                    <!-- <BreezeInput id="file" type="hidden" class="mt-1 block w-full"
                                        v-model="form.file_existing" autofocus placeholder="Auto-fill" /> -->

                                        <div v-for="(file, index) in form.attachment" :key="index">
                                            <span v-if="form.errors[`attachment.${index}`]" class="text-red-600">
                                                {{ form.errors[`attachment.${index}`] }}
                                            </span>
                                        </div>
                                </div>
                            </div>
                            <div className="mt-4">
                                <button type="submit"
                                    className="px-12 py-1.5 font-semibold text-lg text-white bg-primary-300 rounded">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
<style>
.ck-editor__editable_inline {
    padding: 0 25px !important;
    min-height: 250px;
}
</style>
