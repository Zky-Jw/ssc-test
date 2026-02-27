<script setup>
import Person1 from '../../images/foto-irma.png'
import Ornament1 from '../../img/ornament_1.svg'
import Ornament1Gray from '../../img/ornament_1_gray.svg'
import Person2 from '../../images/fitri-1.png'
import Ornament2 from '../../img/ornament_2.svg'
import Ornament2Gray from '../../img/ornament_2_gray.svg'

import { reactive, ref, onMounted, onUnmounted } from 'vue'

const custom_hero = ref(null)

const size = 1920
const bottomPerson = 200
const ornament1 = 485
const ornament2 = 530

const state = reactive({
    size: size,
    bottomPerson: bottomPerson,
    ornament1: ornament1,
    ornament2: ornament2,
})

onMounted(() => {
    window.addEventListener('resize', listenResize)
    listenResize()
})

onUnmounted(() => document.removeEventListener('resize', listenResize))

function listenResize() {
    state.bottomPerson += (window.innerWidth - state.size) / 8
    state.ornament1 += (window.innerWidth - state.size) / 8
    state.ornament2 += (window.innerWidth - state.size) / 8
    state.size = window.innerWidth
}
</script>

<template>
    <div ref="custom_hero"
        class="custom-hero relative overflow-hidden w-full flex justify-center h-[360px] md:min-h-[720px] md:h-screen bg-gradient-to-r from-tartiary-200 to-secondary-300">
        <!-- Person 1 -->
        <img class="hidden lg:block absolute w-[300px] z-10 left-[75px]" :style="`bottom: ${state.bottomPerson}px;`"
            :src="Person1" alt="Person 1">

        <!-- Person 2 -->
        <img class="hidden lg:block absolute w-[300px] z-10 right-[75px]" :style="`bottom: ${state.bottomPerson}px;`"
            :src="Person2" alt="Person 2">

        <!-- Ornamen 1 -->
        <img class="absolute w-[10%] left-[270px] hidden lg:block" :style="`bottom: ${state.ornament1}px;`" :src="Ornament1"
            alt="Ornament 1">

        <!-- Ornamen 2      -->
        <img class="absolute w-[238px] right-[120px] hidden lg:block" :style="`bottom: ${state.ornament2}px;`"
            :src="Ornament2" alt="Ornament 2">

        <!-- Ornament gray version -->
        <img class="absolute w-[50px] sm:w-[9%] left-[50px] sm:left-[140px] top-[120px] md:top-[200px] block lg:hidden"
            :src="Ornament1Gray" alt="Ornament 1 Gray Version">

        <!-- Ornament 2 gray version -->
        <img class="absolute w-[60px] sm:w-[10%] right-[50px] sm:right-[140px] top-[120px] md:top-[200px] block lg:hidden"
            :src="Ornament2Gray" alt="Ornament 1 Gray Version">

        <div class="mt-24 md:mt-40 flex flex-col items-center z-20">
            <h1 class="text-2xl md:text-6xl lg:text-7xl"><span class="text-primary-400">S</span>tudent<br /><span
                    class="text-primary-400">S</span>ervice<br /><span class="text-primary-400">C</span>enter</h1>
            <p class="font-normal text-[12px] md:text-lg text-center text-neutral-600 mt-4 md:mt-10">Datang. Buat
                Tiket.
                Proses.</p>
            <a href="#layanan"
                class="hidden md:block mt-10 px-10 py-3 rounded-[10px] text-semibold text-neutral-100 bg-primary-400">
                Lihat Layanan
            </a>
        </div>
    </div>
</template>

<style scoped>
.custom-hero::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 1000px;
    background-color: white;
    transform: rotate(15deg);
    z-index: 20;
    left: -230px;
    bottom: -920px;
}

.custom-hero::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 1000px;
    background-color: white;
    transform: rotate(-15deg);
    z-index: 20;
    right: -230px;
    bottom: -920px;
}
</style>