<script setup>
import Logo from '../../img/logo_SSC.svg'
import NavLink from '@/Components/NavLink.vue'
import Modal from './Modal.vue';
import { Link } from '@inertiajs/vue3';

import { usePage } from '@inertiajs/vue3';

import { reactive, onMounted, onUnmounted, computed } from 'vue'

const state = reactive({ show: false })

const page = usePage()

const isLogin = computed(() => page.props.auth.user)

onMounted(() => window.addEventListener('resize', resetModal))

onUnmounted(() => document.removeEventListener('resize', resetModal))

function resetModal() {
	state.show = false
}

function toggleShow() {
	state.show = !state.show
}

const logout = () => {
	axios.post('/logout').then(() => {
		window.location.href = '/operator-sign-in'
	})
}

</script>

<template>
	<div :class="isLogin == true ? 'bg-white py-4 md:py-4' : 'py-6 md:py-6'"
		class="flex justify-between items-center px-7 md:px-24">
		<Link href="/">
		<img :src="Logo" alt="Logo SSC" />
		</Link>


		<ul class="hidden lg:flex gap-x-16 lg:items-center">
			<li>
				<NavLink :href="'/'" data-text="Beranda">Beranda</NavLink>
			</li>
			<li>
				<NavLink :href="'/tentang-kami'" data-text="Tentang Kami">Tentang Kami</NavLink>
			</li>
			<!-- <li>
				<NavLink :href="'#pusaran'" data-text="Pusaran">Pusaran</NavLink>
			</li>
			<li>
				<NavLink :href="'#direktori'" data-text="Direktori">Direktori</NavLink>
			</li> -->

			<li>
				<NavLink :href="'/layanan-mandiri'" data-text="Layanan Online">Layanan Online</NavLink>
			</li>
			<li>
				<NavLink :href="'/riwayat-pengajuan'" data-text="Histori">Histori</NavLink>
			</li>
			<li v-show="!isLogin">
				<Link :href="'/operator-sign-in'"
					class="flex items-center px-5 py-1 border-2 border-primary-400 text-primary-400 rounded hover:bg-primary-400 hover:text-white font-bold">
				<Icon icon="mdi:user-outline" class="mr-2 text-lg" /> Login
				</Link>
			</li>
			<li v-show="isLogin">
				<button @click="logout"
					class="flex items-center px-5 py-1 border-2 border-primary-400 text-primary-400 rounded hover:bg-primary-400 hover:text-white font-bold">
					<Icon icon="mdi:logout" class="mr-2 text-lg" /> Logout
				</button>
			</li>
		</ul>
		<!-- <div v-show="isLogin">
			<img class="h-auto max-w-full w-14" src="../../images/avatar2.png" alt="">
		</div> -->

		<svg v-show="!isLogin" @click="toggleShow" class="block lg:hidden" width="30" height="30" viewBox="0 0 15 15"
			fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M1.875 7.5H13.125M1.875 3.75H13.125M1.875 11.25H13.125" stroke="#121926" stroke-width="1.2"
				stroke-linecap="round" stroke-linejoin="round" />
		</svg>
		<Modal :show="state.show">
			<div class="px-7 md:px-24 pt-6 md:pt-12">
				<div class="flex justify-between items-center">
					<img :src="Logo" alt="Logo SSC" />
					<svg v-show="!isLogin" @click="toggleShow" class="block lg:hidden" width="30" height="30"
						viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M1.875 7.5H13.125M1.875 3.75H13.125M1.875 11.25H13.125" stroke="#121926"
							stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
					</svg>
				</div>
				<ul v-show="!isLogin" class="flex flex-col justify-center">
					<li class="my-1.5">
						<NavLink :href="'#beranda'" data-text="Beranda">Beranda</NavLink>
					</li>
					<li class="my-1.5">
						<NavLink :href="'/tentang-kami'" data-text="Tentang Kami">Tentang Kami</NavLink>
					</li>
					<!-- <li>
						<NavLink :href="'#pusaran'" data-text="Pusaran">Pusaran</NavLink>
					</li>
					<li>
						<NavLink :href="'#direktori'" data-text="Direktori">Direktori</NavLink>
					</li> -->

					<li class="my-1.5">
						<NavLink :href="'/layanan-mandiri'" data-text="Layanan Online">Layanan Online</NavLink>
					</li>
					<!-- <li class="my-1.5">
						<NavLink :href="'#histori'" data-text="Histori">Histori</NavLink>
					</li> -->
					<!-- <li class="w-max my-1.5">
						<Link :href="'/login'"
							class="flex items-center px-5 py-1 border-2 border-primary-400 text-primary-400 rounded hover:bg-primary-400 hover:text-white font-bold">
						<Icon icon="mdi:user-outline" class="mr-2 text-lg" /> Login
						</Link>
					</li> -->
				</ul>
			</div>
		</Modal>
	</div>
</template>
