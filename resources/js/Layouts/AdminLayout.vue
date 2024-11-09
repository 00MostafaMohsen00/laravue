<template>
    <Header />
    <div class="flex flex-row">
        <Side class="min-w-60" v-if="user" />
        <main class="container mx-auto p-4 min-h-screen min-w-80">
            <Message />
            <Loader v-show="isLoading" />
            <div v-show="!isLoading">
                <slot></slot>
            </div>
        </main>
    </div>
    <Footer />
    <!-- Print the success message -->
</template>

<script setup>
import Loader from "@/Components/UI/Loader.vue";
import Header from "@/Components/UI/Admin/Header.vue";
import Message from "@/Components/UI/Message.vue";
import Footer from "@/Components/UI/Footer.vue";
import Side from "@/Components/UI/Admin/Side.vue";
import { usePage } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { useStore } from "vuex";
import { mapGetters } from "vuex";

const store = useStore();

const page = usePage();
const user = computed(() => page.props.user);
const isSearchActive = computed(() => store.getters.isSearchActive);
const isLoading = ref(false);

const startLoading = () => {
    if (!isSearchActive.value) isLoading.value = true;
};
const stopLoading = () => {
    isLoading.value = false;
};

onMounted(() => {
    router.on("start", startLoading);
    router.on("finish", stopLoading);
    router.on("progress", stopLoading);
});

onUnmounted(() => {
    router.off("start", startLoading);
    router.off("finish", stopLoading);
    router.off("progress", stopLoading);
});
</script>
