<template>
    <div class="grid grid-cols-6 gap-4">
        <div class="col-span-2">
            <label class="label">{{ $t("beds") }}</label>
            <input type="number" v-model.number="form.beds" class="input" />
            <error v-if="form.errors.beds" :error="form.errors.beds" />
        </div>
        <div class="col-span-2">
            <label class="label">{{ $t("baths") }}</label>
            <input type="number" v-model.number="form.baths" class="input" />
            <error
                v-if="form.errors.baths"
                class="error"
                :error="form.errors.baths"
            />
        </div>
        <div class="col-span-2">
            <label class="label">{{ $t("area") }}</label>
            <input type="number" v-model="form.area" required class="input" />
            <error
                v-if="form.errors.area"
                class="error"
                :error="form.errors.area"
            />
        </div>
        <div class="col-span-4">
            <label class="label">{{ $t("city") }}</label>
            <input type="text" v-model="form.city" class="input" />
            <error v-if="form.errors.city" :error="form.errors.city" />
        </div>

        <div class="col-span-2">
            <label class="label">{{ $t("code") }}</label>
            <input type="text" v-model="form.code" required class="input" />
            <error v-if="form.errors.code" :error="form.errors.code" />
        </div>
        <div class="col-span-4">
            <label class="label">{{ $t("street") }}</label>
            <input type="text" v-model="form.street" required class="input" />
            <error v-if="form.errors.street" :error="form.errors.street" />
        </div>
        <div class="col-span-2">
            <label class="label">{{ $t("street_nr") }}</label>
            <input
                type="number"
                v-model="form.street_nr"
                required
                class="input"
            />
            <error
                v-if="form.errors.street_nr"
                :error="form.errors.street_nr"
            />
        </div>
        <div class="col-span-6">
            <label class="label">{{ $t("price") }}</label>
            <input
                type="number"
                v-model.number="form.price"
                required
                class="input"
            />
            <error v-if="form.errors.price" :error="form.errors.price" />
        </div>
        <div class="col-span-6">
            <input type="submit" :value="$t('save')" class="btn" />
        </div>
    </div>
</template>

<script setup>
import Error from "@/Components/UI/Error.vue";
defineProps({
    form: Object,
});
</script>
