<template>
    <h1 class="text-3xl mb-4">{{ $t("your_notifications") }}</h1>
    <section
        v-if="notifications.data.length"
        class="text-gray-700 dark:text-gray-400"
    >
        <div
            v-for="notification in notifications.data"
            :key="notification.id"
            class="border-b border-gray-200 dark:border-gray-800 py-4 flex justify-between items-center"
        >
            <div>
                <span
                    v-if="notification.type === 'App\\Notifications\\OfferMade'"
                >
                    {{ $t("offer_made") }}
                    <listeing-price :price="notification.data.amount" />
                    {{ $t("for") }}
                    <Link
                        :href="
                            route('offer.index', notification.data.listeing_id)
                        "
                        class="text-indigo-600 dark:text-indigo-400"
                        >{{ $t("listeing") }}</Link
                    >
                </span>
            </div>
            <div>
                <Link
                    class="btn-outline text-xs font-medium uppercase"
                    v-if="!notification.read_at"
                    :href="route('notifications.edit', notification.id)"
                    >{{ $t("mark_as_read") }}</Link
                >
            </div>
        </div>
    </section>
    <empty v-else>{{ $t("no_notifications") }}</empty>
    <section
        v-if="notifications.data.length"
        class="w-full flex justify-center my-8"
    >
        <pagination :links="notifications.links" />
    </section>
</template>
<script setup>
import Empty from "@/Components/UI/Empty.vue";
import Pagination from "@/Components/UI/Pagination.vue";
import { Link } from "@inertiajs/vue3";
import ListeingPrice from "@/Components/ListeingPrice.vue";

const props = defineProps({
    notifications: Object,
});
</script>
