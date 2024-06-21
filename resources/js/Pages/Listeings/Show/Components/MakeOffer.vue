<template>
    <Box>
        <template #title>{{ $t("make_offer") }} </template>
        <div>
            <form @submit.prevent="makeOffer">
                <input type="text" class="input" v-model.number="form.amount" />
                <input
                    type="range"
                    :min="min"
                    :max="max"
                    step="10000"
                    class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700 mt-2"
                    v-model.number="form.amount"
                />
                <error v-if="form.errors.amount" :error="form.errors.amount" />
                <button type="submit" class="btn-outline w-full mt-2 text-sm">
                    {{ $t("make_offer") }}
                </button>
            </form>
        </div>
        <div class="flex justify-between text-gray-500 mt-2">
            <div>{{ $t("difference") }}</div>
            <div>
                <listeing-price :price="difference" />
            </div>
        </div>
    </Box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import ListeingPrice from "@/Components/ListeingPrice.vue";
import Error from "@/Components/UI/Error.vue";
import { useForm } from "@inertiajs/vue3";
import { computed, watch } from "vue";
import { debounce } from "lodash";
const props = defineProps({
    listeing: Object,
});
const form = useForm({
    amount: props.listeing.price ?? 0,
});

const makeOffer = () => {
    form.post(route("offer.store", props.listeing.id), {
        preserveScroll: true,
        preserveState: true,
    });
};

const difference = computed(() => form.amount - props.listeing.price);
const min = computed(() => {
    return Math.round(props.listeing.price / 2);
});

const max = computed(() => {
    return Math.round(props.listeing.price * 2);
});

const emit = defineEmits(["offerUpdated"]);
watch(
    () => form.amount,
    debounce((value) => {
        emit("offerUpdated", value);
    }, 500)
);
</script>
