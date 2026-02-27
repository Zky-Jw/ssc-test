<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'font-bold'
        : 'hover:font-bold'
);
</script>

<template>
    <Link class="menu-link group relative text-base font-medium transition duration-300 ease-in-out" :href="href"
        :class="classes">
    <slot />
    <div
        class="opacity-0 group-hover:opacity-100 absolute left-1/2 -ml-1 w-[5px] h-[5px] bg-black rounded-full transition duration-300 ease-in-out">
    </div>
    </Link>
</template>
<style scoped>
.menu-link::after {
    display: block;
    content: attr(data-text);
    content: attr(data-text) / "";
    font-weight: bold;
    height: 0;
    overflow: hidden;
    visibility: hidden;
}
</style>