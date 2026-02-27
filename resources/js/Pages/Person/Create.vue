<script setup>
import { ref, watchEffect } from 'vue';
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeTextArea from '@/Components/Textarea.vue';
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const pageTitle = ref('Person');

const props = defineProps({
    major: Array
})

const per_group = [
    { id: 'MAHASISWA', name: 'Mahasiswa' },
    { id: 'PEGAWAI', name: 'Pegawai' },
];

const form = useForm({
    person: '',
    per_num: '',
    per_id: '',
    per_phone: '',
    per_email: '',
    per_group: '',
    per_major: '',
    per_years : '',
    active: 'Y',
    createdby: '999',
});

const submit = () => {
    form.post(route('person.store'));
};
</script>
<template>

    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout :page-title="pageTitle">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create person
            </h2>
        </template>
        <div>
            <div class="mx-auto sm:px-6 lg:px-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-between mb-6">
                            <div class="">
                                <h3 class="text-primary-400 text-center">Create Person</h3>
                            </div>
                            <Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none"
                                :href="route('person.index')">
                            Back
                            </Link>
                        </div>
                        <form name="createForm" @submit.prevent="submit">
                            <div className="flex flex-col">
                                <div className="mb-4">
                                    <BreezeLabel for="person" value="Nama" />
                                    <BreezeInput id="person" type="text" class="mt-1 block w-full" v-model="form.person"
                                        autofocus />
                                    <span className="text-red-600" v-if="form.errors.person">
                                        {{ form.errors.person }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 gap-x-5 mb-4">
                                    <section>
                                        <BreezeLabel for="per_num" value="NIM/NIP" />
                                        <BreezeInput id="per_num" type="number" class="mt-1 block w-full"
                                            v-model="form.per_num" autofocus />
                                        <span className="text-red-600" v-if="form.errors.per_num">
                                            {{ form.errors.per_num }}
                                        </span>
                                    </section>

                                    <section>
                                        <BreezeLabel for="per_id" value="Username SSO" />
                                        <BreezeInput id="per_id" type="text" class="mt-1 block w-full"
                                            v-model="form.per_id" autofocus />
                                        <span className="text-red-600" v-if="form.errors.per_id">
                                            {{ form.errors.per_id }}
                                        </span>
                                    </section>
                                </div>
                                <div class="grid grid-cols-2 gap-x-5 mb-4">
                                    <section>
                                        <BreezeLabel for="per_phone" value="No. HP" />
                                        <BreezeInput id="per_phone" type="text" class="mt-1 block w-full"
                                            v-model="form.per_phone" autofocus />
                                        <span className="text-red-600" v-if="form.errors.per_phone">
                                            {{ form.errors.per_phone }}
                                        </span>
                                    </section>

                                    <section>
                                        <BreezeLabel for="per_email" value="Email" />
                                        <BreezeInput id="per_email" type="text" class="mt-1 block w-full"
                                            v-model="form.per_email" autofocus />
                                        <span className="text-red-600" v-if="form.errors.per_email">
                                            {{ form.errors.per_email }}
                                        </span>
                                    </section>
                                </div>
                                <div class="flex gap-x-5 mb-4">
                                    <section
                                    class="mb-4"
                                        :class="[form.per_group.name === 'Mahasiswa' ? 'w-fit' : 'w-full']">
                                        <BreezeLabel for="per_group" value="Group" />
                                        <BreezeSearchSelect class="mt-1 block w-full" v-model="form.per_group"
                                            name="per_group" id="per_group" :option="per_group"
                                            :custom-label="nameWithLang" placeholder="Cari Jenis" label="name"
                                            track-by="name">
                                        </BreezeSearchSelect>
                                        <span className="text-red-600" v-if="form.errors.per_group">
                                            {{ form.errors.per_group }}
                                        </span>
                                    </section>

                                    <section v-if="form.per_group.name === 'Mahasiswa'" class="mb-4 w-1/2">
                                        <BreezeLabel for="per_major" value="Program Studi" />
                                        <BreezeSearchSelect class="mt-1 block w-full" v-model="form.per_major"
                                            name="units" id="per_major" :option="major" :custom-label="nameWithLang"
                                            placeholder="Cari Jenis" label="name" track-by="name">
                                        </BreezeSearchSelect>
                                        <span className="text-red-600" v-if="form.errors.per_major">
                                            {{ form.errors.per_major }}
                                        </span>
                                    </section>

                                    <section v-if="form.per_group.name === 'Mahasiswa'">
                                        <BreezeLabel for="per_year" value="Tahun Angkatan" />
                                        <BreezeInput id="per_year" type="text" class="mt-1 block w-full"
                                            v-model="form.per_years" autofocus />
                                        <span className="text-red-600" v-if="form.errors.per_years">
                                            {{ form.errors.per_years }}
                                        </span>
                                    </section>
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
