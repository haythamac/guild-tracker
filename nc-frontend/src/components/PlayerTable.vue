<script setup>
import { defineProps, defineEmits, ref } from 'vue';
import PlayerUpdateModal from './modals/PlayerUpdateModal.vue';

const props = defineProps({
    players: Array
});

const emit = defineEmits(['playerDeleted']);

const showModal = ref(false);
const selectedPlayer = ref(null);

function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function openUpdateModal(player) {
    selectedPlayer.value = { ...player };
    showModal.value = true;
}

function closeUpdateModal() {
    showModal.value = false;
}

function updatePlayer(updatedPlayer) {
    const index = props.players.findIndex(player => player.id === updatedPlayer.id);
    if (index !== -1) {
        props.players[index] = updatedPlayer;
    }
    showModal.value = false;
}

async function deletePlayer(playerId) {
    try {
        const response = await fetch(`http://nc-backend.test/api/players/${playerId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        alert('Player deleted successfully!');
        emit('playerDeleted', playerId); // Emit event with playerId
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
        alert('Player deletion failed!');
    }
}
</script>

<template>
    <div>
        <section class="container px-4 mx-auto">
            <div class="flex flex-col">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden border border-gray-200 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500">
                                            <div class="flex items-center gap-x-3">
                                                <input type="checkbox"
                                                    class="text-blue-500 border-gray-300 rounded">
                                                <button class="flex items-center gap-x-2">
                                                    <span>Player ID</span>

                                                    <svg class="h-3" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z"
                                                            fill="currentColor" stroke="currentColor"
                                                            stroke-width="0.1" />
                                                        <path
                                                            d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z"
                                                            fill="currentColor" stroke="currentColor"
                                                            stroke-width="0.1" />
                                                        <path
                                                            d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z"
                                                            fill="currentColor" stroke="currentColor"
                                                            stroke-width="0.3" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </th>

                                        <th scope="col"
                                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                            Guild
                                            
                                        </th>

                                        <th scope="col"
                                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                            <div class="flex items-center gap-x-3">
                                                <button class="flex items-center gap-x-2">
                                                    <span>Status</span>

                                                    <svg class="h-3" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z"
                                                            fill="currentColor" stroke="currentColor"
                                                            stroke-width="0.1" />
                                                        <path
                                                            d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z"
                                                            fill="currentColor" stroke="currentColor"
                                                            stroke-width="0.1" />
                                                        <path
                                                            d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z"
                                                            fill="currentColor" stroke="currentColor"
                                                            stroke-width="0.3" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </th>

                                        <th scope="col"
                                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                            In-Game Name
                                        </th>

                                        <th scope="col"
                                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                            <div class="flex items-center gap-x-3">
                                                <button class="flex items-center gap-x-2">
                                                    <span>Level</span>

                                                    <svg class="h-3" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z"
                                                            fill="currentColor" stroke="currentColor"
                                                            stroke-width="0.1" />
                                                        <path
                                                            d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z"
                                                            fill="currentColor" stroke="currentColor"
                                                            stroke-width="0.1" />
                                                        <path
                                                            d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z"
                                                            fill="currentColor" stroke="currentColor"
                                                            stroke-width="0.3" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </th>

                                        <th scope="col"
                                            class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                            <div class="flex items-center gap-x-3">
                                                <button class="flex items-center gap-x-2">
                                                    <span>Growth Rate</span>

                                                    <svg class="h-3" viewBox="0 0 10 11" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z"
                                                            fill="currentColor" stroke="currentColor"
                                                            stroke-width="0.1" />
                                                        <path
                                                            d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z"
                                                            fill="currentColor" stroke="currentColor"
                                                            stroke-width="0.1" />
                                                        <path
                                                            d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z"
                                                            fill="currentColor" stroke="currentColor"
                                                            stroke-width="0.3" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </th>

                                        <th scope="col" class="relative py-3.5 px-4">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="player in players" :key="player.id">
                                        <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                            <div class="inline-flex items-center gap-x-3">
                                                <input type="checkbox" class="text-blue-500 border-gray-300 rounded">
                                                <span>{{ player.id }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ player.guild }}
                                        </td>
                                        <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                            <div :class="{
                                                'inline-flex items-center px-3 py-1 rounded-full gap-x-2 text-emerald-500 bg-emerald-100/60': player.status === 'active',
                                                'inline-flex items-center px-3 py-1 rounded-full gap-x-2 text-red-500 bg-red-100/60': player.status === 'removed',
                                                'inline-flex items-center px-3 py-1 rounded-full gap-x-2 text-gray-500 bg-gray-100/60': player.status === 'unverified'
                                            }">
                                                <svg v-if="player.status === 'active'" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10 3L4.5 8.5L2 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <svg v-else-if="player.status === 'unverified'" width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z" fill="currentColor"/>
                                                </svg>
                                                <svg v-else-if="player.status === 'removed'" width="12" height="12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <h2 class="text-sm font-normal">{{ capitalizeFirstLetter(player.status) }}</h2>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            <div class="flex items-center gap-x-2">
                                                <div>
                                                    <h2 class="text-sm font-medium text-gray-800">{{ player.ign }}</h2>
                                                    <p class="text-xs font-normal text-gray-600">{{ player.class }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ player.level }}
                                        </td>
                                        <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ player.power }}
                                        </td>
                                        <td class="px-4 py-4 text-sm whitespace-nowrap">
                                            <div class="flex items-center gap-x-6">
                                                <button 
                                                    @click.prevent="openUpdateModal(player)" 
                                                    class="text-gray-500 transition-colors duration-200 hover:text-indigo-500 focus:outline-none"
                                                    >
                                                    Update
                                                </button>
                                                <button @click="deletePlayer(player.id)" class="text-red-500 transition-colors duration-200 hover:text-indigo-500 focus:outline-none">
                                                    Remove
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-6">
                <a href="#"
                    class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
                    </svg>

                    <span>
                        previous
                    </span>
                </a>

                <div class="items-center hidden md:flex gap-x-3">
                    <a href="#" class="px-2 py-1 text-sm text-blue-500 rounded-md bg-blue-100/60">1</a>
                    <a href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md hover:bg-gray-100">2</a>
                    <a href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md hover:bg-gray-100">3</a>
                    <a href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md hover:bg-gray-100">...</a>
                    <a href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md hover:bg-gray-100">12</a>
                    <a href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md hover:bg-gray-100">13</a>
                    <a href="#"
                        class="px-2 py-1 text-sm text-gray-500 rounded-md hover:bg-gray-100">14</a>
                </div>

                <a href="#"
                    class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100">
                    <span>
                        Next
                    </span>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                </a>
            </div>
        </section>
        <PlayerUpdateModal
            :player="selectedPlayer"
            :showModal="showModal"
            @close="closeUpdateModal"
            @updatePlayer="updatePlayer"
        />
    </div>

</template>

<style scoped></style>