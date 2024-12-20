<template>
    <header
        class="border-b bg-white bordeer-gray-200 dark:border-gray-700 dark:bg-gray-800 sticky top-0 z-50 w-full"
    >
        <div class="container mx-auto">
            <nav class="p-4 flex justify-between items-center">
                <div
                    class="text-xl text-indigo-600 dark:text-indigo-300 font-bold text-center"
                >
                    <Link :href="route('admin.dashboard')">{{ app_name }}</Link>
                </div>

                <div class="flex items-center gap-4">
                    <button
                        class="btn-outline"
                        @click="
                            isMenuOpen = !isMenuOpen;
                            isMainMenuOpen = false;
                        "
                    >
                        {{ local_name }}
                    </button>
                    <transition>
                        <div
                            v-if="isMenuOpen"
                            class="ltr:origin-top-right rtl:origin-top-left rtl:left-10 absolute ltr:right-10 top-20 mt-2 w-56 rounded-md shadow-lg border border-md bg-white bordeer-gray-200 dark:border-gray-700 dark:bg-gray-800 z-10 p-2"
                        >
                            <div class="py-1">
                                <button
                                    v-for="(lang, index) in langs"
                                    :key="index"
                                    class="menu-item"
                                    @click="setLocale(index)"
                                >
                                    {{ lang["native"] }}
                                </button>
                            </div>
                        </div>
                    </transition>
                    <button
                        class="btn-outline flex flex-col gap-0 w-8 relative"
                        @click="
                            isMainMenuOpen = !isMainMenuOpen;
                            isMenuOpen = false;
                        "
                    >
                        <span v-for="i in 3" :key="i" class="btn-border"></span>
                    </button>
                    <transition>
                        <div
                            v-if="isMainMenuOpen"
                            class="ltr:origin-top-right rtl:origin-top-left rtl:left-10 absolute ltr:right-10 top-20 mt-2 w-56 rounded-md shadow-lg border border-md bg-white bordeer-gray-200 dark:border-gray-700 dark:bg-gray-800 flex flex-col justify-center align-center z-10 p-2"
                        >
                            <button
                                @click.prevent="toggleDark"
                                class="menu-item"
                            >
                                {{ emoji }}
                            </button>
                            <div v-if="user" class="flex flex-col gap-1">
                                <Link
                                    class="menu-item text-center"
                                    :href="route('admin.logout')"
                                    method="delete"
                                    as="button"
                                    >{{ $t("logout") }}</Link
                                >
                            </div>
                            <div v-else class="flex items-center gap-4">
                                <Link
                                    :href="route('admin.login')"
                                    class="menu-item text-center"
                                    >{{ $t("login") }}</Link
                                >
                            </div>
                        </div>
                    </transition>
                </div>
            </nav>
        </div>
    </header>
</template>
<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed, onMounted, ref, onBeforeMount } from "vue";
const page = usePage();
const user = computed(() => page.props.user);

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
const isMainMenuOpen = ref(false);
onBeforeMount(() => {
    // Add event listener to close the menu when the user clicks outside of the menu
    window.addEventListener("click", (event) => {
        if (!event.target.classList.contains("btn-outline")) {
            isMenuOpen.value = false;
            isMainMenuOpen.value = false;
        }
    });
    window.addEventListener("scroll", () => {
        isMenuOpen.value = false;
        isMainMenuOpen.value = false;
    });
});

const setLocale = (selectedlocale) => {
    window.location.href = (window.location.href + "/").replace(
        `/${local.value}/`,
        `/${selectedlocale}/`
    );
};

const app_name = computed(() => {
    return import.meta.env.VITE_APP_NAME;
});
</script>
