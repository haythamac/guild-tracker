<template>
    <nav class="bg-gray-800 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <div class="text-white text-lg font-bold">
                    Paragon Guild Tracker
                </div>
            </div>
            <div>
                <router-link to="/" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Home</router-link>
                <a href="#" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Guilds</a>
                <router-link to="/players" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Players</router-link>
                <a href="#" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">About</a>
                <a href="#" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Contact</a>
            </div>
        </div>
    </nav>
</template>

<style scoped>
nav {
    background-color: #2d3748;
}
</style>