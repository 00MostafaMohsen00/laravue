<template>
    <header
        class="border-b bg-white bordeer-gray-200 dark:border-gray-700 dark:bg-gray-800 w-full"
    >
        <div class="container mx-auto">
            <nav class="p-4 flex justify-between items-center">
                <div class="text-lg font-medium">
                    <Link :href="route('listeing.index')">{{
                        $t("Listeings")
                    }}</Link>
                </div>
                <div
                    class="text-xl text-indigo-600 dark:text-indigo-300 font-bold text-center"
                >
                    <Link href="/">{{ app_name }}</Link>
                </div>

                <div class="flex items-center gap-4">
                    <button @click.prevent="toggleDark">
                        {{ emoji }}
                    </button>
                    <button class="btn-outline" @click="toggleLocale">
                        {{ local_name }}
                    </button>
                    <transition>
                        <div
                            v-if="isMenuOpen"
                            class="origin-top-right absolute right-30 top-20 mt-2 w-56 rounded-md shadow-lg border border-md bg-white bordeer-gray-200 dark:border-gray-700 dark:bg-gray-800"
                        >
                            <div class="py-1">
                                <button
                                    v-for="(lang, index) in langs"
                                    :key="index"
                                    class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 w-full"
                                    @click="setLocale(index)"
                                >
                                    {{ lang["native"] }}
                                </button>
                            </div>
                        </div>
                    </transition>

                    <div v-if="user" class="flex items-center gap-4">
                        <Link :href="route('notifications.index')">
                            <div
                                class="text-gray-500 relative pr-2 py-2 text-lg"
                            >
                                🔔
                                <div
                                    v-if="notifications_count > 0"
                                    class="absolute right-0 top-0 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center"
                                >
                                    {{ notifications_count }}
                                </div>
                            </div>
                        </Link>
                        <Link :href="route('realtor.listeing.index')"
                            ><div class="text-sm text-gray-500">
                                {{ user.name }}
                            </div>
                        </Link>
                        <Link :href="route('listeing.create')" class="btn"
                            >{{ $t("create") }} +</Link
                        >
                        <Link
                            :href="route('logout')"
                            method="delete"
                            as="button"
                            >{{ $t("logout") }}</Link
                        >
                    </div>
                    <div v-else class="flex items-center gap-4">
                        <Link :href="route('login')" class="btn">{{
                            $t("login_register")
                        }}</Link>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <main class="container mx-auto p-4 w-full">
        <transition>
            <div
                v-if="message && showMessage"
                class="mb-4 border rounded shadow-sm border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900 p-2"
            >
                {{ message }}
            </div>
        </transition>
        <transition>    
            <Loader />
        </transition>
        <slot></slot>
    </main>
    <!-- Print the success message -->
</template>

<script setup>
import { Link, usePage, router } from "@inertiajs/vue3";
import { computed, watch, ref, onMounted, onBeforeMount } from "vue";
import Loader from "@/Components/UI/Loader.vue";
const page = usePage();
const showMessage = ref(false);
const message = computed(() => {
    showMessage.value = true;
    return page.props.flash.success;
});
const user = computed(() => page.props.user);
watch(showMessage, () => {
    setTimeout(() => {
        showMessage.value = false;
    }, 1000);
});

const notifications_count = computed(() => {
    return Math.min(page.props.notifications_count, 9);
});

const isDark = ref(false);
onMounted(() => {
    if (localStorage.getItem("isDark") === "true") {
        isDark.value = true;
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
        isDark.value = false;
    }
});
const toggleDark = () => {
    isDark.value = !isDark.value;
    document.documentElement.classList.toggle("dark");
    localStorage.setItem("isDark", isDark.value);
};

const emoji = computed(() => (isDark.value ? "☀️" : "🌙"));
const langs = computed(() => {
    return page.props.languages;
});

const local_name = computed(() => {
    return page.props.local_name;
});

const local = computed(() => {
    return page.props.local_code;
});

const isMenuOpen = ref(false);

onBeforeMount(() => {
    // Add event listener to close the menu when the user clicks outside of the menu
    window.addEventListener("click", (event) => {
        if (!event.target.classList.contains("btn-outline")) {
            isMenuOpen.value = false;
        }
    });
    window.addEventListener("scroll", () => {
        isMenuOpen.value = false;
    });
});
const toggleLocale = () => {
    isMenuOpen.value = !isMenuOpen.value;
};
const setLocale = (selectedlocale) => {
    window.location.href = (window.location.href + "/").replace(
        `/${local.value}/`,
        `/${selectedlocale}/`
    );
};

const app_name = computed(() => {
    return import.meta.env.VITE_APP_NAME;
});
//
</script>
