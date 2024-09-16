<template>
    <transition>
        <div class="loader dark:bg-gray-900 bg-white min-w-screen min-h-screen">
            <div class="one dark:bg-gray-500 bg-indigo-600"></div>
            <div class="two dark:bg-gray-500 bg-indigo-600"></div>
            <div class="three dark:bg-gray-500 bg-indigo-600"></div>
        </div>
    </transition>
</template>

<script setup></script>
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

.loader div {
    width: 20px;
    height: 20px;
    border-radius: 50%;
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
