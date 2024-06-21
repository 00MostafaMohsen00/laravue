<template>
    <p>
        {{ listeing.street_nr }} , {{ listeing.street }} ,
        {{ listeing.city }} ,{{ listeing.code }}
    </p>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    listeing: Object,
});
</script>
