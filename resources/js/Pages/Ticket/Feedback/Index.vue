<script setup>
import { onMounted, ref, toRefs } from 'vue'
import { useForm } from '@inertiajs/vue3'
import LoadingSpinner from '@/Components/LoadingSpinner.vue';
import { Head } from '@inertiajs/vue3';

const form = useForm({
    rating: 0,
    comment: null
})

const props = defineProps({
    ticket: Object,
    canSubmit : Boolean
});

console.log(props.canSubmit)

const { ticket } = toRefs(props)

const selected = ref(0)

const submit = () => {
    form.rating = selected.value
    form.put(`/feedback/submit/${ticket.value.id}`, {
        onSuccess: () => {
            selected.value = 0
            form.reset()
        }
    })
}

onMounted(() => {
    if (ticket.value.feedback.rating > 0) {
        selected.value = ticket.value.feedback.rating
        form.comment = ticket.value.feedback.comment
    }
})
</script>

<template>

    <Head title="Feedback" />
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-50 p-6">
        <!-- Judul Form -->
        <h1 class="text-xl font-semibold text-gray-800 text-center mb-4">Form Penilaian Layanan</h1>

        <!-- Informasi Tiket -->
        <div class="bg-white rounded-lg shadow w-full max-w-xl p-6 mb-8 space-y-2 border border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Tiket #{{ ticket.ticketNumber }} - {{
                ticket.purpose.unit.name }}</h2>
            <p class="text-sm text-gray-500">Status: <span class="text-green-600 font-medium">{{ ticket.status }}</span>
            </p>
            <p class="text-sm text-gray-500">Tanggal: 26 Juni</p>
            <p class="text-sm text-gray-700 mt-1">Permintaan: <span class="font-medium">{{ ticket.purpose.service.name
                    }}</span></p>
        </div>


        <!-- Bintang -->
        <div class="inline-flex items-center gap-2 mb-4">
            <span v-for="n in 5" :key="n" @click="!ticket.feedback?.comment && props.canSubmit ? selected = n : ''" class="cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :fill="n <= selected ? '#EAB308' : 'none'"
                    :stroke="n <= selected ? '#EAB308' : '#EAB308'" class="w-10 h-10 transition-all duration-150"
                    :class="n <= selected ? 'text-[#EAB308]' : 'text-gray-300'">
                    <path
                        d="M9.153 5.408C10.42 3.136 11.053 2 12 2s1.58 1.136 2.847 3.408l.328.588c.36.646.54.969.82 1.182s.63.292 1.33.45l.636.144c2.46.557 3.689.835 3.982 1.776c.292.94-.546 1.921-2.223 3.882l-.434.507c-.476.557-.715.836-.822 1.18c-.107.345-.071.717.001 1.46l.066.677c.253 2.617.38 3.925-.386 4.506s-1.918.051-4.22-1.009l-.597-.274c-.654-.302-.981-.452-1.328-.452s-.674.15-1.328.452l-.596.274c-2.303 1.06-3.455 1.59-4.22 1.01c-.767-.582-.64-1.89-.387-4.507l.066-.676c.072-.744.108-1.116 0-1.46c-.106-.345-.345-.624-.821-1.18l-.434-.508c-1.677-1.96-2.515-2.941-2.223-3.882S3.58 8.328 6.04 7.772l.636-.144c.699-.158 1.048-.237 1.329-.45s.46-.536.82-1.182z" />
                </svg>
            </span>
        </div>

        <p v-if="form.errors.rating" class="text-red-500 text-xs my-2">
            Rating wajib diisi
        </p>


        <!-- Keterangan -->
        <p class="text-sm text-gray-600 mb-4">Bagaimana penilaian Anda terhadap layanan ini?</p>

        <!-- Form -->
        <form @submit.prevent="submit" class="w-full max-w-xl space-y-4 mt-5">
            <!-- Textarea -->
            <div class="relative">
                <textarea v-model="form.comment" :disabled="ticket.feedback?.comment || !props.canSubmit" id="feedback" rows="5"
                    placeholder=" "
                    class="peer w-full resize-none border border-gray-300 rounded-md px-3 pt-5 pb-2 text-sm text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-primary-400 focus:border-primary-400"></textarea>
                <label for="feedback" :class="[
                    'absolute bg-white z-10 px-2 left-3 text-sm text-gray-500 transition-all',
                    form.comment ? '-top-2.5 text-sm text-primary-400' : 'top-3.5 peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400',
                    'peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-primary-400'
                ]">
                    Saran dan Kritik
                </label>

                <p v-if="form.errors.comment" class="text-red-500 text-xs mt-1">
                    Saran dan Kritik wajib diisi
                </p>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end">
                <button type="submit" v-if="!ticket.feedback?.comment && props.canSubmit"
                    class="bg-primary-300 hover:bg-primary-400 text-white font-bold text-sm px-6 py-2 rounded shadow transition duration-150"
                    :disabled="form.processing">
                    <span v-if="form.processing">
                        <LoadingSpinner />
                    </span>
                    <span v-else>
                        Submit Review
                    </span>
                </button>
            </div>
        </form>
    </div>
</template>
