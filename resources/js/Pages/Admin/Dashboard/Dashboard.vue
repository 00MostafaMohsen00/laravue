<template>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <box>
            <template #title> {{ $t("users") }} </template>
            <div class="text-3xl font-bold">{{ users }}</div>
        </box>
        <box>
            <template #title> {{ $t("Listeings") }} </template>
            <div class="text-3xl font-bold">{{ listeings }}</div>
        </box>
    </div>
</template>

<script setup>
import { defineProps } from "vue";
import Box from "@/Components/UI/Box.vue";

defineProps({
    users: Number,
    listeings: Number,
});
</script>
