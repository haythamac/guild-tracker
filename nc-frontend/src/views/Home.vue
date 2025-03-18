<script setup>
import { ref, inject } from 'vue';
import Input from '../components/Input.vue';
import Submit from '../components/Submit.vue';
import Dropdown from '../components/Dropdown.vue';
import Navbar from '../components/Navbar.vue';
import SuccessModal from '../components/modals/SuccessModal.vue';
import { useToast } from '../composables/useToast';

const API_BASE_URL = inject('API_BASE_URL'); // Inject the global API base URL
const toast = useToast();

const ign = ref('');
const userClass = ref('');
const userLevel = ref('');
const userPower = ref('');
const discord = ref('');

const showModal = ref(false);
const submittedData = ref({});

const showSuccessToast = () => {
    toast.success('Submit successfully!', {
        duration: 5000,
        position: 'bottom-right'
    });
};

const showFailToast = () => {
    toast.fail('Submit failed. Please try again.', {
        duration: 5000,
        position: 'bottom-right'
    });
};

let classes = ['General', 'Impaler', 'Knight', 'Slayer', 'Sniper', 'Assassin', 'Chaser', 'Mage', 'Cleric'];

async function submitForm() {
    const formData = {
        ign: ign.value,
        class: userClass.value,
        level: userLevel.value,
        power: userPower.value,
        discord: discord.value
    };

    try {
        const response = await fetch(`${API_BASE_URL}/api/players`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        showSuccessToast();
        submittedData.value = data;
        showModal.value = true;
        console.log(submittedData.value);
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
        showFailToast();
    }
}
</script>

<template>
    <Navbar />
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header with themed background -->
            <div class="bg-indigo-600 p-6 text-white">
                <h2 class="text-2xl font-bold text-center">Guild Application</h2>
                <p class="text-center text-indigo-200 mt-1">Join Paragon Guild</p>
            </div>

            <!-- Form content -->
            <div class="p-6">
                <form @submit.prevent="submitForm" class="space-y-6">
                    <Input label="In-game name" v-model="ign" placeholder="Your character name" />

                    <Dropdown label="Class" v-model="userClass" :options="classes" />

                    <div class="grid grid-cols-2 gap-4">
                        <Input label="Level" v-model="userLevel" type="number" min="1" />
                        <Input label="Power" v-model="userPower" type="number" />
                    </div>

                    <Input label="Discord Username" v-model="discord" placeholder="username#0000" />

                    <div class="pt-4">
                        <Submit @click="submitForm" />
                    </div>

                    <p class="text-xs text-center text-gray-500 mt-4">
                        By submitting this application, you agree to follow our guild rules and guidelines.
                    </p>
                </form>
            </div>
        </div>
    </div>
    <SuccessModal v-if="showModal" :formData="submittedData" @close="showModal = false"
        instructions="Please save the member access code. It is necessary when updating your player information next time" />
</template>

<style scoped></style>