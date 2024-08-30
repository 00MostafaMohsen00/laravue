<template>
    <img
        :src="src"
        class="rounded-md w-full h-full"
        onerror="this.onerror=null; this.src='/no-image.png';"
    />
</template>

<script setup>
defineProps({
    src: String,
});
</script>
