<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
// import BreezeTextArea from '@/Components/Textarea.vue';
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { component as CKEditor } from '@ckeditor/ckeditor5-vue';
import { usePage } from '@inertiajs/vue3';
import DropFile from '@/Components/DropFile.vue';
import { defineProps, ref, onMounted } from 'vue';
import { debounce } from 'lodash'
import LoadingSpinner from '@/Components/LoadingSpinner.vue'

const props = defineProps({
    serviceid: Array,
    errors: Object,
    services: Array,
    time: Array,
    order: Array,
    nameWithLang: Function,
    value: Object,
    creatorData: Object
});

const page = usePage()
const { profile } = page.props

const roleId = profile.role_id

const serviceId = props.serviceid;

const editor = ClassicEditor;
// const editorData = ref('masukkan deskripsi yang diperlukan');
const editorConfig = ref({
    placeholder: 'Masukkan deskripsi yang diperlukan',
    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
})

const encodeText = (text) => {
    return text.replace(/[\u00A0-\u9999<>\&]/gim, function (i) {
        return '&#' + i.charCodeAt(0) + ';';
    });
};


const decodeText = (text) => {
    return text.replace(/&#(\d+);/g, function (match, dec) {
        return String.fromCharCode(dec);
    });
};

// Initialize the form object with default values
const form = useForm({
	creator: '',
    creator_id : '',
	creator_name: '',
	major: '',
	faculty: '',
	years: '',
	creator_phone: '',
	creator_email: '',
	creator_photo: '',
	service: '',
	unit: '',
	unit_id: '',
	supervisor: '',
	supervisor_id: '',
	recipient: '',
	recipient_id: '',
	recipient_phone: '',
	recipient_email: '',
	time: {
        id : '',
        name : ''
    },
	order: {
        id : '',
        name : ''
    },
	content: '',
	attachment: '',
	active: 'Y',
	createdby: '999',
});

const submit = debounce(() => {
    form.post(route('ticket.store'));
}, 500)

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

//create function searchNim which gonna get data ajax from controller but the param should be behind / instead of get and make the function took sometimes
const searchNim = (e) => {
    axios.get(`/get-json-person-by-id/${e.target.value}`)
        .then((response) => {
            const { code, data } = response.data;
            // make code below worked with null value
            const {
                id,
                person,
                per_phone,
                per_email,
                per_major,
                per_faculty,
                per_years,
            } = data || {};
            if (code === 200) {
                // setFoundBadge();
                form.creator = e.target.value
                form.creator_name = person;
                form.creator_id = id;
                form.major = per_major;
                form.faculty = per_faculty;
                form.years = per_years;
                form.creator_phone = per_phone;
                form.creator_email = per_email;
            } else if (code === 404) {
                // setNotFoundBadge();
                form.creator_name = '';
                form.major = '';
                form.faculty = '';
                form.years = '';
                form.creator_phone = '';
                form.creator_email = '';
            }
        });
};

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

            form.service = { id: e.id, name: e.name };
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

            // const termElement = document.getElementById('term');
            // termElement.innerHTML = terms;
            // termElement.classList.remove('hidden');
            // // show can-change-tree
            // const canChangetree = document.getElementById('can-change-tree');
            // canChangetree.classList.remove('hidden');
            // // show can-change-for
            // const canChangeFor = document.getElementById('can-change-for');
            // canChangeFor.classList.remove('hidden');

        } else if (response.data.code == 404) {
            form.unit_id = '';
            form.unit = '';
            form.supervisor_id = '';
            form.supervisor = '';
            form.recipient_id = '';
            form.recipient = '';
            form.recipient_phone = '';
            form.recipient_email = '';

            // const termElement = document.getElementById('term');
            // termElement.classList.add('hidden');
            // // hide can-change-tree
            // const canChangetree = document.getElementById('can-change-tree');
            // canChangetree.classList.add('hidden');
            // // hide can-change-for
            // const canChangeFor = document.getElementById('can-change-for');
            // canChangeFor.classList.add('hidden');
        }
    });
};

