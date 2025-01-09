<template>
    <form @submit.prevent="save">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="name" class="label">{{ $t("name") }}</label>
                <input
                    id="name"
                    type="text"
                    v-model="form.name"
                    required
                    class="input"
                />
                <error v-if="form.errors.name" :error="form.errors.name" />
            </div>
            <div>
                <label for="email" class="label">{{ $t("email") }}</label>
                <input
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    class="input"
                    :disabled="user.provider"
                />
                <error v-if="form.errors.email" :error="form.errors.email" />
            </div>
            <div class="mt-4 flex flex-col">
                <input type="submit" :value="$t('save')" class="btn w-full" />
                <Link
                    v-if="!user.provider"
                    :href="route('change.password')"
                    class="mb-4 text-sm text-blue-600"
                    >{{ $t("change_password") }}</Link
                >
            </div>
        </div>
    </form>
</template>
<script setup>
import Error from "@/Components/UI/Error.vue";
import { useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    user: Object,
});
const form = useForm({
    name: props.user.name,
    email: props.user.email,
});
const save = () => {
    form.post(route("profile.save"));
};
</script>
