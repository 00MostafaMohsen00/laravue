<template>
    <transition>
        <div
            v-if="message && showMessage"
            class="mb-4 border rounded shadow-sm border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900 p-2"
        >
            {{ message }}
        </div>
    </transition>
</template>

<script setup>
import { computed, ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
const showMessage = ref(false);
const message = computed(() => {
    showMessage.value = true;
    return page.props.flash.success;
});

watch(showMessage, () => {
    setTimeout(() => {
        showMessage.value = false;
    }, 1000);
});
</script>
