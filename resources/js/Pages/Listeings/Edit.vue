<template>
    <form @submit.prevent="submit">
        <fields :form="form" />
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Fields from "./Fields.vue";
const props = defineProps({
    listeing: Object,
});

const form = useForm({
    beds: props.listeing.beds,
    baths: props.listeing.baths,
    city: props.listeing.city,
    area: props.listeing.area,
    code: props.listeing.code,
    street: props.listeing.street,
    street_nr: props.listeing.street_nr,
    price: props.listeing.price,
});

const submit = () => {
    form.put(route("listeing.update", props.listeing.id), form);
};
</script>
