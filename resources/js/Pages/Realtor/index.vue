<template>
    <h1 class="text-3xl mb-4">{{ $t("your_listings") }}</h1>
    <section>
        <filters :filters="filters" />
    </section>
    <section
        v-if="listeings.data.length"
        class="grid grid-cols-1 lg:grid-cols-2 gap-2"
    >
        <Box
            v-for="listeing in listeings.data"
            :key="listeing.id"
            :class="{ 'border-dashed': listeing.deleted_at }"
        >
            <div
                class="flex flex-col md:flex-row gap-2 md:items-center justify-between"
                :class="{ 'opacity-50': listeing.deleted_at }"
            >
                <div
                    v-if="listeing.sold_at"
                    class="text-xs font-bold uppercase border border-dashed p-1 border-green-300 text-green-500 dark:border-green-600 dark:text-green-600 inline-block rounded-md mb-2"
                >
                    {{ $t("sold") }}
                </div>
                <div class="xl:flex items-center gap-2">
                    <listeing-price
                        :price="listeing.price"
                        class="text-2xl font-medium"
                    />
                    <listeing-space :listeing="listeing" />
                    <listeing-address
                        :listeing="listeing"
                        class="text-gray-500"
                    />
                </div>
            </div>
            <div
                class="flex items-center gap-1 text-gray-600 dark:text-gray-300 my-2 w-full"
                v-if="!listeing.deleted_at"
            >
                <Link
                    class="btn-outline w-full text-center"
                    :href="route('listeing.show', listeing.id)"
                    >{{ $t("preview") }}</Link
                >
                <Link
                    class="btn-outline w-full text-center"
                    :href="route('listeing.edit', listeing.id)"
                    v-if="!listeing.sold_at"
                    >{{ $t("edit") }}</Link
                >
                <Link
                    class="btn-outline w-full text-center"
                    method="delete"
                    as="button"
                    :href="route('realtor.listeing.destroy', listeing.id)"
                    >{{ $t("delete") }}</Link
                >
            </div>
            <div
                class="flex items-center gap-1 text-gray-600 dark:text-gray-300 my-8"
                v-if="listeing.deleted_at"
            >
                <Link
                    class="btn-outline w-full text-center"
                    :href="route('realtor.listeing.restore', listeing.id)"
                    >{{ $t("restore") }}</Link
                >
            </div>
            <div class="mt-2" v-if="!listeing.deleted_at">
                <Link
                    :href="route('images.create', listeing.id)"
                    class="block btn-outline w-full text-xs font-medium text-center"
                    >{{ $t("images") }} ({{ listeing.images_count }})</Link
                >
                <Link
                    :href="route('offer.index', listeing.id)"
                    class="block btn-outline w-full text-xs font-medium text-center mt-2"
                    >{{ $t("offers") }} ({{ listeing.offers_count }})</Link
                >
            </div>
        </Box>
    </section>

    <empty v-else>{{ $t("no_listeing") }}</empty>
    <section>
        <div class="w-full flex justify-center mt-4 mb-4">
            <pagination :links="listeings.links" />
        </div>
    </section>
</template>
<script setup>
import Box from "@/Components/UI/Box.vue";
import ListeingPrice from "@/Components/ListeingPrice.vue";
import ListeingSpace from "@/Components/ListeingSpace.vue";
import ListeingAddress from "@/Components/ListeingAddress.vue";
import Filters from "@/Pages/Realtor/Index/Components/Filters.vue";
import Pagination from "@/Components/UI/Pagination.vue";
import Empty from "@/Components/UI/Empty.vue";
import { Link } from "@inertiajs/vue3";
defineProps({
    listeings: Array,
    filters: Object,
});
</script>
