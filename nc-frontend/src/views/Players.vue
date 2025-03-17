<script setup>
import { ref, onMounted } from 'vue';
import PlayerTable from '../components/PlayerTable.vue';

const players = ref([]);

async function getPlayers() {
    try {
        const response = await fetch('http://nc-backend.test/api/players');

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
    <div class="mt-8">
        <PlayerTable :players="players" @playerDeleted="handlePlayerDeleted" /> <!-- Pass players data to PlayerTable and handle playerDeleted event -->
    </div>
</template>

<style scoped></style>
