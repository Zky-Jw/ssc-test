<script setup>
  import SectionTitle from '@/Components/SectionTitle.vue';
</script>

<template>
  <div class="lg:mx-16 mx-5 my-20">
    
    <SectionTitle title="Berita Pusaran" />
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="item in 6" :key="item" class="">
        <div class="max-w-sm h-full rounded-md overflow-hidden border-[1px] border-neutral-300">
          <img class="w-full" src="../../images/card-news-img.jpg" alt="img news">
          <div class="px-6 py-4 bg-neutral-100">
            <div class="font-bold text-base lg:text-lg xl:text-xl mb-3">Lorem ipsum dolor sit amet adipiscing elit</div>
            <p class="text-sm xl:text-base text-neutral-800 font-thin">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque, exercitationem praesentium nihil.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>