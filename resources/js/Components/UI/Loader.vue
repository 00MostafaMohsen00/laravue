<template>
    <transition>
        <div class="loader dark:bg-gray-900 bg-white min-w-screen min-h-screen">
            <Vue3Lottie
                :animationData="animationData"
                :height="200"
                :width="200"
            />
        </div>
    </transition>
</template>

<script setup>
import { Vue3Lottie } from "vue3-lottie";

import animationData from "@/assets/animation.json";
</script>
<style scoped>
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.loader {
    position: relative;
    height: 100vh;
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    width: 100%;
}
</style>
