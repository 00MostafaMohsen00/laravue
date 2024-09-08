<template>
    <Header />
    <main class="container mx-auto p-4 w-full min-h-screen">
        <Message />
        <Loader />
        <slot></slot>
    </main>
    <Footer />
    <!-- Print the success message -->
</template>

<script setup>
import Loader from "@/Components/UI/Loader.vue";
import Header from "@/Components/UI/Header.vue";
import Message from "@/Components/UI/Message.vue";
import Footer from "@/Components/UI/Footer.vue";
</script>
