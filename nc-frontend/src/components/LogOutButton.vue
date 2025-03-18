<template>
  <button @click="logout" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
    Logout
  </button>
</template>

<script setup>
import { inject } from 'vue';
const API_BASE_URL = inject('API_BASE_URL');
const logout = async () => {
  try {
    const response = await fetch(`${API_BASE_URL}/api/logout`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      }
    });

    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
  } catch (error) {
    console.error('Error logging out:', error);
  } finally {
    localStorage.removeItem('token');
    window.location.reload();
  }
};
</script>

<style scoped>
button {
  background-color: transparent;
  border: none;
  cursor: pointer;
}
</style>
