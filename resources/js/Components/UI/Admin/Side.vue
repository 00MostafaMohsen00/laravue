<template>
    <box class="m-4">
        <template #title>
            <div class="flex flex-col items-center">
                <span class="text-gray-300 dark:text-gray-600">{{
                    user.name
                }}</span>
                <span class="text-gray-300 dark:text-gray-600">{{
                    user.email
                }}</span>
            </div>
            <hr class="w-full my-2 border-gray-200 dark:border-gray-700" />
        </template>
        <aside class="w-full h-screen overflow-y-auto">
            <SideItem
                v-for="tab in tabs"
                :key="tab.title"
                :title="tab.title"
                :link="tab.link"
                :perm="tab.perm ?? null"
                :routes="tab.routes"
            />
        </aside>
    </box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import SideItem from "./SideItem.vue";
import { useI18n } from "vue-i18n";
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
const page = usePage();

const user = computed(() => page.props.user);
const { t } = useI18n();
const tabs = ref([
    {
        title: t("roles"),
        link: "roles.index",
        routes: ["roles.index", "roles.create", "roles.edit"],
    },
    {
        title: t("admins"),
        link: "admins.index",
        routes: ["admins.index", "admins.create", "admins.edit"],
    },
    {
        title: t("users"),
        link: "users.index",
        perm: "view users",
        routes: ["users.index", "users.create", "users.edit"],
    },
    {
        title: t("Listeings"),
        link: "listeings.index",
        permission: "view listeings",
        routes: ["listeings.index", "listeings.create", "listeings.edit"],
    },
]);
</script>
