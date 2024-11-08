<template>
    <Link :href="route(link)" v-if="canView">
        <box
            class="w-full flex items-start gap-2 hover:bg-gray-400"
            :class="{ active: isActive }"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="size-6 text-gray-500 dark:text-gray-600"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776"
                />
            </svg>

            <span class="text-md text-gray-500 dark:text-gray-600">{{
                title
            }}</span>
        </box>
    </Link>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { defineProps, computed, ref, onMounted } from "vue";
import Box from "@/Components/UI/Box.vue";
import { usePermission } from "@/Composable/usePermission";
import { isNull } from "lodash";
import { router } from "@inertiajs/vue3";
const props = defineProps({
    title: String,
    link: String,
    perm: null,
    routes: Array,
});

const role = computed(() => usePage().props.user_role);
const perms = computed(() => usePage().props.user_permissions);
const canView = computed(() => {
    if (isNull(props.perm)) {
        return role.value === "superadmin" ? true : false;
    } else {
        const { can } = usePermission(props.perm, perms.value);
        return can.value;
    }
});
const isActive = ref(false);
const updateIsActive = () => {
    const currentRouteName = route().current();
    isActive.value = props.routes.includes(currentRouteName);
};

onMounted(() => {
    updateIsActive();
    router.on("navigate", updateIsActive);
});
</script>
