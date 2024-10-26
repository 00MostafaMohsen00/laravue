<template>
    <box class="h-full">
        <template #title> {{ $t("listeings") }} </template>
        <Filters :filters="filters" />

        <div v-if="listeings.data.length">
            <box
                v-for="listeing in listeings.data"
                :key="listeing.id"
                class="flex flex-col justify-between my-2"
            >
                <listeing-price
                    :price="listeing.price"
                    class="text-2xl font-bold"
                />

                <listeing-space :listeing="listeing" class="text-lg" />
                <listeing-address :listeing="listeing" class="text-gray-500" />
            </box>
        </div>
        <empty v-else class="my-4">{{ $t("no_listeing") }}</empty>
        <pagination :links="listeings.links" v-if="listeings.data.length" />
    </box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import { defineProps } from "vue";
import Pagination from "@/Components/UI/Pagination.vue";
import Empty from "@/Components/UI/Empty.vue";
import ListeingAddress from "@/Components/ListeingAddress.vue";
import ListeingSpace from "@/Components/ListeingSpace.vue";
import ListeingPrice from "@/Components/ListeingPrice.vue";
import Filters from "@/Pages/Admin/Listeings/Index/Filters.vue";
defineProps({
    listeings: Array,
    filters: Object,
});
</script>
