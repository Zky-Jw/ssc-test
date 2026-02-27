<script setup>
import { defineProps, ref } from 'vue';
import { Icon } from '@iconify/vue';

const props = defineProps({
    return: Boolean,
    ticket: Array,
    person: Array,
    document: Array,
});
</script>

<template>
    <div class="py-14 bg-slate-200 h-full min-h-screen">
        <div class="container mx-auto">
            <!-- Start Confirmation Page -->
            <Section class="max-w-2xl py-8 mx-auto bg-white relative">
                <header class="px-8">
                    <img class="object-scale-down w-32 h-24" src="../../../images/logo-kop-surat.png" alt="">
                </header>
                <main class="mt-5 mb-20 px-8" v-if="props.return === true">
                    <div class="w-[67%]">
                        <h3 class="font-extrabold font-serif">Validasi {{ document.template.name }} Institut Teknologi
                            Telkom Surabaya</h3>
                    </div>
                    <div class="my-5">
                        <p class="text-base font-serif font-light">Dokumen digital dan atau cetak ini dapat dijadikan
                            sebagai alat bukti yang sah, format dan isi telah sesuai dengan ketentuan yang berlaku sejak
                            disahkan, dan secara otomatis terdaftar dan terdokumentasi dalam sistem Student Service Center
                            dengan detail berikut:</p>
                    </div>
                    <div class="border-b-2 border-gray-300 py-1">
                        <p class="font-semibold">Profil User</p>
                    </div>
                    <table class="table-auto mt-2 mb-5">
                        <tbody>
                            <tr>
                                <td class="text-base font-normal mb-2">Nomer Tiket</td>
                                <td class="pl-20">:</td>
                                <td class="text-base font-normal pl-10">{{ ticket.ticketNumber }}</td>
                            </tr>
                            <tr>
                                <td class="text-base font-normal mb-2">NIM</td>
                                <td class="pl-20">:</td>
                                <td class="text-base font-normal pl-10">{{ ticket.person.creator.id }}</td>
                            </tr>
                            <tr>
                                <td class="text-base font-normal mb-2">Nama</td>
                                <td class="pl-20">:</td>
                                <td class="text-base font-normal pl-10">{{ ticket.person.creator.name }}</td>
                            </tr>
                            <tr>
                                <td class="text-base font-normal mb-2">Program Studi</td>
                                <td class="pl-20">:</td>
                                <td class="text-base font-normal pl-10">{{ ticket.person.creator.major }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="border-b-2 border-gray-300 py-1">
                        <p class="font-semibold">Informasi</p>
                    </div>
                    <table class="table-auto mt-2 mb-5">
                        <tbody>
                            <tr>
                                <td class="text-base font-normal mb-2">Tanggal Pembuatan Dokumen</td>
                                <td class="pl-10 pr-2">:</td>
                                <td class="text-base font-normal pl-10">{{ $dateFormatIndo(document.created.at) }}</td>
                            </tr>
                            <tr>
                                <td class="text-base font-normal mb-2">Pembuat Dokumen</td>
                                <td class="pl-10 pr-2">:</td>
                                <td class="text-base font-normal pl-10">{{ document.created.by.name }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="border-b-2 border-gray-300 py-1">
                        <p class="font-semibold">Validasi</p>
                    </div>
                    <table class="table-auto mt-2 mb-5">
                        <tbody>
                            <tr>
                                <td class="text-base font-normal mb-2">Telah ditandatangi</td>
                                <td class="pl-10 pr-2">:</td>
                                <td class="text-base font-normal pl-10">{{ person.name }}</td>
                            </tr>
                            <tr>
                                <td class="text-base font-normal mb-2">Selaku</td>
                                <td class="pl-10 pr-2">:</td>
                                <td class="text-base font-normal pl-10">{{ person.position }}</td>
                            </tr>
                            <tr>
                                <td class="text-base font-normal mb-2">Ditandatangani pada</td>
                                <td class="pl-10 pr-2">:</td>
                                <td class="text-base font-normal pl-10">{{ $dateFormatIndo(person.approved.time) }}</td>
                            </tr>
                            <tr>
                                <td class="text-base font-normal mb-2">Kode token</td>
                                <td class="pl-10 pr-2">:</td>
                                <td class="text-base font-normal pl-10">{{ person.approved.token }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="my-5">
                        <p class="text-base font-serif font-light">Demikian dokumen ini dibuat sebenar-benarnya dan untuk
                            dipegunakan sesuai dengan fungsinya.</p>
                    </div>
                </main>
                <main class="mt-5 mb-20 px-8" v-else>
                    <Icon class="text-primary-400 mx-auto text-9xl my-10" icon="icon-park-outline:file-failed" />
                    <h2 class="font-serif font-bold text-center">Berkas Gagal Divalidasi</h2>
                </main>
                <footer class="absolute bottom-0 bg-neutral-200 w-full py-2">
                    <p class="text-center">©Telkom University Surabaya. All Rights Reserved</p>
                </footer>
            </Section>
        </div>
    </div>
</template>