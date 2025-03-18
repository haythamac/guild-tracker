<script setup>
// This would be in a separate Dropdown.vue file
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  label: String,
  modelValue: [String, Number],
  options: Array
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
  <div class="relative">
    <label :for="label" class="text-sm font-medium text-gray-700">{{ label }}</label>
    <select
      :id="label"
      class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md transition-all bg-white"
      :value="modelValue"
      @change="$emit('update:modelValue', $event.target.value)"
    >
      <option v-for="option in options" :key="option" :value="option">{{ option }}</option>
    </select>
    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none" style="top: 24px">
      <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
      </svg>
    </div>
  </div>
</template>