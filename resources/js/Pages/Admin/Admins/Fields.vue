<template>
    <div class="grid grid-cols-1 gap-4">
        <div>
            <label class="label">{{ $t("name") }}</label>
            <input type="text" v-model="form.name" class="input" />
            <error v-if="form.errors.name" :error="form.errors.name" />
        </div>
        <div>
            <label class="label">{{ $t("email") }}</label>
            <input type="email" v-model="form.email" class="input" />
            <error v-if="form.errors.email" :error="form.errors.email" />
        </div>
        <div>
            <label class="label">{{ $t("password") }}</label>
            <input type="password" v-model="form.password" class="input" />
            <error v-if="form.errors.password" :error="form.errors.password" />
        </div>
        <div>
            <label class="label">{{ $t("confirm_password") }}</label>
            <input
                type="password"
                v-model="form.password_confirmation"
                class="input"
            />
            <error
                v-if="form.errors.password_confirmation"
                :error="form.errors.password_confirmation"
            />
        </div>
        <div>
            <label class="label">{{ $t("roles") }}</label>

            <select v-model="form.role_id" class="w-full">
                <option
                    v-for="role in roles"
                    :key="role.id"
                    :value="role.id"
                    :selected="role.id === form.role_id"
                >
                    {{ role.name }}
                </option>
            </select>

            <error v-if="form.errors.role_id" :error="form.errors.role_id" />
        </div>
    </div>
</template>

<script setup>
import Error from "@/Components/UI/Error.vue";

const props = defineProps({
    form: Object,
    roles: Array,
});
</script>
