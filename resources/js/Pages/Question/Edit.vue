<script setup>
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { component as CKEditor } from '@ckeditor/ckeditor5-vue';
import { toRefs, ref } from 'vue';

const pageTitle = ref('Question');

const props = defineProps({
    question : Object,
    services: Array,
    units : Array
})

const { services, question, units } = toRefs(props)

const form = useForm({
    title: question.value.title,
    date: question.value.date ? new Date(question.value.date).toISOString().slice(0, 10) : new Date(question.value.created_at).toISOString().slice(0, 10),
    service: question.value.category.service,
    unit: question.value.category.unit,
    question: question.value.question,
    answer: question.value.answer
});

const editor = ClassicEditor;

const editorConfig = ref({
    placeholder: 'Masukkan pertanyaan',
    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
    height: '200px',
})

const answerEditorConfig = ref({
    placeholder: 'Masukkan jawaban',
    toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
    height: '200px',
})

const selectedService = (e) => {
    axios.get('/get-json-service-by-id/' + e.id)
        .then((response) => {
            if (response.data.code == 200) {
                const { data } = response.data;
                const {
                    unit,
                    unit_id,
                } = data;

                form.unit = {
                    id: unit_id,
                    name: unit,
                }
            } else if (response.data.code == 404) {
                form.unit = {
                    id: '',
                    name: '',
                }
            }
        });
}

const submit = () => {
    form.put(route('question.update', question.value._id));
};
</script>

<template>

    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout :page-title="pageTitle">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Question
            </h2>
        </template>
        <div class="">
            <div class="mx-auto sm:px-6 lg:px-3">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-between mb-6">
                            <div class="">
                                <h3 class="text-primary-400 text-center">Edit Question</h3>
                            </div>
                            <Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none"
                                :href="route('question.index')">
                            Back
                            </Link>
                        </div>
                        <form name="createForm" @submit.prevent="submit">
                            <div className="flex flex-col">
                                <div class="flex gap-x-4">
                                    <div class="mb-4 w-1/2">
                                        <BreezeLabel for="title" value="Title" />
                                        <BreezeInput id="title" type="text" class="mt-1 block w-full"
                                            v-model="form.title" />
                                        <span class="text-red-600" v-if="form.errors.title">
                                            {{ form.errors.title }}
                                        </span>
                                    </div>
                                    <div class="mb-4 w-1/2">
                                        <BreezeLabel for="tanggal" value="Tanggal" />
                                        <BreezeInput id="tanggal" type="date" class="mt-1 block w-full"
                                            v-model="form.date" />
                                        <span class="text-red-600" v-if="form.errors.date">
                                            {{ form.errors.date }}
                                        </span>
                                    </div>
                                </div>
                                <div className="flex">
                                    <div className="flex-1 mb-4 pr-4">
                                        <BreezeLabel for="service" value="Layanan" />
                                        <BreezeSearchSelect class="mt-1 block w-full" v-model="form.service"
                                            name="services" id="service" :option="services" :custom-label="nameWithLang"
                                            placeholder="Cari layanan" v-on:select="selectedService" label="name"
                                            track-by="name">
                                        </BreezeSearchSelect>
                                        <span className="text-red-600" v-if="form.errors.service">
                                            {{ form.errors.service }}
                                        </span>
                                    </div>
                                    <div className="flex-1 mb-4">
                                        <BreezeLabel for="unit" value="Unit" />
                                        <BreezeSearchSelect
                                            class="mt-1 block w-full"
                                            v-model="form.unit"
                                            name="units"
                                            id="units"
                                            :option="units"
                                            :custom-label="nameWithLang"
                                            placeholder="Cari Unit"
                                            label="name"
                                            track-by="name">
                                        </BreezeSearchSelect>
                                        <span className="text-red-600" v-if="form.errors.unit">
                                            {{ form.errors.unit }}
                                        </span>
                                    </div>
                                </div>

                                <div className="mb-4 mt-3">
                                    <BreezeLabel for="question" class="mb-2" value="Pertanyaan" />
                                    <div class="flex flex-col ckeditor-question">
                                        <CKEditor
                                            :editor="editor"
                                            v-model="form.question"
                                            :config="editorConfig">
                                        </CKEditor>
                                        <span class="text-red-600" v-if="form.errors.question">
                                            {{ form.errors.question }}
                                        </span>
                                    </div>
                                </div>

                                <div className="mb-4 mt-3">
                                    <BreezeLabel for="jawaban" class="mb-2" value="Jawaban" />
                                    <div class="flex flex-col ckeditor-answer">
                                        <CKEditor
                                            :editor="editor"
                                            v-model="form.answer"
                                            :config="answerEditorConfig">
                                        </CKEditor>
                                        <span class="text-red-600" v-if="form.errors.answer">
                                            {{ form.errors.answer }}
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

<style scoped>
.ckeditor-question :deep(.ck-editor__editable) {
    min-height: 200px !important;
}

.ckeditor-answer :deep(.ck-editor__editable) {
    min-height: 200px !important;
}
</style>

