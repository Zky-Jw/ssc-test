<script setup>


defineProps({
  isFooterSimple: {
    type: Boolean,
    default: false,
  },
});
const iconList = [
  'ri:facebook-box-line',
  'ri:instagram-line',
  'ri:twitter-line',
  'tabler:world',
  'ri:youtube-line'
]
const immportantLink = [
  {
    title: 'Penerimaan Mahasiswa Baru',
    href: '#',
  },
  {
    title: 'Pusat Pengembangan Karir dan Alumni',
    href: '#',
  },
  {
    title: 'Penelitian dan Pengembangan Masyarakat',
    href: '#',
  },
  {
    title: 'Fakultas Teknologi dan Informasi Bisnis',
    href: '#',
  },
  {
    title: 'Fakultas Teknik Elektro dan Industri Cerdas',
    href: '#',
  },
  {
    title: 'Beasiswa',
    href: '#',
  },
  {
    title: 'Kebijakan Privasi',
    href: '#',
  },
];

const affiliate = [
  {
    title: 'Telkom Indonesia',
    href: '#',
  },
  {
    title: 'Yayasan Pendidikan Telkom',
    href: '#',
  },
  {
    title: 'Universitas Telkom',
    href: '#',
  },
  {
    title: 'Telkom University Purwokerto',
    href: '#',
  },
  {
    title: 'Telkom University Jakarta',
    href: '#',
  },

]
</script>

<template>
  <footer v-if="!isFooterSimple" class="bg-gradient-to-r from-tartiary-200 to-secondary-300">
    <div class="lg:mx-16 mx-5 py-20 lg:py-26">
      <div class="block lg:flex justify-between">
        <div>
          <img class="w-48 lg:w-auto m-auto lg:m-0 mb-5 lg:mb-0" src="../../images/Logo_Institut_Teknologi_Telkom_Surabaya_white_1.png"
            alt="" />
        </div>
        <div class="mb-5 lg:mb-0">
          <h3 class="text-2xl">Kontak Kami</h3>
          <div class="border-2 border-primary-400 w-20 rounded"></div>
          <div class="my-3">
            <div class="flex flex-wrap">
              <a href="#" v-for="item in iconList" :key="item">
                <Icon :icon="item" class="text-3xl mr-3" />
              </a>

            </div>
          </div>
          <div class="my-3">
            <p class="mb-1 text-base">Jl.Ketintang No. 156, Surabaya</p>
            <p class="mb-1 text-base">Gedung Utama Lantai G</p>
            <p class="mb-1 text-base">(+6231) 82808000</p>
            <p class="mb-1 text-base">humas@ittelkom-sby.ac.id</p>
          </div>
        </div>
        <div class="mb-5 lg:mb-0">
          <h3 class="text-2xl">Tautan Penting</h3>
          <div class="border-2 border-primary-400 w-20 rounded"></div>
          <ul class="list-none w-full lg:w-64 mt-3">
            <li v-for="item in immportantLink" :key="item">
              <a :href="item.href" class="flex" target="_blank">
                <div>
                  <Icon icon="material-symbols:chevron-right" class="mr-2 mt-1" />
                </div>
                {{ item.title }}
              </a>
            </li>
          </ul>
        </div>
        <div class="mb-5 lg:mb-0">
          <h3 class="text-2xl">Afiliasi</h3>
          <div class="border-2 border-primary-400 w-20 rounded"></div>
          <ul class="list-none w-full lg:w-60 mt-3">
            <li v-for="item in affiliate" :key="item">
              <a :href="item.href" class="flex" target="_blank">
                <div>
                  <Icon icon="material-symbols:chevron-right" class="mr-2 mt-1" />
                </div>
                {{ item.title }}
              </a>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </footer>
  <footer class="bg-primary-400">
    <div class="container m-auto">
      <p class="py-3 text-center text-white text-sm md:text-base">© Telkom University Surabaya. All Rights
        Reserved</p>
    </div>
  </footer>
</template>