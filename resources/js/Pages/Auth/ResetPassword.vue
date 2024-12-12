<template>
    <form @submit.prevent="save">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="new_password" class="label">{{
                    $t("new_password")
                }}</label>
                <input
                    id="new_password"
                    type="password"
                    v-model="form.new_password"
                    required
                    class="input"
                />
                <error
                    v-if="form.errors.new_password"
                    :error="form.errors.new_password"
                />
                <error v-if="form.errors.token" :error="form.errors.token" />
            </div>
            <div class="mt-4 flex flex-col">
                <input type="submit" :value="$t('save')" class="btn w-full" />
            </div>
        </div>
    </form>
</template>
<script setup>
import Error from "@/Components/UI/Error.vue";
import { useForm, usePage } from "@inertiajs/vue3";
const props = defineProps({
    token: String,
});
const form = useForm({
    token: usePage().props.token,
    new_password: null,
});
const save = () => {
    form.post(route("reset.password"));
};
</script>
