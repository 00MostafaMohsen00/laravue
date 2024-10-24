<template>
    <box class="h-screen">
        <template #title> {{ $t("users") }} </template>

        <div v-if="users.data.length">
            <box
                v-for="user in users.data"
                :key="user.id"
                class="flex flex-col justify-between my-2"
            >
                <div class="flex flex-row justify-between">
                    <div class="flex flex-col">
                        <div>{{ $t("name") }} : {{ user.name }}</div>
                        <div class="text-gray-500">
                            {{ $t("email") }} : {{ user.email }}
                        </div>
                    </div>
                </div>
            </box>
        </div>
        <empty v-else class="my-4">{{ $t("no_user") }}</empty>
        <pagination :links="users.links" v-if="users.data.length" />
    </box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import { defineProps } from "vue";
import Pagination from "@/Components/UI/Pagination.vue";
import Empty from "@/Components/UI/Empty.vue";
defineProps({
    users: Array,
});
</script>
