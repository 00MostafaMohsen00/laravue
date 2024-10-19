<template>
    <div class="grid grid-cols-1 gap-4">
        <div>
            <label class="label">{{ $t("name") }}</label>
            <input type="text" v-model="form.name" class="input" />
            <error v-if="form.errors.name" :error="form.errors.name" />
        </div>
    </div>
    <div class="flex justify-center m-auto my-2">
        <div>
            <label class="label">{{ $t("permissions") }}</label>
        </div>
    </div>
    <div
        class="grid grid-cols-2 gap-4 my-4"
        v-for="(page, j) in pages"
        :key="page"
    >
        <div>
            {{ $t(page) }}
        </div>
        <div class="flex flex-row">
            <div class="flex flex-row">
                <permission
                    v-for="(permission, i) in permissions"
                    :key="`${i}-${permission}-${page}`"
                    :index="getIndex(i, j)"
                    :permission="permission"
                    :rolePermissions="rolePermissions"
                    :form="form"
                    @change="permissionChanged($event)"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import Error from "@/Components/UI/Error.vue";
import Permission from "./Permission.vue";

const props = defineProps({
    form: Object,
    permissions: Array,
    pages: Array,
    rolePermissions: null,
});

const getIndex = (i, j) => {
    if (j == 0) {
        return i + 1;
    } else {
        return j * 4 + (i + 1);
    }
};

const permissionChanged = (event) => {
    if (props.form.permissions.includes(event)) {
        props.form.permissions = props.form.permissions.filter(
            (permission) => permission !== event
        );
    } else {
        props.form.permissions.push(event);
    }
};
</script>
