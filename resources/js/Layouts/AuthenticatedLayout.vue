<script setup>
import { ref, defineProps, computed, reactive } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3'
import TitleDashboard from '@/Components/TitleDashboard.vue';
import defaultPhoto from "../../images/avatar2.png"
import { capitalize } from '@/Utils/capitalize';
import FlashModal from '@/Components/FlashModal.vue';

const page = usePage()

const user = ref(page.props.profile)

const firstName = computed(() => capitalize(user.value.fullname.split(' ')[0]));

const lastSlug = window.location.pathname.split('/')
const slugFix = lastSlug[2] == null ? lastSlug[1] : lastSlug[2]

const logout = () => {
	axios.post('/logout').then(() => {
		window.location.href = '/operator-sign-in'
	})
}

const props = defineProps({
	pageTitle: {
		type: String,
		required: false,
		default: 'Dashboard'
	}
})

// class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center gap-2 h-[3rem] w-[3rem] rounded-full font-medium text-gray-700 align-middle text-xs">
// 							<img class="inline-block h-[3rem] w-[3rem] rounded-full border border-neutral-500"
// 								src="../../images/avatar2.png" alt="Image Description">

const sidebarMenu = reactive([
	{
        title: 'Dashboard',
		accordion: false,
		accordionName: 'dashboard',
		url: '/dashboard',
		icons: 'material-symbols:team-dashboard-outline',
        rolesNav: ['101', '102', '103', '104', '105', '106'],
		child: []
	},
	{
		title: 'IT PANEL',
        rolesNav: ['102', '106'],
		accordion: true,
		accordionName: 'it-panel',
		url: 'javscript:;',
		icons: 'mingcute:switch-line',
		child: [
			{
				title: 'Person',
				url: '/dashboard/person',
				icons: 'solar:user-outline',
				disabled: false,
				rolesNav: ['101', '102', '103', '104', '105', '106']
			},
            {
				title: 'Lecturer',
				url: '/dashboard/lecturer',
				icons: 'ph:chalkboard-teacher',
				disabled: false,
				rolesNav: ['102', '106']
			},
			{
				title: 'Role',
				url: '/dashboard/role',
				icons: 'eos-icons:role-binding-outlined',
				disabled: false,
				rolesNav: ['101', '102', '103', '104', '105', '106']


			},
			// {
			// 	title: 'Modul',
			// 	url: '/dashboard/modul',
			// 	icons: 'streamline:programming-module-cube-code-module-programming-plugin',
			// 	disabled: true,
			// },
			{
				title: 'Privilege',
				url: '/dashboard/privilege',
				icons: 'icon-park-outline:checklist',
				disabled: false,
				rolesNav: ['101', '102', '103', '104', '105', '106']

			},
			{
				title: 'Unit',
				url: '/dashboard/unit',
				icons: 'tabler:shield',
				disabled: false,
				rolesNav: ['101', '102', '103', '104', '105', '106']

			},
			{
				title: 'Service',
				url: '/dashboard/service',
				icons: 'mingcute:service-line',
				disabled: false,
				rolesNav: ['101', '102', '103', '104', '105', '106']

			},
			{
				title: 'Category',
				url: '/dashboard/category',
				icons: 'iconamoon:category',
				disabled: false,
				rolesNav: ['101', '102', '103', '104', '105', '106']

			},
			{
				title: 'Recipient',
				url: '/dashboard/recipient',
				icons: 'ph:user-list',
				disabled: false,
				rolesNav: ['101', '102', '103', '104', '105', '106']

			},
			{
				title: 'Document Template',
				url: '/dashboard/document-template',
				icons: 'fluent:mail-template-24-regular',
				disabled: false,
				rolesNav: ['102', '106']

			},
		],
	},
	{
		title: 'Content',
        rolesNav: ['101', '102', '103', '104', '105', '106'],
		accordion: true,
		accordionName: 'content',
		url: 'javscript:;',
		icons: 'uil:create-dashboard',
		child: [
			{
				title: 'Ticket',
				url: '/dashboard/ticket',
				icons: 'icon-park-outline:list',
				disabled: false,
				rolesNav: ['101', '102', '103', '104', '105', '106']

			},
			{
				title: 'Document',
				url: '/dashboard/document',
				icons: 'mingcute:document-3-line',
				disabled: false,
			    rolesNav: ['102', '106']

			},
            {
				title: 'Question',
				url: '/dashboard/question',
				icons: 'mdi:chat-question-outline',
				disabled: false,
				rolesNav: ['102', '106']

			},
			// {
			// 	title: 'Cek Asset',
			// 	url: '/dashboard/asset',
			// 	icons: 'streamline:programming-browser-search-search-window-glass-app-code-programming-query-find-magnifying-apps',
			// 	disabled: true,
			// 					rolesNav: ['101', '102', '103', '104', '105', '106']

			// },
			// {
			// 	title: 'Pusaran',
			// 	url: '/dashboard/pusaran',
			// 	icons: 'octicon:report-16',
			// 	disabled: true,
			// 					rolesNav: ['101', '102', '103', '104', '105', '106']

			// }
		],
	},
	/*{
		title: 'Report',
		accordion: true,
		accordionName: 'report',
		url: 'javscript:;',
		icons: 'tabler:file-report',
		child: [
			{
				title: 'Log Ticket',
				url: '/dashboard/log-ticket',
				icons: 'majesticons:list-box-line',
				disabled: true,
								rolesNav: ['101', '102', '103', '104', '105', '106']

			},
			{
				title: 'Log System',
				url: '/dashboard/log-system',
				icons: 'mdi:pound-box-outline',
				disabled: true,
				rolesNav: ['101', '102', '103', '104', '105', '106']

			},
			{
				title: 'Log Sync',
				url: '/dashboard/log-sync',
				icons: 'fluent:cube-sync-24-regular',
				disabled: true,
				rolesNav: ['101', '102', '103', '104', '105', '106']

			},
		],
	}*/

])

