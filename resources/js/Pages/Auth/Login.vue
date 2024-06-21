<template>
    <form @submit.prevent="save">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="email" class="label">{{ $t("email") }}</label>
                <input
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    class="input"
                />
                <error v-if="form.errors.email" :error="form.errors.email" />
            </div>
            <div class="mt-4">
                <label for="password" class="label">{{ $t("password") }}</label>
                <input
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                    class="input"
                />
                <error
                    v-if="form.errors.password"
                    :error="form.errors.password"
                />
            </div>
            <div class="mt-4 flex flex-col">
                <Link
                    :href="route('register')"
                    class="mb-4 text-sm text-blue-600"
                    >{{ $t("dont_have_account") }}</Link
                >
                <input type="submit" :value="$t('login')" class="btn w-full" />
            </div>
        </div>
    </form>
</template>
<script setup>
import Error from "@/Components/UI/Error.vue";
import { useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
const form = useForm({
    email: null,
    password: null,
});
const save = () => {
    form.post(route("login.save"));
};
</script>
