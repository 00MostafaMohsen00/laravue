<template>
    <form @submit.prevent="">
        <div class="mb-4 mt-4 flex flex-wrap gap-4">
            <div class="flex flex-nowrap items-center gap-2">
                <input
                    v-model="filterForm.deleted"
                    type="checkbox"
                    id="deleted"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-400"
                />
                <label for="deleted">{{ $t("deleted") }}</label>
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
        </div>
    </form>
</template>

<script setup>
import { reactive, watch, computed } from "vue";
import { router } from "@inertiajs/vue3";
import debounce from "lodash/debounce";
import { useI18n } from "vue-i18n";
const { t } = useI18n();
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
const props = defineProps({
    filters: Object,
});

const sortOptions = computed(() => {
    return sortable[filterForm.by] ?? sortable.created_at;
});

const filterForm = reactive({
    deleted: props.filters.deleted ?? false,
    by: props.filters.by ?? "created_at",
    order: props.filters.order ?? "desc",
    page: props.filters.page ?? 1,
});

watch(
    filterForm,
    debounce(() => {
        router.get(route("realtor.listeing.index"), filterForm, {
            replace: true,
            preserveState: true,
        });
    }),
    1000
);
</script>
