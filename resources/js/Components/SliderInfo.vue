<script setup>
import imgUrl from '../../images/Slideshow-1.jpg'
</script>

<template>
  <div class="my-20 bg-primary-400">
    <div class="">
      <div class="flex flex-wrap">
        <div class="bg-cover w-full lg:w-[55%]" :style="`background-image: url(${imgUrl})`">
          <img class="w-full h-auto block lg:hidden" :src="imgUrl" alt="">
        </div>
        <div class="w-full lg:w-[45%]">
          <div class="px-7 py-16">
            <h2 class="text-white font-bold">Apa itu SSC ?</h2>
            <div class="my-5 bg-neutral-400/[.2] rounded p-5">
              <h3 class="font-bold text-white mb-3">Tentang SSC</h3>
              <p class="text-white font-medium">SSC adalah pusat layanan dan informasi
                layanan yang diperuntukkan untuk
                mahasiswa aktif Institut Teknologi
                Surabaya. Berada di lantai 2 gedung
                utama Telkom University Surabaya.</p>
            </div>
            <div class="my-5 bg-neutral-400/[.2] rounded p-5">
              <h3 class="font-bold text-white mb-3">Layanan SSC</h3>
              <div class="text-white font-medium flex">
                <ul class="text-white font-medium pl-5 mr-10" style="list-style:disc;">
                  <li>Akademik</li>
                  <li>Kemahasiswaan</li>
                  <li>Puti</li>
                  <li>Logistik</li>
                </ul>
                <ul class="text-white font-medium pl-5" style="list-style:disc;">
                  <li>Keuangan</li>
                  <li>Pusbas & Perpustakaan</li>
                  <li>FTIB</li>
                  <li>FTEIC</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>