const clearAttachmentErrors = () =>  {
  delete form.errors.attachment
  Object.keys(form.errors).forEach(key => {
    if (key.startsWith('attachment.')) delete form.errors[key]
  })
}

setUnit({ id: serviceId['id'], name: serviceId['service'] });

searchNim({ target: { value: props.creatorData.nim } });

const onStudentSelected = async (id) => {
    await axios.get(`/get-json-person-by-id/${id}`)
    .then((response) => {
			const { code, data } = response.data;
			const {
                id,
				person,
				per_phone,
				per_email,
                per_major,
                per_faculty,
                per_years,
                per_photo
			} = data || {};
			if (code === 200) {
				setFoundBadge();
				form.creator_name = person;
                form.creator_id = id;
				form.major = per_major;
				form.faculty = per_faculty;
				form.years = per_years;
				form.creator_phone = per_phone;
				form.creator_email = per_email;
                form.creator_photo = per_photo;
			} else if (code === 404) {
				setNotFoundBadge();
				form.creator_name = '';
				form.major = '';
				form.faculty = '';
				form.years = '';
				form.creator_phone = '';
				form.creator_email = '';
			}
	});
};


onMounted(() => {
        form.time = {
        id : props.time[0].id,
        name : props.time[0].category
    }
})
</script>

