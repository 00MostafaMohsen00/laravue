<template>
    <box>
        <template #title> {{ $t("upload_your_images") }} </template>
        <form @submit.prevent="submit">
            <section class="flex items-center gap-2 my-4">
                <input
                    type="file"
                    class="border rounded-md file:px-4 file:py-2 border-gray-200 dark:border-gray-700 file:text-gray-700 file:dark:text-gray-400 file:border-0 file:bg-gray-100 dark:file:bg-gray-800 file:font-medium file:hover:bg-gray-200 dark:file:hover:bg-gray-700 file:hover:cursor-pointer file:mr-4"
                    multiple
                    @input="addFiles"
                />
                <button
                    type="submit"
                    class="btn-outline disabled:opacity-25 disabled:cursor-not-allowed"
                    :disabled="!canUpload"
                >
                    {{ $t("upload") }}
                </button>
                <button type="reset" class="btn-outline" @click="reset">
                    {{ $t("reset") }}
                </button>
                <div class="flex flex-col">
                    <error
                        v-for="(error, index) in formErrors"
                        :error="error"
                        :key="index"
                    />
                </div>
            </section>
        </form>
    </box>
    <box v-if="listeing.images.length">
        <template #title> {{ $t("uploaded_images") }} </template>
        <section class="mt-4 grid grid-cols-3 gap-4">
            <div
                v-for="image in listeing.images"
                :key="image.id"
                class="flex flex-col justify-between"
            >
                <Image :src="image.image_url" />
                <Link
                    :href="route('images.destroy', image.id)"
                    method="delete"
                    as="button"
                    class="btn-outline w-full mt-2 text-sm"
                    >{{ $t("delete") }}</Link
                >
            </div>
        </section>
    </box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import { useForm } from "@inertiajs/vue3";
import Error from "@/Components/UI/Error.vue";
import Image from "@/Components/UI/Image.vue";
import { computed } from "vue";
import { router } from "@inertiajs/vue3";
import NProgress from "nprogress";
import { Link } from "@inertiajs/vue3";
router.on("progress", (event) => {
    if (event.detail.progress.percentage) {
        NProgress.set((event.detail.progress.percentage / 100) * 0.9);
    }
});
const props = defineProps({
    listeing: Object,
});
const canUpload = computed(() => form.images.length);
const form = useForm({
    images: [],
});

const submit = () => {
    form.post(route("images.store", props.listeing.id), {
        onSuccess: () => form.reset("images"),
    });
};

const addFiles = (event) => {
    const files = event.target.files;
    for (const image of files) {
        form.images.push(image);
    }
};

const reset = () => {
    form.reset("images");
};

const formErrors = computed(() => {
    return Object.values(form.errors);
});
</script>
