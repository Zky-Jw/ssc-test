<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

const props = defineProps({
    lecturer: Object,
});

const pageTitle = ref('Lecturer');

const unit_position = [
    { id: 1, name: 'Pegawai' },
    { id: 2, name: 'Ketua Prodi' },
    { id: 3, name: 'Kepala Urusan' },
    { id: 4, name: 'Kepala Bagian' },
];

const form = useForm({
    person: props.lecturer.person,
    per_num: props.lecturer.per_num,
    per_id: props.lecturer.per_id,
    per_phone: props.lecturer.per_phone,
    per_email: props.lecturer.per_email,
    per_group: props.lecturer.per_group,
    per_unit: props.lecturer.unit,
    unit_position: props.lecturer.position,
    password: props.lecturer.password,
    oldpassword: props.lecturer.password,
    active: props.lecturer.active,
    createdby: props.lecturer.createdby,
    updatedby: '999',
    active: props.lecturer.active,
    createdby: props.lecturer.createdby,
    updatedby: 'me',
});
</script>

<template>

    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout :page-title="pageTitle">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                lecturer detail
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
                                    <BreezeInput id="person" readonly type="text" class="mt-1 block w-full" v-model="form.person"
                                        autofocus />
                                    <span className="text-red-600" v-if="form.errors.person">
                                        {{ form.errors.person }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 gap-x-5 mb-4">
                                    <section>
                                        <BreezeLabel for="per_num" value="NIM/NIP" />
                                        <BreezeInput id="per_num" readonly type="number" class="mt-1 block w-full"
                                            v-model="form.per_num" autofocus />
                                        <span className="text-red-600" v-if="form.errors.per_num">
                                            {{ form.errors.per_num }}
                                        </span>
                                    </section>

                                    <section>
                                        <BreezeLabel for="per_id" value="Username SSO" />
                                        <BreezeInput id="per_id" readonly type="text" class="mt-1 block w-full"
                                            v-model="form.per_id" autofocus />
                                        <span className="text-red-600" v-if="form.errors.per_id">
                                            {{ form.errors.per_id }}
                                        </span>
                                    </section>
                                </div>
                                <div class="grid grid-cols-2 gap-x-5 mb-4">
                                    <section>
                                        <BreezeLabel for="per_phone" value="No. HP" />
                                        <BreezeInput id="per_phone" readonly type="text" class="mt-1 block w-full"
                                            v-model="form.per_phone" autofocus />
                                        <span className="text-red-600" v-if="form.errors.per_phone">
                                            {{ form.errors.per_phone }}
                                        </span>
                                    </section>

                                    <section>
                                        <BreezeLabel for="per_email" value="Email" />
                                        <BreezeInput id="per_email" readonly type="text" class="mt-1 block w-full"
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
                                </div>

                                <div v-if="form.per_group === 'PEGAWAI'"
                                    class="flex justify-center items-center gap-x-5">
                                    <div className="mb-4 w-1/2">
                                        <BreezeLabel for="per_unit" value="Unit" />
                                        <BreezeInput id="per_unit"  readonly type="text" class="mt-1 block w-full"
                                            v-model="form.per_unit" autofocus />
                                    </div>

                                    <div className="mb-4 w-1/2">
                                        <BreezeLabel for="unit_position" value="Position" />
                                        <BreezeInput id="unit_positon" readonly type="text" class="mt-1 block w-full"
                                        v-model="form.unit_position" autofocus />
                                    </div>
                                </div>
                                <div className="mb-4">
                                    <BreezeLabel for="active-status" value="Active Status" />
                                    <div class="flex items-center mt-3">
                                        <label class="text-sm font-semibold text-primary-400 mr-3">Off</label>
                                        <input type="checkbox" disabled :checked="form.active == 'Y'" id="active-status"
                                            class="switch-status">
                                        <label class="text-sm font-semibold text-primary-400 ml-3">On</label>
                                    </div>
                                    <span className="text-red-600" v-if="form.errors.active">
                                        {{ form.errors.active }}
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
