<template>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <box class="bg-blue-100 dark:bg-blue-900">
            <template #title>
                <i class="fas fa-users icon"></i> {{ $t("Users") }}
            </template>
            <div class="text-3xl font-bold">{{ users }}</div>
        </box>
        <box class="bg-green-100 dark:bg-green-900">
            <template #title>
                <i class="fas fa-users icon"></i>{{ $t("active") }}
                {{ $t("Users") }}
            </template>
            <div class="text-3xl font-bold">{{ active_users }}</div>
        </box>

        <box class="bg-red-100 dark:bg-red-900">
            <template #title>
                <i class="fas fa-users icon"></i>{{ $t("inactive") }}
                {{ $t("Users") }}
            </template>
            <div class="text-3xl font-bold">{{ inactive_users }}</div>
        </box>
        <box class="bg-yellow-100 dark:bg-yellow-900">
            <template #title>
                <i class="fas fa-home icon"></i>
                {{ $t("Listeings") }}
            </template>
            <div class="text-3xl font-bold">{{ listeings }}</div>
        </box>
    </div>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";

defineProps({
    users: Number,
    listeings: Number,
    active_users: Number,
    inactive_users: Number,
});
</script>
