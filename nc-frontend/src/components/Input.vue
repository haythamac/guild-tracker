<script setup>
// This would be in a separate Input.vue file
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
  label: String,
  modelValue: [String, Number],
  placeholder: {
    type: String,
    default: ''
  },
  type: {
    type: String,
    default: 'text'
  },
  min: {
    type: [String, Number],
    default: null
  }
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
  <div class="relative">
    <label :for="label" class="text-sm font-medium text-gray-700">{{ label }}</label>
    <input 
      :type="type"
      :id="label"
      class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-all"
      :placeholder="placeholder"
      :value="modelValue"
      :min="min"
      @input="$emit('update:modelValue', $event.target.value)"
    />
  </div>
</template>

<style scoped>
input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

input[type="number"] {
  -moz-appearance: textfield;
}
</style>