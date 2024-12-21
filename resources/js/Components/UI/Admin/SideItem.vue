<template>
    <Link :href="route(link)" v-if="canView">
        <box
            class="w-full flex items-center gap-2 hover:bg-gray-400"
            :class="{ active: isActive }"
        >
            <i :class="icon + ' icon'"></i>

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
    icon: String,
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
