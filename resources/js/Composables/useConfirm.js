import { ref } from "vue";

const showConfirm = ref(false);
const confirmMessage = ref("");
const confirmResolver = ref(null);

export function useConfirm() {
    const ask = (message) => {
        confirmMessage.value = message;
        showConfirm.value = true;
        return new Promise((resolve) => {
            confirmResolver.value = resolve;
        });
    };

    // ketika user klik tombol "Yes"
    const confirm = () => {
        showConfirm.value = false;
        confirmResolver.value?.(true);
    };

    // ketika user klik tombol "Cancel"
    const cancel = () => {
        showConfirm.value = false;
        confirmResolver.value?.(false);
    };

    return {
        showConfirm,
        confirmMessage,
        ask,
        confirm,
        cancel,
    };
}
