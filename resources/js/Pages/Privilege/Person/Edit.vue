<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import BreezeSearchSelect from '@/Components/SearchSelect.vue';
import BreezeLabel from '@/Components/InputLabel.vue';
import BreezeInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
const props = defineProps({
    data: Object,
    roles : Object
});

const form = useForm({
    person : props.data.person,
    role: {
        id: props.data.roles.id,
        name: props.data.roles.role
    },
    active: props.data.active,
    updatedby: '999',
});

const submit = () => {
    form.put(route('privilege.update', props.data.id));
};
</script>


<template>

    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit privilege
            </h2>
        </template>
        <div class="">
            <div class="mx-auto sm:px-6 lg:px-3">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div className="flex items-center justify-between mb-6">
                            <div class="">
                                <h3 class="text-primary-400 text-center">Edit Privilege</h3>
                            </div>
                            <Link className="px-6 py-2 text-white bg-primary-300 rounded-md focus:outline-none"
                                :href="route('privilege')">
                            Back
                            </Link>
                        </div>
                        <form name="createForm" @submit.prevent="submit">
                            <div className="grid grid-cols-2 gap-x-3">
                                <div className="mb-4">
                                    <BreezeLabel for="privilege" value="Nama" />
                                    <BreezeInput id="privilege" type="text" class="mt-1 block w-full"
                                        v-model="form.person" autofocus readonly />
                                    <span className="text-red-600" v-if="form.errors.person">
                                        {{ form.errors.person }}
                                    </span>
                                </div>
                                <div className="mb-4">
                                    <BreezeLabel for="privilege" value="Privileges" />
                                    <BreezeSearchSelect
                                        class="mt-1 block w-full"
                                        v-model="form.role"
                                        id="roles"
                                        name="roles"
                                        :option="props.roles"
                                        placeholder="Cari Role"
                                        label="name"
                                        track-by="name">
                                    </BreezeSearchSelect>
                                    <span className="text-red-600" v-if="form.errors.role">
                                        {{ form.errors.role }}
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
