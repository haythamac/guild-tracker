<script setup>
// This would be in a separate Submit.vue file
import { defineEmits } from 'vue';

defineEmits(['click']);
</script>

<template>
  <button
    type="submit"
    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
    @click="$emit('click')"
  >
    Submit Application
  </button>
</template>