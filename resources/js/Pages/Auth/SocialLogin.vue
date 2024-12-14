<template>
    <Box>
        <div class="flex items-center flex-nowrap justify-center gap-4">
            <Link
                v-for="social in socials"
                :key="social.name"
                :href="route('social.login', social.name)"
            >
                <i
                    :class="social.icon + ' ' + social.color"
                    class="text-xl"
                ></i>
            </Link>
        </div>
    </Box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import { Link } from "@inertiajs/vue3";
const socials = [
    {
        name: "google",
        icon: "fab fa-google",
        color: "text-[#ea4335]",
    },
    {
        name: "facebook",
        icon: "fab fa-facebook",
        color: "text-[#3b5998]",
    },
];
</script>
