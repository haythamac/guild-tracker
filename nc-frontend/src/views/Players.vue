<script setup>
import { ref, onMounted, inject } from 'vue';
import PlayerTable from '../components/PlayerTable.vue';
import Navbar from '../components/Navbar.vue';

const API_BASE_URL = inject('API_BASE_URL'); // Inject the global API base URL

const players = ref([]);

async function getPlayers() {
    try {
        const response = await fetch(`${API_BASE_URL}/api/players`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        }); // Use the injected API base URL

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        players.value = data; // Store the players' data
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
    }
}

function handlePlayerDeleted(playerId) {
    players.value = players.value.filter(player => player.id !== playerId);
}

onMounted(() => {
    getPlayers();
});
</script>

<template>
    <Navbar />  
    <div class="mt-8">
        <PlayerTable :players="players" @playerDeleted="handlePlayerDeleted" /> <!-- Pass players data to PlayerTable and handle playerDeleted event -->
    </div>
</template>

<style scoped></style>