const getVisibleMenu = () => {
  return sidebarMenu.filter(item => item.rolesNav.includes(user.value.role_id));
}

const visibleMenu = getVisibleMenu();

</script>

<template>

	<Head title="Dashboard" />
	<!-- Sidebar Toggle -->
	<div class="sticky top-0 inset-x-0 z-20 bg-white border-y px-4 sm:px-6 md:px-8 lg:hidden">
		<div class="flex items-center py-4">
			<!-- Navigation Toggle -->
			<button type="button" class="text-gray-500 hover:text-gray-600" data-hs-overlay="#application-sidebar"
				aria-controls="application-sidebar" aria-label="Toggle navigation">
				<span class="sr-only">Toggle Navigation</span>
				<svg class="w-5 h-5" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
					<path fill-rule="evenodd"
						d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
				</svg>
			</button>
			<!-- End Navigation Toggle -->

			<!-- Breadcrumb -->
			<ol class="ml-3 flex items-center whitespace-nowrap min-w-0" aria-label="Breadcrumb">
				<li class="flex items-center text-sm text-gray-800">
					Application Layout
					<svg class="flex-shrink-0 mx-3 overflow-visible h-2.5 w-2.5 text-gray-400" width="16" height="16"
						viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M5 1L10.6869 7.16086C10.8637 7.35239 10.8637 7.64761 10.6869 7.83914L5 14" stroke="currentColor"
							stroke-width="2" stroke-linecap="round" />
					</svg>
				</li>
				<li class="text-sm font-semibold text-gray-800 truncate" aria-current="page">
					Dashboard
				</li>
			</ol>
			<!-- End Breadcrumb -->
		</div>
	</div>
	<!-- End Sidebar Toggle -->

	<!-- Sidebar -->
	<div id="application-sidebar"
		class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform hidden fixed top-0 left-0 bottom-0 z-[60] w-64 bg-white border-r border-gray-200 pt-7 pb-10 overflow-y-auto scrollbar-y lg:block lg:translate-x-0 lg:right-auto lg:bottom-0 rounded-tr-2xl	">
		<div class="px-6">
			<Link :href="'/'">
			<img src="../../images/logo-telu-sby.png" alt="Logo SSC" />
			</Link>
		</div>

		<nav class="hs-accordion-group p-6 w-full flex flex-col flex-wrap">
			<ul class="space-y-1.5">
				<li v-for="item in visibleMenu" :key="item" class="hs-accordion"
					:class="{
						'active': item.child.some(i => i.title.replace(/\s+/g, '-').toLowerCase() == slugFix)
					}" :id="`${item.accordionName}-accordion`">
					<a :class="item.title.replace(/\s+/g, '-').toLowerCase() == slugFix ? 'bg-primary-400 text-white' : 'hover:bg-primary-400 hover:text-white'"
						class="hs-accordion-toggle flex items-center gap-x-3.5 py-2 px-2.5 text-base font-bold text-primary-300 rounded-md"
						:href="item.url">
						<Icon class="text-2xl" :icon="item.icons" />
						{{ item.title }}
						<Icon v-if="item.accordion" class="hs-accordion-active:block text-xl ml-auto hidden"
							icon="tabler:chevron-up" />
						<Icon v-if="item.accordion" class="hs-accordion-active:hidden text-xl ml-auto block"
							icon="tabler:chevron-down" />
					</a>
					<div :id="`${item.accordionName}-accordion-child`"
						class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300" :class="{
							'hidden': !item.child.some(i => i.title.replace(/\s+/g, '-').toLowerCase() == slugFix)
						}">
						<ul class="hs-accordion-group pl-3 pt-2">
							<li v-for="(itemChild) in item.child" :key="itemChild"
								class="rounded-md my-2"
								:class="itemChild.title.replace(/\s+/g, '-').toLowerCase() == slugFix ? 'bg-primary-400 text-white' : 'hover:bg-primary-400 hover:text-white text-slate-700'">
								<a v-if="itemChild.rolesNav && itemChild.rolesNav.includes(user.role_id)" :class="itemChild.disabled ? 'pointer-events-none cursor-default' : ''"
									class="flex items-center gap-x-3.5 py-2 px-2.5 hs-accordion-active:text-blue-600 text-sm"
									:href="itemChild.url">
									<Icon class="text-xl" :icon="itemChild.icons" />
									{{ itemChild.title }}
									<span v-if="itemChild.disabled"
										class="inline-flex items-center py-1 px-2 rounded-full text-xs font-medium bg-red-100 text-red-800">disabled
									</span>
								</a>
							</li>
						</ul>
					</div>
				</li>
			</ul>
		</nav>


	</div>
	<!-- End Sidebar -->

	<!-- Content -->
	<div class="w-full py-10 px-4 sm:px-6 md:px-8 lg:pl-72">
		<div class="w-full h-full fixed top-0 left-0 bg-primary-200/10 -z-10">&nbsp;</div>
        <FlashModal/>
		<div class="container mx-auto px-0 md:px-10">
			<div class="my-5 block lg:flex items-center justify-between mb-10">
				<div class="flex flex-row items-center justify-end gap-2 mb-10 lg:mb-0 lg:order-last">
					<div class="flex items-center mr-3">
						<a :href="'/'"
							class="p-2 text-xl text-primary-500 border-2 border-neutral-500 rounded-full mr-5 hover:bg-primary-400 hover:text-white hover:border-primary-400 hover:fw-bold">
							<Icon icon="teenyicons:home-outline" />
                        </a>
						<!-- <a href="#"
							class="p-2 text-xl text-primary-500 border-2 border-neutral-500 rounded-full mr-5 hover:bg-primary-400 hover:text-white hover:border-primary-400 hover:fw-bold">
							<Icon icon="streamline:layers-2" />
						</a> -->
						<p class="text-lg break-words">Semangat Pagi, {{firstName}} !</p>
					</div>
					<div class="hs-dropdown relative inline-flex [--placement:bottom-right] items-center">

						<button id="hs-dropdown-with-header" type="button"
							class="hs-dropdown-toggle inline-flex flex-shrink-0 justify-center items-center gap-2 h-[3.5rem] w-[3.5rem] rounded-full font-medium text-gray-700 align-middle text-xs">
							<img
                                class="inline-block h-[3.2rem] w-[3.2rem] rounded-full object-cover border border-neutral-500"
                                :src="user.photo || defaultPhoto"
                                alt="Image Description">
						</button>

						<div
							class="hs-dropdown-menu bg-white transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-[15rem]  shadow-md rounded-lg p-2 border border-neutral-500"
							aria-labelledby="hs-dropdown-with-header">
                            <div class="py-2 px-2 -m-2 bg-white rounded-t-lg border-b border-neutral-200">
                                <a href="/profile" class="flex cursor-pointer items-center gap-x-3.5 py-2 px-3 rounded-md text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500">
                                    <Icon icon="healthicons:ui-user-profile" class="text-lg" />
                                    <p class="text-sm text-gray-800">Profil Saya</p>
                                </a>
                            </div>
							<!-- <div class="py-3 px-5 -m-2 bg-white rounded-t-lg border-b border-neutral-200">
								<p class="text-sm text-gray-500">Signed in as</p>
								<p class="text-sm font-medium text-gray-800">{{ user.nim }}</p>
							</div> -->
							<div class="mt-2 py-2 first:pt-0 last:pb-0">
								<a class="flex cursor-pointer items-center gap-x-3.5 py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500"
									@click="logout">
									<Icon icon="ic:round-logout" />
									Logout
								</a>
							</div>
						</div>
					</div>
				</div>
				<TitleDashboard :title="props.pageTitle"/>
			</div>
			<slot></slot>
		</div>

	</div>
</template>

<style>
.qrcode {
	display: inline-block;
	font-size: 0;
	margin-bottom: 0;
	position: relative;
}

.qrcode__image {
	background-color: #fff;
	border: 0.25rem solid #fff;
	border-radius: 0.25rem;
	box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.25);
	height: 25%;
	width: 20%;
	left: 50%;
	top: 50%;
	overflow: hidden;
	position: absolute;
	transform: translate(-50%, -50%);
}
</style>
