<template>
    <header
        class="border-b bg-white bordeer-gray-200 dark:border-gray-700 dark:bg-gray-800 w-full sticky top-0 z-50"
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
                            class="ltr:origin-top-right rtl:origin-top-left rtl:left-10 absolute ltr:right-10 top-20 mt-2 w-56 rounded-md shadow-lg border border-md bg-white bordeer-gray-200 dark:border-gray-700 dark:bg-gray-800 z-10"
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
                        <span
                            v-if="notifications_count > 0"
                            class="absolute top-1 right-1 w-2 h-2 rounded-full bg-red-500 text-white text-xs flex justify-center items-center"
                        >
                        </span>
                        <span v-for="i in 3" :key="i" class="btn-border"></span>
                    </button>
                    <transition>
                        <div
                            v-if="isMainMenuOpen"
                            class="ltr:origin-top-right rtl:origin-top-left rtl:left-10 absolute ltr:right-10 top-20 mt-2 w-56 rounded-md shadow-lg border border-md bg-white bordeer-gray-200 dark:border-gray-700 dark:bg-gray-800 flex flex-col justify-center align-center z-10"
                        >
                            <button
                                @click.prevent="toggleDark"
                                class="menu-item"
                            >
                                {{ emoji }}
                            </button>
                            <div v-if="user" class="flex flex-col gap-1">
                                <Link
                                    :href="route('notifications.index')"
                                    class="menu-item"
                                >
                                    <div
                                        class="text-gray-500 relative pr-2 py-2 text-lg text-center"
                                    >
                                        🔔
                                        <div
                                            v-if="notifications_count > 0"
                                            class="absolute right-14 top-2 w-5 h-5 bg-red-700 dark:bg-red-400 text-white font-medium border border-white dark:border-gray-900 rounded-full text-xs text-center"
                                        >
                                            {{ notifications_count }}
                                        </div>
                                    </div>
                                </Link>
                                <Link
                                    :href="route('realtor.listeing.index')"
                                    class="menu-item text-center"
                                    ><div class="text-sm text-gray-500">
                                        {{ user.name }}
                                    </div>
                                </Link>
                                <Link
                                    :href="route('listeing.create')"
                                    class="menu-item text-center"
                                    >{{ $t("create") }} +</Link
                                >
                                <Link
                                    class="menu-item text-center"
                                    :href="route('logout')"
                                    method="delete"
                                    as="button"
                                    >{{ $t("logout") }}</Link
                                >
                            </div>
                            <div v-else class="flex items-center gap-4">
                                <Link
                                    :href="route('login')"
                                    class="menu-item text-center"
                                    >{{ $t("login_register") }}</Link
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
import { computed, onMounted, ref, onBeforeMount, watch } from "vue";
import Pusher from "pusher-js";
const page = usePage();
const user = computed(() => page.props.user);

const isDark = ref(false);

const notifications_count = ref(Math.min(page.props.notifications_count, 9));
watch(
    () => page.props.notifications_count,
    (newCount, oldCount) => {
        return (notifications_count.value = newCount);
    }
);
onMounted(() => {
    if (localStorage.getItem("isDark") === "true") {
        isDark.value = true;
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
        isDark.value = false;
    }

    // Initialize Pusher
    const pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
        cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
        encrypted: true,
    });

    // Subscribe to the channel and event you want to listen to
    const channel = pusher.subscribe(`user.${user.value.id}`); // Use a unique channel for each user

    channel.bind("NewOffer", (data) => {
        notifications_count.value++; // Increment notification count or handle it according to your logic
    });
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
