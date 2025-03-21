<template>
    <box class="h-screen">
        <template #title> {{ $t("users") }} </template>
        <Link :href="route('users.create')" class="my-4" v-if="canCreate">
            <button class="btn-border">
                <i class="fas fa-plus icon"></i>
            </button>
        </Link>
        <div class="flex justify-center text-center my-2">
            <input
                type="search"
                class="input"
                :placeholder="search"
                v-model="form.search"
                ref="searchInput"
            />
        </div>

        <div v-if="users.data.length">
            <box
                v-for="user in users.data"
                :key="user.id"
                class="flex flex-col justify-between my-2"
            >
                <div class="flex flex-row justify-between">
                    <div class="flex flex-col">
                        <div>{{ $t("name") }} : {{ user.name }}</div>
                        <div class="text-gray-500">
                            {{ $t("email") }} : {{ user.email }}
                        </div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <Link
                            v-if="canDelete"
                            :href="route('users.destroy', user.id)"
                            method="delete"
                            as="button"
                            class="btn-outline"
                        >
                            <i
                                v-if="user.status == '1'"
                                class="fas fa-xmark icon text-red-500 dark:text-red-600"
                            ></i>
                            <i
                                v-else
                                class="fas fa-check icon text-green-500 dark:text-green-600"
                            ></i>
                        </Link>
                        <Link
                            v-if="canUpdate"
                            :href="route('users.edit', user.id)"
                            class="btn-outline"
                        >
                            <i class="fas fa-edit icon"></i>
                        </Link>
                    </div>
                </div>
            </box>
        </div>
        <empty v-else class="my-4">{{ $t("no_user") }}</empty>
        <pagination :links="users.links" v-if="users.data.length" />
    </box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import { watch, reactive, ref, onMounted, computed } from "vue";
import Pagination from "@/Components/UI/Pagination.vue";
import Empty from "@/Components/UI/Empty.vue";
import { useI18n } from "vue-i18n";
import { router, Link, usePage } from "@inertiajs/vue3";
import { useStore } from "vuex";
import { usePermission } from "@/Composable/usePermission";
import debounce from "lodash/debounce";
const store = useStore();
const { t } = useI18n();
const searchInput = ref();
onMounted(() => {
    searchInput.value.focus();
});
const props = defineProps({
    users: Array,
    filters: null,
});
const form = reactive({
    search: props.filters ? props.filters.search : "",
});
const search = t("search");

watch(
    form,
    debounce(() => {
        store.dispatch("setisSearchActive", true);
        router.get(route("users.index", form), {
            preserveState: true,
            preserveScroll: true,
        });
        store.dispatch("setisSearchActive", false);
    }),
    1000
);
const perms = computed(() => usePage().props.user_permissions);
const canDelete = computed(() => {
    const { can } = usePermission("delete users", perms.value);
    return can.value;
});
const canCreate = computed(() => {
    const { can } = usePermission("create users", perms.value);
    return can.value;
});
const canUpdate = computed(() => {
    const { can } = usePermission("update users", perms.value);
    return can.value;
});
</script>
