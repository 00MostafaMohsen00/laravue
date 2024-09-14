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
                    @drop="addFiles"
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
            <div class="grid grid-cols-3 gap-4" v-if="previews">
                <Box
                    v-for="(preview, index) in previews"
                    :key="index"
                    class="flex flex-col"
                >
                    <Image :src="preview" class="h-32 max-w-md" />
                    <button
                        class="btn-outline m-2"
                        @click.prevent="remove(index)"
                    >
                        {{ $t("delete") }}
                    </button>
                </Box>
            </div>
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
                <DeleteButton :url="route('images.destroy', image.id)" />
            </div>
        </section>
    </box>
</template>

<script setup>
import Box from "@/Components/UI/Box.vue";
import { useForm } from "@inertiajs/vue3";
import Error from "@/Components/UI/Error.vue";
import Image from "@/Components/UI/Image.vue";
import DeleteButton from "@/Components/UI/DeleteButton.vue";
import { computed, ref } from "vue";
import { router } from "@inertiajs/vue3";
import NProgress from "nprogress";
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

const previews = ref([]);

const submit = () => {
    form.post(route("images.store", props.listeing.id), {
        onSuccess: () => {
            form.reset("images");
            previews.value = [];
        },
    });
};

const addFiles = (event) => {
    const files = event.target.files;
    for (const image of files) {
        form.images.push(image);
        const reader = new FileReader();
        reader.onload = (e) => {
            previews.value.push(e.target.result); // Add preview URL
        };
        reader.readAsDataURL(image); // Convert file to data URL
    }
};

const reset = () => {
    form.reset("images");
    previews.value = [];
};

const formErrors = computed(() => {
    return Object.values(form.errors);
});

const remove = (index) => {
    form.images.splice(index, 1);
    previews.value.splice(index, 1);
};
</script>
