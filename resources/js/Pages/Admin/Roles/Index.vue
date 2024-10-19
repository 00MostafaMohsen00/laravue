<template>
    <box class="h-screen">
        <template #title> {{ $t("roles") }} </template>
        <Link :href="route('roles.create')" class="my-4">
            <button class="btn-border">+</button>
        </Link>
        <div v-if="roles.data.length">
            <box
                v-for="role in roles.data"
                :key="role.id"
                class="flex flex-col justify-between my-2"
            >
                <div class="flex flex-row justify-between">
                    <div>{{ role.name }}</div>
                    <div class="flex flex-col gap-2">
                        <Link
                            :href="route('roles.edit', role.id)"
                            class="btn-outline"
                        >
                            {{ $t("edit") }}
                        </Link>
                        <delete-button
                            :url="route('roles.destroy', role.id)"
                        ></delete-button>
                    </div>
                </div>
            </box>
        </div>
        <empty v-else class="my-4">{{ $t("no_role") }}</empty>
        <pagination :links="roles.links" v-if="roles.data.length" />
    </box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import { Link } from "@inertiajs/vue3";
import { defineProps } from "vue";
import Pagination from "@/Components/UI/Pagination.vue";
import DeleteButton from "@/Components/UI/DeleteButton.vue";
import Empty from "@/Components/UI/Empty.vue";
defineProps({
    roles: Array,
});
</script>
