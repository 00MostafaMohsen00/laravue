<template>
    <form @submit.prevent="filter">
        <div class="mb-8 mt-4 flex flex-wrap gap-2">
            <div class="flex flex-nowrap items-center">
                <input
                    type="text"
                    :placeholder="$t('price_from')"
                    class="filter-input-l rtl:filter-input-r w-28"
                    v-model.number="filterForm.priceFrom"
                />
                <input
                    type="text"
                    :placeholder="$t('price_to')"
                    class="filter-input-r rtl:filter-input-l w-28"
                    v-model.number="filterForm.priceTo"
                />
            </div>
            <div class="flex flex-nowrap items-center">
                <select
                    class="filter-input-l rtl:filter-input-r w-28"
                    v-model="filterForm.beds"
                >
                    <option :value="null">{{ $t("beds") }}</option>
                    <option v-for="n in 5" :value="n" :key="n">
                        {{ n }}
                    </option>
                    <option :value="6">6+</option>
                </select>
                <select
                    class="filter-input-r rtl:filter-input-l w-28"
                    v-model="filterForm.baths"
                >
                    <option :value="null">{{ $t("baths") }}</option>
                    <option v-for="n in 5" :value="n" :key="n">
                        {{ n }}
                    </option>
                    <option :value="6">6+</option>
                </select>
            </div>
            <div class="flex flex-nowrap items-center">
                <input
                    type="text"
                    :placeholder="$t('area_from')"
                    class="filter-input-l rtl:filter-input-r w-28"
                    v-model.number="filterForm.areaFrom"
                />
                <input
                    type="text"
                    :placeholder="$t('price_to')"
                    class="filter-input-r rtl:filter-input-l w-28"
                    v-model.number="filterForm.areaTo"
                />
            </div>
            <button type="submit" class="btn-dark">{{ $t("filter") }}</button>
            <button type="reset" @click="reset">{{ $t("reset") }}</button>
        </div>
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
const props = defineProps({
    filters: Object,
});

const filterForm = useForm({
    priceFrom: props.filters.priceFrom ?? null,
    priceTo: props.filters.priceTo ?? null,
    beds: props.filters.beds ?? null,
    baths: props.filters.baths ?? null,
    areaFrom: props.filters.areaFrom ?? null,
    areaTo: props.filters.areaTo ?? null,
});

const filter = () => {
    filterForm.get(route("listeing.index"), {
        preserveState: true,
        preserveScroll: true,
    });
};

const reset = () => {
    filterForm.priceFrom = null;
    filterForm.priceTo = null;
    filterForm.beds = null;
    filterForm.baths = null;
    filterForm.areaFrom = null;
    filterForm.areaTo = null;
    filter();
};
</script>
