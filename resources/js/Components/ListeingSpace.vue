<template>
    <div>
        <span class="font-bold">{{ listeing.beds }}</span> {{ $t("beds") }}
        <span class="text-gray-400"> | </span>
        <span class="font-bold">{{ listeing.baths }}</span> {{ $t("baths") }}
        <span class="text-gray-400"> | </span>
        <span class="font-bold">{{ listeing.area }}</span>
        <span class="text-gray-400"> m<sup>2</sup> </span>
    </div>
</template>
<script setup>
defineProps({
    listeing: Object,
});
</script>
