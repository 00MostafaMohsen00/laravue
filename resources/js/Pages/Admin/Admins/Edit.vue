<template>
    <box class="h-screen">
        <template #title> {{ $t("edit") }} </template>
        <form @submit.prevent="submit">
            <input type="hidden" name="id" v-model="form.id" />
            <fields :form="form" :roles="roles" />
            <div class="flex flex-col">
                <button type="submit" class="btn-outline w-full mt-2 text-sm">
                    {{ $t("save") }}
                </button>
                <Link
                    :href="route('admins.index')"
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
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    roles: Array,
    role_id: Number,
    admin: Object,
});

const form = useForm({
    id: props.admin.id,
    name: props.admin.name,
    email: props.admin.email,
    password: null,
    password_confirmation: null,
    role_id: props.role_id,
});

const submit = () => {
    form.put(route("admins.update", props.admin.id));
};
</script>
