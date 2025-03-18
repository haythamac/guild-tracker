<script setup>
import { ref, inject } from 'vue';
import LoginForm from '../components/LoginForm.vue';
import { useToast } from '../composables/useToast';

const players = ref([]);

const API_BASE_URL = inject('API_BASE_URL');
const toast = useToast();

const showSuccessToast = () => {
  toast.success('Operation completed successfully!', {
    duration: 3000,
    position: 'top-right'
  });
};

const showFailToast = () => {
  toast.fail('Operation failed. Please try again.', {
    duration: 3000,
    position: 'top-right'
  });
};
</script>

<template>
    <div class="mt-8">
        <LoginForm @click="showSuccessToast"/>
        <button @click="showSuccessToast" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-lg">Test CORS</button>
        
    </div>
</template>

<style scoped></style>