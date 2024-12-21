<template>
    <div class="mb-4">
        <Link :href="route('realtor.listeing.index')">
            <i class="fas fa-arrow-left"></i>
            {{ $t("go_to_listeing") }}</Link
        >
    </div>
    <section class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
        <box class="md:col-span-7 flex items-center" v-if="!showOffers">
            <div class="w-full text-center font-medium text-gray-500">
                {{ $t("no_offers") }}
            </div>
        </box>
        <div v-else class="md:col-span-7 flex flex-col gab-4">
            <offer
                v-for="offer in offers"
                :key="offer.id"
                :offer="offer"
                :listeing="listeing"
            ></offer>
        </div>
        <div class="md:col-span-5">
            <box>
                <template #title> {{ $t("basic_info") }} </template>
                <listeing-price
                    :price="listeing.price"
                    class="text-2xl font-bold"
                />
                <listeing-space :listeing="listeing" class="text-lg" />
                <listeing-address :listeing="listeing" class="text-gray-500" />
            </box>
        </div>
    </section>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import Box from "@/Components/UI/Box.vue";
import Offer from "@/Pages/Offers/Index/Offer.vue";
import ListeingPrice from "@/Components/ListeingPrice.vue";
import ListeingSpace from "@/Components/ListeingSpace.vue";
import { computed } from "vue";
const props = defineProps({
    offers: Array,
    listeing: Object,
});
const showOffers = computed(() => {
    return props.offers.length;
});
</script>
