<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

const props = defineProps({
    person: Object,
    unit: Array
});

const pageTitle = ref('Person');

const per_group = [
    { id: 'MAHASISWA', name: 'Mahasiswa' },
    // { id: 'DOSEN', name: 'Dosen' },
    { id: 'PEGAWAI', name: 'Pegawai' },
];

const unit_position = [
    { id: 1, name: 'Pegawai' },
    { id: 2, name: 'Ketua Prodi' },
    { id: 3, name: 'Kepala Urusan' },
    { id: 4, name: 'Kepala Bagian' },
];

const form = useForm({
    person: props.person.person,
    per_num: props.person.per_num,
    per_id: props.person.per_id,
    per_phone: props.person.per_phone,
    per_email: props.person.per_email,
    per_group: props.person.per_group,
    per_major: props.person.per_major,
    per_years : props.person.per_years,
    per_unit: {
        id: props.person.unit_id,
        name: props.person.unit_name,
    },
    unit_position: {
        id: 1,
        name: props.person.unit_position,
    },
    password: props.person.password,
    oldpassword: props.person.password,
    active: props.person.active,
    createdby: props.person.createdby,
    updatedby: '999',
    active: props.person.active,
    createdby: props.person.createdby,
    updatedby: 'me',
});

const submit = () => {
    form.put(route('person.update', props.person.id));
};
</script>
<template>

    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout :page-title="pageTitle">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit person
            </h2>
        </template>
        <div>
            <div class="mx-auto sm:px-6 lg:px-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-between mb-6">
                            <div class="">
                                <h3 class="text-primary-400 text-center">Edit Person</h3>
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
                                        :class="[form.per_group === 'MAHASISWA' ? 'w-fit' : 'w-full']">
                                        <BreezeLabel for="per_group" value="Group" />
                                        <BreezeInput id="per_group" type="text" class="mt-1 block w-full"
                                        v-model="form.per_group" autofocus readonly />
                                        <span className="text-red-600" v-if="form.errors.per_group">
                                            {{ form.errors.per_group }}
                                        </span>
                                    </section>

                                    <section v-if="form.per_group === 'MAHASISWA'" class="mb-4 w-1/2">
                                        <BreezeLabel for="per_major" value="Program Studi" />
                                        <BreezeInput id="per_major" type="text" class="mt-1 block w-full"
                                        v-model="form.per_major" autofocus readonly />
                                        <span className="text-red-600" v-if="form.errors.per_major">
                                            {{ form.errors.per_major }}
                                        </span>
                                    </section>

                                    <section v-if="form.per_group === 'MAHASISWA'">
                                        <BreezeLabel for="per_year" value="Tahun Angkatan" />
                                        <BreezeInput id="per_year" type="text" class="mt-1 block w-full"
                                            v-model="form.per_years"
                                            readonly
                                            />
                                        <span className="text-red-600" v-if="form.errors.per_years">
                                            {{ form.errors.per_years }}
                                        </span>
                                    </section>
                                </div>

                                <div v-if="form.per_group === 'PEGAWAI'"
                                    class="flex justify-center items-center gap-x-5">
                                    <div className="mb-4 w-1/2">
                                        <BreezeLabel for="per_unit" value="Unit" />
                                        <BreezeSearchSelect class="mt-1 block w-full" v-model="form.per_unit"
                                            name="units" id="service" :option="props.unit" :custom-label="nameWithLang"
                                            placeholder="Cari unit" label="name" track-by="name">
                                        </BreezeSearchSelect>
                                    </div>

                                    <div className="mb-4 w-1/2">
                                        <BreezeLabel for="unit_position" value="Position" />
                                        <BreezeSearchSelect class="mt-1 block w-full" v-model="form.unit_position"
                                            name="unit position" id="service" :option="unit_position"
                                            :custom-label="nameWithLang" placeholder="Cari Posisi" label="name"
                                            track-by="name">
                                        </BreezeSearchSelect>
                                    </div>
                                </div>
                                <div className="mb-4">
                                    <BreezeLabel for="password" value="New Password" />
                                    <BreezeInput id="oldpassword" type="hidden" class="mt-1 block w-full"
                                        v-model="form.password" autofocus />
                                    <BreezeInput id="password" type="text" class="mt-1 block w-full"
                                        v-model="form.password" value="" autofocus />
                                    <small class="italic">*Kosongkan kolom ini, jika tidak ingin di ubah</small>
                                    <span className="text-red-600" v-if="form.errors.password">
                                        {{ form.errors.password }}
                                    </span>
                                </div>
                                <div className="mb-4">
                                    <BreezeLabel for="active-status" value="Active Status" />
                                    <div class="flex items-center mt-3">
                                        <label class="text-sm font-semibold text-primary-400 mr-3">Off</label>
                                        <input type="checkbox" :checked="form.active == 'Y'" id="active-status"
                                            class="switch-status">
                                        <label class="text-sm font-semibold text-primary-400 ml-3">On</label>
                                    </div>
                                    <span className="text-red-600" v-if="form.errors.active">
                                        {{ form.errors.active }}
                                    </span>
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
