<template>
    <box>
        <template #title> {{ $t("offer_made") }} </template>
        <listeing-price :price="offer.amount" class="text-3xl" />
        <section
            class="mt-2 flex flex-col md:flex-row justify-between text-gray-500"
        >
            <div>{{ $t("made_on") }}</div>
            <div class="font-medium">{{ createdAt }}</div>
        </section>
    </box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import ListeingPrice from "@/Components/ListeingPrice.vue";
import { computed } from "vue";

const props = defineProps({
    offer: Object,
});

const createdAt = computed(() => {
    return new Date(props.offer.created_at).toDateString();
});
</script>
