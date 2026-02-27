<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    units: Array,
});

const form = useForm({ id: '' });

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route('units.destroy', id));
    }
}

</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create or just look for the unit
            </h2>
        </template>

        <div class="">
            <div class="mx-auto sm:px-6 lg:px-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <div className="flex items-center justify-between mb-6">
                            <Link className="px-6 py-2 text-white bg-green-500 rounded-md focus:outline-none"
                                :href="route('units.create')">
                            Create Unit
                            </Link>
                        </div>

                        <table className="table-fixed w-full">
                            <thead>
                                <tr className="bg-gray-100">
                                    <th className="px-4 py-2 w-20">No.</th>
                                    <th className="px-4 py-2">Name</th>
                                    <th className="px-4 py-2">Anagram</th>
                                    <th className="px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(post, key) in units" :key="post">
                                    <td class="px-3 py-4 text-center whitespace-nowrap text-sm font-medium text-gray-800 ">
														{{ key + 1 }}</td>
                                    <td className="border px-4 py-2">{{ post.unit }}</td>
                                    <td className="border px-4 py-2">{{ post.anagram }}</td>
                                    <td className="border px-4 py-2">
                                        <Link tabIndex="1" className="px-4 py-2 text-sm text-white bg-blue-500 rounded"
                                            :href="route('units.edit', post.id)">
                                        Edit
                                        </Link>

                                        <button @click="destroy(post.id)" tabIndex="-1" type="button"
                                            className="mx-1 px-4 py-2 text-sm text-white bg-red-500 rounded">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>