<template>

    <Head title="Student Service Center" />
    <BaseLayout>
        <section class="pt-28 pb-10">
            <div class="container mx-auto px-6 md:px-14">
                <div class="flex items-center justify-center">
                    <div class="card flex flex-col w-full shadow-lg rounded-lg border-[1px] border-neutral-200">
                        <div class="card-header px-9 py-5 border-b-[1px] border-neutral-200 mb-5">
                            <h3 class="font-bold font-quicksand">Pengajuan tiket layanan untuk <span
                                    class="text-primary-400">{{
                                        serviceId['service'] }}</span></h3>
                        </div>
                        <div class="card-body px-5 lg:px-20 py-5">
                            <form name="createForm" @submit.prevent="submit">
                                <div className="flex flex-col">
                                    <div class="flex" v-if="roleId !== '101'">
                                        <div class="flex-1 mb-4 pr-4">
                                            <BreezeLabel for="creator" value="Data Mahasiswa" />
                                            <BreezeSearchSelect
                                            class="mt-1 block w-full"
                                            v-model="form.creator"
                                            name="student"
                                            id="creator"
											placeholder="Cari Nama atau NIM Mahasiswa"
                                            label="name"
                                            apiUrl="/students/search"
                                            @selected="onStudentSelected"
                                            >
										    </BreezeSearchSelect>
                                            <!-- <BreezeInput id="creator" type="text" class="mt-1 block w-full" required
                                                v-model="form.creator" placeholder="Nomor Induk Mahasiswa"
                                                v-on:change="searchNim" /> -->
                                            <span class="text-red-600" v-if="form.errors.creator">
                                                {{ form.errors.creator }}
                                            </span>
                                            <div id="found" class="hidden mt-2">
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
                                                :modelValue="decodeText(form.creator_name)" placeholder="Nama"
                                                readonly />
                                            <span class="text-red-600" v-if="form.errors.creator_name">
                                                {{ form.errors.creator_name }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex" v-if="roleId !== '101'">
                                        <div class="flex-1 mb-4 pr-4">
                                            <BreezeInput id="major" type="text" class="mt-1 block w-full"
                                                v-model="form.major" placeholder="Program Studi" readonly />
                                            <span class="text-red-600" v-if="form.errors.major">
                                                {{ form.errors.major }}
                                            </span>
                                        </div>
                                        <div class="flex-1 mb-4 pr-4">
                                            <BreezeInput id="faculty" type="text" class="mt-1 block w-full"
                                                v-model="form.faculty" placeholder="Fakultas" readonly />
                                            <span class="text-red-600" v-if="form.errors.faculty">
                                                {{ form.errors.faculty }}
                                            </span>
                                        </div>
                                        <div class="flex-1 mb-4">
                                            <BreezeInput id="years" type="text" class="mt-1 block w-full"
                                                v-model="form.years" placeholder="Angkatan" readonly />
                                            <span class="text-red-600" v-if="form.errors.years">
                                                {{ form.errors.years }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <div class="flex-1 mb-4 pr-4">
                                            <BreezeInput id="creator_phone" type="text" class="mt-1 block w-full"
                                                required v-model="form.creator_phone" placeholder="Nomor whatsapp" />
                                            <span class="text-red-600" v-if="form.errors.creator_phone">
                                                {{ form.errors.creator_phone }}
                                            </span>
                                            <div id="can-change" class="hidden mt-2">
                                                <span
                                                    class="inline-flex items-center gap-1.5 py-1.5 pl-3 pr-2 rounded-full text-xs font-medium text-gray-500 bg-gray-200">
                                                    Dapat diubah jika tidak sesuai
                                                    <Icon class="text-xl pr-1" icon="uil:check" />
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex-1 mb-4">
                                            <BreezeInput id="creator_email" type="text" class="mt-1 block w-full"
                                                required v-model="form.creator_email" placeholder="Email" />
                                            <span class="text-red-600" v-if="form.errors.creator_email">
                                                {{ form.errors.creator_email }}
                                            </span>
                                            <div id="can-change-too" class="hidden mt-2">
                                                <span
                                                    class="inline-flex items-center gap-1.5 py-1.5 pl-3 pr-2 rounded-full text-xs font-medium text-gray-500 bg-gray-200">
                                                    Dapat diubah jika tidak sesuai
                                                    <Icon class="text-xl pr-1" icon="uil:check" />
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="flex-1 mb-4" v-if="roleId !== '101'">
                                        <BreezeLabel for="service" value="Layanan" />
                                        <BreezeInput id="service" type="text" class="mt-1 block w-full"
										v-model="form.service.name" readonly  />
                                        <!-- <BreezeSearchSelect
                                            disabled
                                            class="mt-1 block w-full"
                                            v-model="form.service"
                                            name="services"
                                            required
                                            id="service"
                                            :option="services"
                                            :custom-label="nameWithLang"
                                            placeholder="Cari layanan"
                                            v-on:select="setUnit" label="name" track-by="name">
                                        </BreezeSearchSelect> -->
                                        <span className="text-red-600" v-if="form.errors.service">
                                            {{ form.errors.service }}
                                        </span>
                                    </div>
                                    <div className="flex" v-if="roleId !== '101'">
                                        <div className="flex-1 mb-4 pr-4">
                                            <BreezeLabel for="order" value="Jenis Layanan" />
                                            <BreezeSearchSelect class="mt-1 block w-full" v-model="form.order"
                                                name="order" id="order" :option="order" :custom-label="nameWithLang"
                                                placeholder="Cari Jenis" label="name" track-by="name" disabled>
                                            </BreezeSearchSelect>
                                            <span className="text-red-600" v-if="form.errors.order">
                                                {{ form.errors.order }}
                                            </span>
                                        </div>
                                        <div className="flex-1 mb-4">
                                            <BreezeLabel for="time" value="Urgensi Layanan" />
                                            <BreezeSearchSelect
                                                class="mt-1 block w-full"
                                                v-model="form.time"
                                                name="time"
                                                required id="time"
                                                :option="time"
                                                :custom-label="nameWithLang" placeholder="Cari urgensi" label="name"
                                                track-by="name">
                                            </BreezeSearchSelect>
                                            <span className="text-red-600" v-if="form.errors.time">
                                                {{ form.errors.time }}
                                            </span>
                                        </div>
                                    </div>
                                    <div className="flex" v-if="roleId !== '101'">
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
                                                v-model="form.supervisor" placeholder="Penanggung Jawab" readonly />
                                            <span className="text-red-600" v-if="form.errors.supervisor">
                                                {{ form.errors.supervisor }}
                                            </span>
                                        </div>
                                        <div className="flex-1 mb-4">
                                            <BreezeLabel for="unit_id" value="&nbsp;" />
                                            <BreezeInput id="recipient_id" type="hidden" class="mt-1 block w-full"
                                                v-model="form.recipient_id" />
                                            <BreezeInput id="recipient" type="text" class="mt-1 block w-full"
                                                v-model="form.recipient" placeholder="Pelaksana" readonly />
                                            <span className="text-red-600" v-if="form.errors.recipient">
                                                {{ form.errors.recipient }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex" v-if="roleId !== '101'">
                                        <div class="flex-1 mb-4 pr-4">
                                            <BreezeInput id="recipient_phone" type="text" class="mt-1 block w-full"
                                                required v-model="form.recipient_phone" placeholder="Nomor whatsapp" />
                                            <span class="text-red-600" v-if="form.errors.recipient_phone">
                                                {{ form.errors.recipient_phone }}
                                            </span>
                                            <div id="can-change-tree" class="hidden mt-2">
                                                <span
                                                    class="inline-flex items-center gap-1.5 py-1.5 pl-3 pr-2 rounded-full text-xs font-medium text-gray-500 bg-gray-200">
                                                    Nomor pelaksana dapat diubah jika tidak sesuai
                                                    <Icon class="text-xl pr-1" icon="uil:check" />
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex-1 mb-4">
                                            <BreezeInput id="recipient_email" type="text" class="mt-1 block w-full"
                                                required v-model="form.recipient_email" placeholder="Email" />
                                            <span class="text-red-600" v-if="form.errors.recipient_email">
                                                {{ form.errors.recipient_email }}
                                            </span>
                                            <div id="can-change-for" class="hidden mt-2">
                                                <span
                                                    class="inline-flex items-center gap-1.5 py-1.5 pl-3 pr-2 rounded-full text-xs font-medium text-gray-500 bg-gray-200">
                                                    Email pelaksana diubah jika tidak sesuai
                                                    <Icon class="text-xl pr-1" icon="uil:check" />
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="term"
                                        class="hidden mt-2 mb-4 rounded-lg px-6 py-5 text-base bg-primary-400 text-slate-100"
                                        role="alert">
                                        A simple info alert—check it out!
                                    </div>

                                    <div className="mb-4 mt-3">
                                        <BreezeLabel for="content" class="mb-2" value="Deskripsi tiket" />
                                        <div>
                                            <CKEditor :editor="editor" v-model="form.content" :config="editorConfig"
                                                required>
                                            </CKEditor>
                                            <span v-if="form.errors.content" class="text-red-600">
                                                {{ form.errors.content }}
                                            </span>
                                        </div>
                                    </div>
                                    <div className="mb-4 mt-3">
                                        <BreezeLabel for="file" value="Files" />
                                        <DropFile v-model="form.attachment" @update:modelValue="clearAttachmentErrors" />

                                        <div v-for="(file, index) in form.attachment" :key="index">
                                            <span v-if="form.errors[`attachment.${index}`]" class="text-red-600">
                                                {{ form.errors[`attachment.${index}`] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div className="mt-4">
                                    <button type="submit" :disabled="form.processing"
                                        className="px-12 py-1.5 font-semibold text-lg text-white bg-primary-300 rounded">
                                        <span v-if="form.processing">
                                            <LoadingSpinner />
                                        </span>
                                        <span v-else>Save</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </BaseLayout>
</template>

<style>
.ck-editor__editable_inline {
    padding: 0 25px !important;
    min-height: 250px;
}
</style>
