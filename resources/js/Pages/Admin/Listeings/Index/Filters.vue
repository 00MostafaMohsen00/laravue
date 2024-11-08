<template>
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
        <div>
            <select
                class="filter-input-l rtl:filter-input-r w-24"
                v-model="filterForm.by"
            >
                <option value="created_at">{{ $t("added") }}</option>
                <option value="price">{{ $t("price") }}</option>
            </select>
            <select
                class="filter-input-r rtl:filter-input-l w-24"
                v-model="filterForm.order"
            >
                <option
                    v-for="option in sortOptions"
                    :key="option.value"
                    :value="option.value"
                >
                    {{ option.label }}
                </option>
            </select>
        </div>
        <div class="flex flex-nowrap items-center gap-2">
            <input
                v-model="filterForm.deleted"
                type="checkbox"
                id="deleted"
                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-400"
            />
            <label for="deleted">{{ $t("deleted") }}</label>
        </div>
        <div class="flex flex-nowrap items-center gap-2">
            <input
                v-model="filterForm.soled"
                type="checkbox"
                id="soled"
                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-400"
            />
            <label for="soled">{{ $t("sold") }}</label>
        </div>
        <button type="reset" @click="reset" class="btn-outline">
            {{ $t("reset") }}
        </button>
    </div>
</template>

<script setup>
import { router } from "@inertiajs/vue3";
import { computed, reactive } from "vue";
import { watch } from "vue";
import { useI18n } from "vue-i18n";
import debounce from "lodash/debounce";
const { t } = useI18n();
const props = defineProps({
    filters: Object,
});

const filterForm = reactive({
    priceFrom: props.filters.priceFrom ?? null,
    priceTo: props.filters.priceTo ?? null,
    beds: props.filters.beds ?? null,
    baths: props.filters.baths ?? null,
    areaFrom: props.filters.areaFrom ?? null,
    areaTo: props.filters.areaTo ?? null,
    deleted: props.filters.deleted ?? false,
    soled: props.filters.soled ?? false,
    by: props.filters.by ?? "created_at",
    order: props.filters.order ?? "desc",
    page: props.filters.page ?? 1,
});

const sortable = {
    created_at: [
        {
            label: t("newest"),
            value: "desc",
        },
        {
            label: t("oldest"),
            value: "asc",
        },
    ],
    price: [
        {
            label: t("lowest"),
            value: "asc",
        },
        {
            label: t("highest"),
            value: "desc",
        },
    ],
};
const sortOptions = computed(() => {
    return sortable[filterForm.by] ?? sortable.created_at;
});

const reset = () => {
    filterForm.priceFrom = null;
    filterForm.priceTo = null;
    filterForm.beds = null;
    filterForm.baths = null;
    filterForm.areaFrom = null;
    filterForm.areaTo = null;
    filterForm.deleted = false;
    filterForm.soled = false;
    filterForm.by = "created_at";
    filterForm.order = "desc";
};

watch(
    filterForm,
    debounce(() => {
        router.get(route("listeings.index"), filterForm, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        });
    }),
    1000
);
</script>
