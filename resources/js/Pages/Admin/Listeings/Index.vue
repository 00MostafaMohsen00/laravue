<template>
    <box class="h-full">
        <template #title> {{ $t("listeings") }} </template>
        <Filters :filters="filters" />

        <div v-if="listeings.data.length">
            <box v-for="listeing in listeings.data" :key="listeing.id">
                <div class="grid grid-cols-2">
                    <div class="flex flex-col justify-between my-2">
                        <listeing-price
                            :price="listeing.price"
                            class="text-2xl font-bold"
                        />

                        <listeing-space :listeing="listeing" class="text-lg" />
                        <listeing-address
                            :listeing="listeing"
                            class="text-gray-500"
                        />
                    </div>
                    <div class="flex flex-col gap-2">
                        <span
                            v-if="listeing.sold_at"
                            class="text-xs font-bold uppercase border border-dashed p-1 border-green-300 text-green-500 dark:border-green-600 dark:text-green-600 inline-block rounded-md mb-2"
                        >
                            {{ $t("sold") }}
                        </span>
                        <Link
                            v-if="!listeing.deleted_at"
                            class="btn-outline text-center"
                            :href="route('listeings.show', listeing.id)"
                            >{{ $t("preview") }}</Link
                        >
                        <Link
                            class="btn-red text-center"
                            method="delete"
                            as="button"
                            v-if="canDelete"
                            :href="route('listeings.destroy', listeing.id)"
                            >{{ $t("delete") }}</Link
                        >
                    </div>
                </div>
            </box>
        </div>
        <empty v-else class="my-4">{{ $t("no_listeing") }}</empty>
        <pagination :links="listeings.links" v-if="listeings.data.length" />
    </box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import { defineProps, computed } from "vue";
import Pagination from "@/Components/UI/Pagination.vue";
import Empty from "@/Components/UI/Empty.vue";
import ListeingAddress from "@/Components/ListeingAddress.vue";
import ListeingSpace from "@/Components/ListeingSpace.vue";
import ListeingPrice from "@/Components/ListeingPrice.vue";
import Filters from "@/Pages/Admin/Listeings/Index/Filters.vue";
import { Link, usePage } from "@inertiajs/vue3";
import { usePermission } from "@/Composable/usePermission";
defineProps({
    listeings: Array,
    filters: Object,
});
const perms = computed(() => usePage().props.user_permissions);
const canDelete = computed(() => {
    const { can } = usePermission("delete listeings", perms.value);
    return can.value;
});
</script>
