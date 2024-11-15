<template>
    <box class="h-screen">
        <template #title> {{ $t("admins") }} </template>
        <Link :href="route('admins.create')" class="my-4">
            <button class="btn-border">+</button>
        </Link>
        <div v-if="admins.data.length">
            <box
                v-for="admin in admins.data"
                :key="admin.id"
                class="flex flex-col justify-between my-2"
            >
                <div class="flex flex-row justify-between">
                    <div class="flex flex-col">
                        <div>{{ $t("name") }} : {{ admin.name }}</div>
                        <div class="text-gray-500">
                            {{ $t("email") }} : {{ admin.email }}
                        </div>
                        <div class="text-gray-500">
                            {{ $t("roles") }} :
                            {{ admin.roles[0] ? admin.roles[0].name : "-" }}
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <Link
                            :href="route('admins.edit', admin.id)"
                            class="btn-outline"
                        >
                            {{ $t("edit") }}
                        </Link>
                        <delete-button
                            :url="route('admins.destroy', admin.id)"
                        ></delete-button>
                    </div>
                </div>
            </box>
        </div>
        <empty v-else class="my-4">{{ $t("no_admin") }}</empty>
        <pagination :links="admins.links" v-if="admins.data.length" />
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
    admins: Array,
});
</script>
