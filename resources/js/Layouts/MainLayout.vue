<template>
    <Header />
    <main class="container mx-auto p-4 w-full min-h-screen">
        <Message />
        <Loader v-show="isLoading" />
        <div v-show="!isLoading">
            <slot></slot>
        </div>
    </main>
    <Footer />
    <!-- Print the success message -->
</template>

<script setup>
import Loader from "@/Components/UI/Loader.vue";
import Header from "@/Components/UI/Header.vue";
import Message from "@/Components/UI/Message.vue";
import Footer from "@/Components/UI/Footer.vue";
import { ref, onMounted, onUnmounted } from "vue";
import { router } from "@inertiajs/vue3";

const isLoading = ref(false);

const startLoading = () => {
    isLoading.value = true;
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
