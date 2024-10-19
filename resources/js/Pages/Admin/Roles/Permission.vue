<template>
    <label class="lable">{{ $t(permission) }}</label>
    <input
        type="checkbox"
        class="checkbox"
        :value="index"
        :checked="
            (rolePermissions && rolePermissions.includes(index)) ||
            form.permissions.includes(permission)
        "
        @change="emit('change', index)"
    />
</template>

<script setup>
import { defineProps } from "vue";

defineProps({
    index: Number,
    permission: String,
    rolePermissions: null,
    form: Object,
});

const emit = defineEmits(["change"]);
</script>
