<template>
    <button class="btn-outline w-full mt-2 text-sm" @click="deleteImage">
        <i class="fas fa-trash-alt icon"></i>
    </button>
</template>
<script setup>
import Swal from "sweetalert2";
import { useI18n } from "vue-i18n";
import { router } from "@inertiajs/vue3";
const props = defineProps({
    url: String,
});

const { t } = useI18n();
const deleteImage = () => {
    Swal.fire({
        title: t("are_you_sure"),
        text: t("you_will_not_be_able_to_revert_this"),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: t("yes_delete_it"),
        cancelButtonText: t("cancel"),
        customClass: {
            popup: "bg-white dark:bg-gray-800", // Tailwind classes
            title: "text-lg font-semibold",
            content: "text-gray-700 dark:text-gray-300",
            confirmButton:
                "bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded",
            cancelButton:
                "bg-gray-300 hover:bg-gray-400 text-black font-bold py-2 px-4 rounded ml-2",
        },
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(props.url);
        }
    });
};
</script>
