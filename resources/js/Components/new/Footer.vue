<script setup>

defineProps({
  isFooterSimple: {
    type: Boolean,
    default: false,
  },
});

const sosmedLink = [
  {
    title: 'Facebook',
    href: '#',
    icons: 'ri:facebook-box-line'
  },
  {
    title: 'Instagram',
    href: 'https://www.instagram.com/ssc.telkomsby/',
    icons: 'ri:instagram-line'
  },
  {
    title: 'Twitter',
    href: '#',
    icons: 'ri:twitter-line'
  },
  {
    title: 'Website',
    href: '#',
    icons: 'tabler:world'
  },
  {
    title: 'Youtube',
    href: '#',
    icons: 'ri:youtube-line'
  },
];

const immportantLink = [
  {
    title: 'Pusat Teknologi Informasi',
    href: 'https://it.telkomuniversity.ac.id/',
  },
  {
    title: 'Service Desk',
    href: 'https://servicedesk.telkomuniversity.ac.id/usermanual/',
  },
  {
    title: 'Bagian Administrasi Akademik',
    href: 'https://baa.telkomuniversity.ac.id/',
  },
  {
    title: 'Kemahasiswaan',
    href: 'https://studentaffairs.telkomuniversity.ac.id/',
  },
  {
    title: 'Carrer Development Center',
    href: 'https://careerdays.telucareer.com/',
  },
];

const affiliate = [
  {
    title: 'Yayasan Pendidikan Telkom',
    href: 'https://ypt.or.id/',
  },
  {
    title: 'Tel-U Bandung',
    href: 'https://telkomuniversity.ac.id/',
  },
  {
    title: 'Tel-U Jakarta',
    href: 'https://jakarta.telkomuniversity.ac.id/',
  },
  {
    title: 'Tel-U Surabaya',
    href: 'https://surabaya.telkomuniversity.ac.id/',
  },
  {
    title: 'Tel-U Purwokerto',
    href: 'https://purwokerto.telkomuniversity.ac.id/',
  },

]

const yearNow = new Date().getFullYear();

const whatsappNumber = '+6285179793597';
const whatsappLink = `https://wa.me/${whatsappNumber.replace(/[^0-9]/g, '')}`;
</script>

<template>
  <footer class="border-t-[1px] border-neutral-400 py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-16">
        <div class="text-center md:text-left">
          <img class="w-56 h-auto block mx-auto md:mx-0" src="../../../images/footer-logo.png" alt="...">
          <div class="sosmed-icons mt-6 flex justify-center md:justify-start gap-3">
            <a :href="item.href" v-for="(item, index) in sosmedLink" :key="index" target="_blank"
              class="inline-flex justify-center items-center size-[40px] rounded-full bg-primary-400 text-white hover:bg-primary-500 transition-colors">
              <Icon :icon="item.icons" class="text-2xl" />
            </a>
          </div>
        </div>
        <div class="text-center md:text-left">
          <h3 class="font-bold text-primary-400 text-lg mb-4">Kontak Kami</h3>
          <ul class="list-none list-inside text-neutral-800 space-y-1.5">
            <li class="text-base">Bagian SSC</li>
            <li class="text-base">Lantai 2, Gedung Utama</li>
            <li class="text-base">Jl.Ketintang No. 156, Surabaya</li>
            <li class="text-base">(+62) 811-3221-2000</li>
            <li class="text-base">
              <a href="mailto:sscsby@telkomuniversity.ac.id" class="hover:text-primary-400 hover:underline transition-colors">
                sscsby@telkomuniversity.ac.id
              </a>
            </li>
          </ul>
        </div>
        <div class="text-center md:text-left">
          <h3 class="font-bold text-primary-400 text-lg mb-4">Tautan Penting</h3>
          <ul class="list-none list-inside text-neutral-800 space-y-1.5">
            <li v-for="(item, index) in immportantLink" :key="index" class="text-base">
              <a :href="item.href" target="_blank" class="hover:text-primary-400 hover:underline transition-colors">
                {{ item.title }}
              </a>
            </li>
          </ul>
        </div>
        <div class="text-center md:text-left">
          <h3 class="font-bold text-primary-400 text-lg mb-4">Afilasi</h3>
          <ul class="list-none list-inside text-neutral-800 space-y-1.5">
            <li v-for="(item, index) in affiliate" :key="index" class="text-base">
              <a :href="item.href" target="_blank" class="hover:text-primary-400 hover:underline transition-colors">
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
      <p class="py-4 text-center text-white text-base font-normal">© {{ yearNow }} - SSC <span class="font-bold">Telkom University
          Surabaya </span>2.0</p>
    </div>
  </footer>

  <!-- Floating WhatsApp Button -->
  <a :href="whatsappLink" target="_blank" 
     class="fixed bottom-6 right-6 bg-[#25D366] text-white p-4 rounded-full shadow-lg hover:bg-[#128C7E] transition-colors z-50">
    <Icon icon="ic:baseline-whatsapp" class="text-4xl" />
  </a>
</template>