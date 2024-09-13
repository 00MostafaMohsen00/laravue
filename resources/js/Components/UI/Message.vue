<template></template>

<script setup>
import { computed, watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

const page = usePage();
const message = computed(() => {
    return page.props.flash.success;
});

watch(message, () => {
    if (message.value)
        useToast().open({
            message: message.value,
            type: "success",
            position: "top-right",
            duration: 3000,
            dismissible: true,
            queue: false,
        });
});
</script>
