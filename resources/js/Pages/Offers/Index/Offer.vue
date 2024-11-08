<template>
    <box>
        <template #title>
            {{ $t("offer") }} #{{ offer.id }}
            <span
                v-if="offer.accepted_at"
                class="dark:bg-green-900 dark:text-green-200 bg-green-200 text-green-900 p-1 rounded-md uppercase ml-1"
                >{{ $t("accepted") }}</span
            ></template
        >
        <section class="flex justify-between items-center">
            <div>
                <listeing-price :price="offer.amount" class="text-xl" />
                <div class="text-gray-500">
                    {{ $t("difference") }} :
                    <listeing-price :price="difference" class="text-xl" />
                </div>
                <div class="text-gray-500 text-sm">
                    {{ $t("made_by") }} {{ offer.user.name }}
                </div>
                <div class="text-gray-500 text-sm">
                    {{ $t("made_on") }} {{ createdAt }}
                </div>
            </div>
            <div>
                <Link
                    v-if="
                        !offer.accepted_at &&
                        !offer.rejected_at &&
                        !admin == '1'
                    "
                    class="btn-outline text-xs font-medium"
                    as="button"
                    method="post"
                    :href="route('offer.accept', offer.id)"
                    >{{ $t("accept") }}</Link
                >
            </div>
        </section>
    </box>
</template>
<script setup>
import Box from "@/Components/UI/Box.vue";
import ListeingPrice from "@/Components/ListeingPrice.vue";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
const props = defineProps({
    offer: Object,
    listeing: Object,
    admin: null,
});

const difference = computed(() => props.offer.amount - props.listeing.price);
const createdAt = computed(() => {
    return new Date(props.offer.created_at).toDateString();
});
</script>
