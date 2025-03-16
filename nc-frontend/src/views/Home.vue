<script setup>
import { ref } from 'vue';
import Input from '../components/Input.vue';
import Submit from '../components/Submit.vue';

const ign = ref('');
const userClass = ref('');

async function submitForm() {
    const formData = {
        ign: ign.value,
        class: userClass.value,
        level: userLevel.value,
        power: userPower.value
    };

    try {
        const response = await fetch('http://nc-backend.test/api/players', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        alert('Form submitted successfully!');
        console.log(data);
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
        alert('Form submission failed!');
    }
}
</script>

<template>
    <div class="flex items-center justify-center min-h-screen">
        <div class="grid place-items-center border-2 border-gray-200 rounded-md shadow-md p-8">
            <header>Apply to guild</header>
            <Input label="In-game name" v-model="ign" />
            <Input label="Class" v-model="userClass" />
            <Input label="Level" v-model="userLevel" />
            <Input label="Growth rate" v-model="userPower" />

            <Submit @click="submitForm" />
        </div>
    </div>
</template>

<style scoped></style>
