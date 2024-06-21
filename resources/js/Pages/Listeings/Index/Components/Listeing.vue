<template>
    <box>
        <Link :href="route('listeing.show', listeing.id)">
            <div class="flex items-center gap-1">
                <listeing-price
                    :price="listeing.price"
                    class="text-2xl font-bold"
                />
                <div class="text-xs text-gray-500">
                    <listeing-price :price="monthlyPayment" /> pm
                </div>
            </div>

            <listeing-space :listeing="listeing" class="text-lg" />
            <listeing-address :listeing="listeing" class="text-gray-500" />
        </Link>
    </box>
</template>
<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import Box from "@/Components/UI/Box.vue";
import ListeingAddress from "@/Components/ListeingAddress.vue";
import ListeingSpace from "@/Components/ListeingSpace.vue";
import ListeingPrice from "@/Components/ListeingPrice.vue";
import { useMonthlyPayment } from "@/Composable/useMonthlyPayment";
import { computed } from "vue";
const props = defineProps({
    listeing: Object,
});
const page = usePage();
const user = computed(() => page.props.user);
const { monthlyPayment } = useMonthlyPayment(props.listeing.price, 2.5, 25);
</script>
