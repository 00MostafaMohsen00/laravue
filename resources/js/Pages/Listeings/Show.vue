<template>
    <div class="flex flex-col-reverse md:grid md:grid-cols-12 md:gap-4">
        <box
            class="md:col-span-7 flex items-center justify-center w-full"
            v-if="props.listeing.images.length"
        >
            <section class="mt-4 grid grid-cols-2 gap-1">
                <div v-for="image in props.listeing.images" :key="image.id">
                    <Image :src="image.image_url" />
                </div>
            </section>
        </box>
        <empty
            v-else
            class="md:col-span-7 flex items-center justify-center w-full"
        >
            {{ $t("no_image") }}
        </empty>
        <div class="md:col-span-5 flex flex-col gap-4">
            <box>
                <template #title> {{ $t("info") }} </template>
                <listeing-price
                    :price="listeing.price"
                    class="text-2xl text-bold font-bold"
                />
                <listeing-space :listeing="listeing" class="text-lg" />
                <listeing-address :listeing="listeing" class="text-gray-500" />
            </box>
            <box>
                <template #title> {{ $t("monthly_payment") }} </template>
                <div>
                    <label class="label"
                        >{{ $t("interest_rate") }} ({{ insertRate }}%)</label
                    >
                    <input
                        v-model.number="insertRate"
                        type="range"
                        min="0.1"
                        max="30"
                        step="0.1"
                        class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                    />
                    <label class="label"
                        >{{ $t("duration") }} ({{ years }}
                        {{ $t("years") }})</label
                    >
                    <input
                        v-model.number="years"
                        type="range"
                        min="3"
                        max="35"
                        step="1"
                        class="w-full h-4 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700"
                    />
                    <div class="text-gray-600 dark:text-gray-300 mt-2">
                        <div class="text-gray-400">
                            {{ $t("your_monthly_payment") }}
                        </div>
                        <listeing-price
                            :price="monthlyPayment"
                            class="text-3xl"
                        />
                    </div>
                    <div class="mt-2 text-gray-500">
                        <div class="flex justify-between">
                            <div>{{ $t("total_paid") }} :</div>
                            <div>
                                <listeing-price
                                    :price="totalPaid"
                                    class="font-medium"
                                />
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div>{{ $t("principal_paid") }} :</div>
                            <div>
                                <listeing-price
                                    :price="listeing.price"
                                    class="font-medium"
                                />
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div>{{ $t("total_interest") }} :</div>
                            <div>
                                <listeing-price
                                    :price="totalInsert"
                                    class="font-medium"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </box>
            <make-offer
                :listeing="listeing"
                @offer-updated="offer = $event"
                v-if="
                    !listeing.offers.length &&
                    !listeing.sold_at &&
                    listeing.user_id != user.id
                "
            />
            <show-offer
                v-if="listeing.offers.length"
                :offer="listeing.offers[0]"
            />
        </div>
    </div>
</template>

<script setup>
import ListeingAddress from "@/Components/ListeingAddress.vue";
import ListeingSpace from "@/Components/ListeingSpace.vue";
import ListeingPrice from "@/Components/ListeingPrice.vue";
import Box from "@/Components/UI/Box.vue";
import { computed, ref } from "vue";
import { useMonthlyPayment } from "@/Composable/useMonthlyPayment";
import MakeOffer from "@/Pages/Listeings/Show/Components/MakeOffer.vue";
import ShowOffer from "@/Pages/Listeings/Show/Components/ShowOffer.vue";
import Empty from "@/Components/UI/Empty.vue";
import Image from "@/Components/UI/Image.vue";
import { usePage } from "@inertiajs/vue3";
const insertRate = ref(2.5);
const years = ref(25);
const page = usePage();
const props = defineProps({
    listeing: Object,
});
const user = computed(() => {
    return page.props.user;
});
const offer = ref(props.listeing.price);
const { monthlyPayment, totalPaid, totalInsert } = useMonthlyPayment(
    offer,
    insertRate,
    years
);
</script>
