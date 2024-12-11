<template>
    <form @submit.prevent="save">
        <div class="w-1/2 mx-auto">
            <div>
                <label for="old_password" class="label">{{
                    $t("old_password")
                }}</label>
                <input
                    id="old_password"
                    type="password"
                    v-model="form.old_password"
                    required
                    class="input"
                />
                <error
                    v-if="form.errors.old_password"
                    :error="form.errors.old_password"
                />
            </div>
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
            </div>
            <div>
                <label for="confirm_password" class="label">{{
                    $t("confirm_password")
                }}</label>
                <input
                    id="confirm_password"
                    type="password"
                    v-model="form.confirm_password"
                    required
                    class="input"
                />
                <error
                    v-if="form.errors.confirm_password"
                    :error="form.errors.confirm_password"
                />
            </div>
            <div class="mt-4 flex flex-col">
                <input type="submit" :value="$t('save')" class="btn w-full" />
                <Link
                    :href="route('profile')"
                    class="btn w-full text-center mt-2"
                    >{{ $t("cancel") }}</Link
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
    old_password: null,
    new_password: null,
    confirm_password: null,
});
const save = () => {
    form.post(route("change.password.save"));
};
</script>
