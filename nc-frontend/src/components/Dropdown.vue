<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    label: String,
    modelValue: [String, Number],
    options: Array // Add options prop for dynamic choices
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <label :for="label"
        class="relative block my-8 p-4 w-full rounded-md border border-gray-300 shadow-sm focus-within:border-blue-600 focus-within:ring-1 focus-within:ring-blue-600">
        <select :id="label"
        class="peer w-full border-none bg-transparent placeholder-transparent focus:border-transparent focus:ring-0 focus:outline-none"
        :value="props.modelValue" @change="$emit('update:modelValue', $event.target.value)">
            <option v-for="option in props.options" :key="option" :value="option">{{ option }}</option>
        </select>

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

</style>
