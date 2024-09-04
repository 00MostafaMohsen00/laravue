<template>
    <filters :filters="filters" />
    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-3 gap-1">
        <listeing
            v-for="listeing in listeings.data"
            :key="listeing.id"
            :listeing="listeing"
        />
    </div>
    <div
        v-if="listeings.data.length"
        class="w-full flex justify-center mt-4 mb-4"
    >
        <pagination :links="listeings.links" />
    </div>
    <Empty v-if="listeings.data.length == 0">{{ $t("no_listeing") }}</Empty>
</template>
<script setup>
import Listeing from "@/Pages/Listeings/Index/Components/Listeing.vue";
import Pagination from "@/Components/UI/Pagination.vue";
import Filters from "@/Pages/Listeings/Index/Components/Filters.vue";
import Empty from "@/Components/UI/Empty.vue";
defineProps({
    listeings: Object,
    filters: Object,
});
</script>
