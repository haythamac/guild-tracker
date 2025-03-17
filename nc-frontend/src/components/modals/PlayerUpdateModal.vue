<script setup>
import { ref, reactive, watch, onMounted } from 'vue';

const props = defineProps({
    player: {
        type: Object,
        required: true
    },
    showModal: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['close', 'updatePlayer']);

// Create a local copy of player data to prevent direct mutation of props
const formData = reactive({});
const formErrors = reactive({});
const isLoading = ref(false);

// Reset form data when modal opens or player changes
watch(() => props.player, updateFormData, { immediate: true });
watch(() => props.showModal, (newVal) => {
    if (newVal) updateFormData();
});

function updateFormData() {
    // Deep copy the player object to avoid mutation
    Object.assign(formData, JSON.parse(JSON.stringify(props.player || {})));
    // Clear any previous errors
    Object.keys(formErrors).forEach(key => delete formErrors[key]);
}

function validateForm() {
    let isValid = true;

    // Clear previous errors
    Object.keys(formErrors).forEach(key => delete formErrors[key]);

    // Required fields validation
    if (!formData.guild?.trim()) {
        formErrors.guild = 'Guild is required';
        isValid = false;
    }

    if (!formData.ign?.trim()) {
        formErrors.ign = 'In-Game Name is required';
        isValid = false;
    }

    // Number validation
    if (formData.level && isNaN(Number(formData.level))) {
        formErrors.level = 'Level must be a number';
        isValid = false;
    }

    if (formData.power && isNaN(Number(formData.power))) {
        formErrors.power = 'Growth Rate must be a number';
        isValid = false;
    }

    return isValid;
}

function closeModal() {
    emit('close');
}

async function updatePlayer() {
    if (!validateForm()) return;

    try {
        isLoading.value = true;
        const response = await fetch(`http://nc-backend.test/api/players/${formData.id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const updatedPlayer = await response.json();
        emit('updatePlayer', updatedPlayer);
        closeModal();
    } catch (error) {
        console.error('Error updating player:', error);
    } finally {
        isLoading.value = false;
    }
}

// Handle escape key to close modal
function handleKeyDown(e) {
    if (e.key === 'Escape') closeModal();
}

onMounted(() => {
    document.addEventListener('keydown', handleKeyDown);
    return () => {
        document.removeEventListener('keydown', handleKeyDown);
    };
});

// Focus first input when modal opens
const firstInput = ref(null);
watch(() => props.showModal, (newVal) => {
    if (newVal) {
        setTimeout(() => firstInput.value?.focus(), 50);
    }
});
</script>

<template>
    <div v-if="showModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black opacity-60 transition-opacity" @click="closeModal"></div>

        <!-- Modal -->
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div
                class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <!-- Header -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 border-b flex justify-between items-center">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Update Player Information
                    </h3>
                    <button type="button"
                        class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        @click="closeModal">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form Body -->
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <form @submit.prevent="updatePlayer" class="space-y-4">
                        <!-- Player ID (Disabled) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Player ID</label>
                            <input v-model="formData.id" type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-100 focus:outline-none"
                                disabled />
                        </div>

                        <!-- Guild -->
                        <div>
                            <label for="guild" class="block text-sm font-medium text-gray-700 mb-1">Guild</label>
                            <input id="guild" ref="firstInput" v-model="formData.guild" type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                :class="{ 'border-red-500': formErrors.guild }" />
                            <p v-if="formErrors.guild" class="mt-1 text-sm text-red-600">{{ formErrors.guild }}</p>
                        </div>

                        <!-- Status Dropdown -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="status" v-model="formData.status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <option value="active">Active</option>
                                <option value="unverified">Unverified</option>
                                <option value="removed">Removed</option>
                            </select>
                        </div>

                        <!-- In-Game Name -->
                        <div>
                            <label for="ign" class="block text-sm font-medium text-gray-700 mb-1">In-Game Name</label>
                            <input id="ign" v-model="formData.ign" type="text"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                :class="{ 'border-red-500': formErrors.ign }" />
                            <p v-if="formErrors.ign" class="mt-1 text-sm text-red-600">{{ formErrors.ign }}</p>
                        </div>

                        <!-- Level -->
                        <div>
                            <label for="level" class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                            <input id="level" v-model="formData.level" type="number" min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                :class="{ 'border-red-500': formErrors.level }" />
                            <p v-if="formErrors.level" class="mt-1 text-sm text-red-600">{{ formErrors.level }}</p>
                        </div>

                        <!-- Growth Rate -->
                        <div>
                            <label for="power" class="block text-sm font-medium text-gray-700 mb-1">Growth Rate</label>
                            <input id="power" v-model="formData.power" type="number" step="0.01"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                :class="{ 'border-red-500': formErrors.power }" />
                            <p v-if="formErrors.power" class="mt-1 text-sm text-red-600">{{ formErrors.power }}</p>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="button"
                        class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50"
                        @click="updatePlayer" :disabled="isLoading">
                        <svg v-if="isLoading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        {{ isLoading ? 'Updating...' : 'Update Player' }}
                    </button>
                    <button type="button"
                        class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm"
                        @click="closeModal">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}
</style>