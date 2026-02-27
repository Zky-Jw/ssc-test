<script setup>
import { inject } from 'vue'
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Navbar from '@/Components/Navbar.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { Icon } from '@iconify/vue';
// import CryptoJS from 'crypto-js';

const captchaImage = ref(null)

const loadCaptcha = async () => {
  const res = await axios.get('/captcha', { responseType: 'blob' });
  const imageUrl = URL.createObjectURL(res.data);
  captchaImage.value = imageUrl;
}

const refreshCaptcha = () => {
  loadCaptcha()
  form.captcha = ""
}

// const cryptojs = inject('cryptojs');

defineProps({
	canResetPassword: {
		type: Boolean,
	},
	status: {
		type: String,
	},
});

const form = useForm({
	username: '',
	password: '',
    captcha : '',
	remember: false,
});


// const form = useForm({
// 	email: '',
// 	password: '',
// 	remember: false,
// });

const submit = () => {
	// const oldpass = form.password;
	// form.password = CryptoJS.MD5(form.password).toString()
	// console.log([form.username, oldpass, form.password]);
	form.post(route('login'), {
		onSuccess: () => form.reset(),
        onFinish : () => refreshCaptcha()
	});
};

onMounted(() => {
  loadCaptcha()
})
</script>

<template>
	<GuestLayout>
		<Head title="Log in" />
		<div class="mb-7">
			<h2 class="">Log In</h2>
			<p class="text-sm font-normal">Student Service Center</p>
		</div>


		<div v-if="status" class="mb-4 font-medium text-sm text-green-600">
			{{ status }}
		</div>

		<form @submit.prevent="submit">
			<div>
				<TextInput id="username" type="username" class="mt-1 block w-full bg-slate-200 py-3 px-5"
					placeholder="Username" v-model="form.username" required autofocus
					autocomplete="username" />

				<InputError class="mt-2" :message="form.errors.username" />

				<!-- <TextInput id="email" type="email" class="mt-1 block w-full bg-slate-200 py-3 px-5"
					placeholder="email" v-model="form.email" required autofocus
					autocomplete="email" />

				<InputError class="mt-2" :message="form.errors.email" /> -->
			</div>

			<div class="mt-4">
				<TextInput id="password" type="password" class="mt-1 block w-full bg-slate-200 py-3 px-5"
					placeholder="Password" v-model="form.password" required autofocus
					autocomplete="password" />

				<InputError class="mt-2" :message="form.errors.password" />
			</div>

            <div class="mt-4">
                <section class="flex items-center gap-x-4">
                    <img :src="captchaImage" @click="refreshCaptcha" alt="Captcha" />
                    <Icon icon="material-symbols:refresh-rounded" class="size-8 text-slate-400 cursor-pointer border-2 rounded-full" @click="refreshCaptcha" />
                </section>
                <TextInput id="captcha" type="text" class="mt-4 block w-full bg-slate-200 py-3 px-5"
                        placeholder="Masukkan huruf di atas" v-model="form.captcha" required autofocus />
                <InputError class="mt-2" :message="form.errors.captcha" />
            </div>


			<div class="block mt-4">
				<label class="flex items-center">
					<Checkbox class="accent-gray-700 cursor-pointer" name="remember" v-model:checked="form.remember" />
					<span class="ml-2 text-sm text-gray-600">Remember</span>
				</label>
			</div>

			<div class="flex flex-col mt-9">
				<PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
					Login
				</PrimaryButton>
				<Link href="/" class="my-5">
					<p class="text-base text-center text-primary-300">Back to home</p>
				</Link>
			</div>
		</form>
	</GuestLayout>
</template>

<style>
	[type='checkbox']:checked, [type='radio']:checked {
		background-color: #6D263C;
	}
	[type='checkbox']:checked:hover, [type='checkbox']:checked:focus, [type='radio']:checked:hover, [type='radio']:checked:focus {
    background-color: #6D263C;
	}
</style>
