<template>
    <Header />
    <main class="container mx-auto p-4 w-full">
        <Message />
        <Loader />
        <slot></slot>
    </main>
    <!-- Print the success message -->
</template>

<script setup>
import Loader from "@/Components/UI/Loader.vue";
import Header from "@/Components/UI/Header.vue";
import Message from "@/Components/UI/Message.vue";
</script>
