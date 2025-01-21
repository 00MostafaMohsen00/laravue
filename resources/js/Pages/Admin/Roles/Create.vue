<template>
    <box class="h-screen">
        <template #title> {{ $t("create") }} </template>
        <form @submit.prevent="submit">
            <fields
                :form="form"
                :permissions="permissions"
                :pages="pages"
                :rolePermissions="rolePermissions"
            />
            <div class="flex flex-col">
                <button type="submit" class="btn-outline w-full mt-2 text-sm">
                    {{ $t("save") }}
                </button>
                <Link
                    :href="route('roles.index')"
                    class="btn-outline w-full mt-2 text-sm text-center"
                >
                    {{ $t("cancel") }}
                </Link>

                <error
                    v-if="form.errors.permissions"
                    :error="form.errors.permissions"
                />
            </div>
        </form>
    </box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import Fields from "./Fields.vue";
import { useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";
import Error from "@/Components/UI/Error.vue";
const props = defineProps({
    permissions: Array,
    pages: Array,
    rolePermissions: null,
});

const form = useForm({
    name: "",
    permissions: [],
});

const submit = () => {
    form.post(route("roles.store"), {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>
