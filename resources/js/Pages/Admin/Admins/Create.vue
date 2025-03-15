<template>
    <box class="h-screen">
        <template #title> {{ $t("create") }} </template>
        <form @submit.prevent="submit">
            <fields :form="form" :roles="roles" />
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
            </div>
        </form>
    </box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import Fields from "./Fields.vue";
import { useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    roles: Array,
});

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    role_id: null,
});

const submit = () => {
    form.post(route("admins.store"), {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>
