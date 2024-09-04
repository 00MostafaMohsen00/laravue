<template>
    <img
        :src="src"
        class="rounded-md w-full h-full"
        @error="error"
        ref="imageSrc"
    />
</template>

<script setup>
import { computed, ref } from "vue";
const props = defineProps({
    src: String,
});
const imageSrc = ref(null);
const error = computed(() => {
    imageSrc.value.error = null;
    imageSrc.value.src = window.location.origin + "/no-image.png";
});
</script>
