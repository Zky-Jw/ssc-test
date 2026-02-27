<script setup>
import { computed } from "vue";
import { Icon } from "@iconify/vue";

const props = defineProps({
    message: {
        type: String,
        required: true,
    },
    icon: {
        type: String,
        default: "",
    },
    show: {
        type: Boolean,
        default: true,
    },
    confirmText: {
        type: String,
        default: "Yes",
    },
    cancelText: {
        type: String,
        default: "Cancel",
    },
});

const emit = defineEmits(["confirm", "cancel"]);

const iconName = computed(() => {
    if (props.icon) return props.icon;
    switch (props.type) {
        case "success":
            return "mdi:check-circle";
        case "error":
            return "mdi:alert-circle";
        case "warning":
            return "mdi:alert";
        default:
            return "mdi:information";
    }
});
</script>

<template>
    <transition name="fade">
        <div v-if="show"
            class="fixed w-screen h-screen overflow-hidden inset-0 bg-black/20 flex items-center justify-center z-[9999]">
            <div
                class="max-w-sm w-full mx-3 p-5 rounded-lg border-2 shadow-lg flex flex-col gap-4 bg-white text-primary-400 border-primary-200">
                <div class="flex items-center gap-2">
                    <Icon :icon="iconName" class="w-6 h-6 flex-shrink-0" />
                    <p class="text-sm font-semibold">{{ message }}</p>
                </div>

                <div class="flex justify-end gap-2">
                    <button @click="$emit('cancel')"
                        class="px-3 py-1.5 text-xs rounded-md border border-slate-300 hover:bg-slate-100">
                        {{ cancelText }}
                    </button>
                    <button @click="$emit('confirm')"
                        class="px-3 py-1.5 text-xs rounded-md bg-primary-400 text-white hover:bg-primary-500">
                        {{ confirmText }}
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
