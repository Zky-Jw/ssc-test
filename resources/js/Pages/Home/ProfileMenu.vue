<script setup>
  import { Head, Link } from '@inertiajs/vue3';
  import BaseLayout from '@/Layouts/BaseLayout.vue';
</script>

<template>
  <Head title="Profil Akun" />
  <BaseLayout>
    <section class="my-20">
      <div class="container mx-auto px-4">
        <h2 class="text-center">Profil</h2>
        <div class="my-12">
          <div class="flex items-center justify-center">
            <div class="card flex flex-col w-full shadow-lg rounded-lg border-[1px] border-neutral-200">
              <div class="card-header block md:flex justify-between items-center px-9 py-5 border-b-[1px] border-neutral-200">
                <h3 class="font-bold text-primary-400 mb-3 md:mb-0">Profil, Nama Mahasiswa</h3>
                <a href="#" class="py-2 px-3 inline-flex justify-center items-center gap-2 text-sm text-white rounded-md border-transparent font-semibold bg-primary-400 hover:bg-primary-500">
                  Riwayat Pengajuan
                </a>
              </div>
              <div class="card-body">
                <div class="flex flex-wrap">
                  <div class="w-full md:w-1/2 py-5 px-8 md:px-16 border-b-2 md:border-r-2 border-neutral-200">
                    <ul class="list-none list-inside">
                      <li class="mb-7">
                        <p class="font-semibold text-primary-400">NIM</p>
                        <p>1234567890</p>
                      </li>
                      <li class="mb-7">
                        <p class="font-semibold text-primary-400">Nama</p>
                        <p>Fakhri Alauddin</p>
                      </li>
                      <li class="mb-7">
                        <p class="font-semibold text-primary-400">Program Studi</p>
                        <p>Informatika</p>
                      </li>
                      <li class="mb-7">
                        <p class="font-semibold text-primary-400">Tahun Angkatan</p>
                        <p>2020</p>
                      </li>
                    </ul>
                  </div>
                  <div class="w-full md:w-1/2 py-5 px-8 md:px-16">
                    <ul class="list-none list-inside">
                      <li class="mb-7">
                        <p class="font-semibold text-primary-400">Nomor Telp</p>
                        <p>081234556677</p>
                      </li>
                      <li class="mb-7">
                        <p class="font-semibold text-primary-400">Email Institusi</p>
                        <p>FakhriAlauddin@student.ittelkom-sby.ac.id</p>
                      </li>
                     
                    </ul>
                    <div>
                      <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-md text-xs font-medium bg-primary-300 text-white">Informasi</span>
                      <p class="text-base mt-1">mengganti data silahkan melalui igracias</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>
  </BaseLayout>
  
</template>