<template>
    <form @submit.prevent="submit">
        <fields :form="form" />
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Fields from "./Fields.vue";
const form = useForm({
    beds: 0,
    baths: 0,
    city: "",
    area: "",
    code: "",
    street: "",
    street_nr: "",
    price: 0,
});

const submit = () => {
    form.post(route("listeing.store"), form);
};
</script>
