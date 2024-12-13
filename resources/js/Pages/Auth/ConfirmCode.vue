<template>
    <form @submit.prevent="save">
        <div class="w-1/2 mx-auto items-center justify-center mt-8">
            <div>
                <div
                    class="flex flex-nowrap items-center justify-center gap-2 w-full"
                >
                    <input
                        v-for="(otpField, index) in otpFields"
                        :key="index"
                        type="tel"
                        maxlength="1"
                        inputmode="numeric"
                        autocomplete="off"
                        class="input w-1/4 md:w-1/12 text-center"
                        :ref="(el) => (inputRefs[index] = el)"
                        v-model="otpFields[index]"
                        @input="handleInput(index, $event)"
                        @keydown.backspace="handleBackspace(index, $event)"
                        @paste="handlePaste($event)"
                    />
                </div>
                <error v-if="form.errors.otp" :error="form.errors.otp" />
            </div>
            <div class="mt-4 flex flex-col">
                <input type="submit" :value="$t('send')" class="btn w-full" />
            </div>
        </div>
    </form>
</template>

<script setup>
import { ref } from "vue";
import Error from "@/Components/UI/Error.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    otp: null,
});

const otpFields = ref(["", "", "", ""]);
const inputRefs = [];

const handleInput = (index, event) => {
    const value = event.target.value;

    otpFields.value[index] = value;

    if (value && index < otpFields.value.length - 1) {
        inputRefs[index + 1]?.focus();
    }

    form.otp = otpFields.value.join("");
};

const handleBackspace = (index, event) => {
    if (event.key === "Backspace" && !otpFields.value[index] && index > 0) {
        inputRefs[index - 1]?.focus();
    }
};

const handlePaste = (event) => {
    event.preventDefault();
    const pasteData = event.clipboardData.getData("text");
    const pasteArray = pasteData.split("");

    pasteArray.forEach((char, index) => {
        if (index < otpFields.value.length) {
            otpFields.value[index] = char;
        }
    });

    form.otp = otpFields.value.join("");

    const filledIndex = Math.min(pasteArray.length, otpFields.value.length - 1);
    inputRefs[filledIndex]?.focus();
};

const save = () => {
    console.log("OTP Submitted:", form.otp);
    form.post(route("otp.save"));
};
</script>
