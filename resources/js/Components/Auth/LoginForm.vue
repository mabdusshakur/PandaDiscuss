<script setup>
import { ref, defineEmits } from 'vue';

// Define the emit function
const emit = defineEmits({
    toggleForm: null,
});

// Function to fire the toggleForm event
const showVerifyForm = () => {
    emit('toggleForm');
};


// inputs
const email = ref('');


// Function to sign in
const signIn = () => {
    if (email.value === '') {
        alert('Please enter your email');
        return;
    }

    axios.post('/login', {
        email: email.value,
    }).then((response) => {
        if (response.data.success == true) {
            sessionStorage.setItem('email', email.value);
            showVerifyForm();
        }
    }).catch((error) => {
        console.log(error);
    });
};

</script>
<template>
    <div class="space-y-5">
        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email"
                class="block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-pink-400 focus:ring-pink-200 focus:ring-opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500"
                placeholder="panda@email.com" v-model="email" />
        </div>
        <button type="button" v-on:click="signIn"
            class="rounded-lg border border-pink-500 bg-pink-500 px-3 py-1.5 text-center text-sm font-medium text-white shadow-sm transition-all hover:border-pink-600 hover:bg-pink-600 focus:ring focus:ring-pink-200 disabled:cursor-not-allowed disabled:border-pink-300 disabled:bg-pink-300">Sign-In</button>
    </div>
</template>
<style scoped></style>