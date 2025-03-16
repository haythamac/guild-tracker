<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    label: String,
    modelValue: [String, Number]
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <label :for="label"
        class="relative block my-8 p-4 rounded-md border border-gray-300 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600">
        <input :type="typeof props.modelValue === 'number' ? 'number' : 'text'" :id="label"
        class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:ring-0 focus:outline-none no-spinner"
        :placeholder="label" :value="props.modelValue" @input="$emit('update:modelValue', $event.target.value)" />

        <span
        class="pointer-events-none absolute left-2.5 top-0 -translate-y-1/2 bg-white px-1 text-xs text-gray-700 transition-all peer-placeholder-shown:top-1/2 peer-placeholder-shown:text-sm peer-focus:top-0 peer-focus:text-xs">
        {{ label }}
        </span>
    </label>
</template>

<style scoped>
label {
    background-color: #f9fafb;
}

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type="number"] {
    -moz-appearance: textfield;
}
</style>
