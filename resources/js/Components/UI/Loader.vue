<template>
    <div class="loader dark:bg-gray-900 bg-white" v-if="isLoading">
        <div class="one"></div>
        <div class="two"></div>
        <div class="three"></div>
    </div>
</template>

<script setup>
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
<style scoped>
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.loader {
    position: absolute;
    height: 100%;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    width: 100%;
}

.loader div {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: gold;
    margin: 0 10px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    -o-border-radius: 50%;
    animation-name: up-down;
    animation-iteration-count: infinite;
    animation-duration: 1s;
    animation-direction: alternate;
}

.two {
    animation-delay: 0.3s;
}

.three {
    animation-delay: 0.6s;
}

@keyframes up-down {
    to {
        opacity: 0.5;
        transform: translateY(-20px);
        -webkit-transform: translateY(-20px);
        -moz-transform: translateY(-20px);
        -ms-transform: translateY(-20px);
        -o-transform: translateY(-20px);
    }
}
</style>
