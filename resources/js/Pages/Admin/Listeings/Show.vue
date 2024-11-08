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
                <template #title> {{ $t("offers") }} </template>
                <div
                    class="w-full text-center font-medium text-gray-500"
                    v-if="!listeing.offers.length"
                >
                    {{ $t("no_offers") }}
                </div>
                <div v-else class="md:col-span-7 flex flex-col gab-4">
                    <offer
                        v-for="offer in listeing.offers"
                        :key="offer.id"
                        :offer="offer"
                        :listeing="listeing"
                        :admin="1"
                    ></offer>
                </div>
            </box>
        </div>
    </div>
</template>

<script setup>
import ListeingAddress from "@/Components/ListeingAddress.vue";
import ListeingSpace from "@/Components/ListeingSpace.vue";
import ListeingPrice from "@/Components/ListeingPrice.vue";
import Box from "@/Components/UI/Box.vue";
import Empty from "@/Components/UI/Empty.vue";
import Image from "@/Components/UI/Image.vue";
import Offer from "@/Pages/Offers/Index/Offer.vue";

const props = defineProps({
    listeing: Object,
});
</script>
