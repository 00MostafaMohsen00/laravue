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
                <error v-if="error" :error="error" />
            </div>
            <div class="mt-4 flex flex-col">
                <input type="submit" :value="$t('send')" class="btn w-full" />
            </div>
        </div>
    </form>
</template>
<script setup>
import Error from "@/Components/UI/Error.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
const form = useForm({
    email: null,
    password: null,
});
const page = usePage();
const error = computed(() => {
    return form.errors.email
        ? form.errors.email
        : page.props.errors
        ? page.props.errors.email
        : null;
});
const save = () => {
    form.post(route("forget.password.save"), {
        preserveScroll: true,
        preserveState: true,
    });
};
</script>
