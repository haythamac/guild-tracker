<script setup>
import { ref, onMounted } from 'vue';
import LoginForm from '../components/LoginForm.vue';

const players = ref([]);


</script>

<template>
    <div class="mt-8">
        <LoginForm />
    </div>
</template>

<style scoped></style>
