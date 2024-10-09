<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3';

// inputs
const otp = ref(0);


// Function to verify
const verify = () => {
    if (otp.value === '') {
        alert('Please enter the OTP');
        return;
    }

    axios.post('/verify', {
        otp: otp.value,
        email: sessionStorage.getItem('email'),
    }).then((response) => {
        if (response.data.success == true) {
            sessionStorage.removeItem('email');
            localStorage.setItem('token', response.data[0].token);
            router.visit('/dashboard');
        }
    }).catch((error) => {
        console.log(error);
    });
}

</script>
<template>
    <form action="" class="space-y-5">
        <div>
            <label for="otp" class="mb-1 block text-sm font-medium text-gray-700">OTP</label>
            <input type="text" id="otp"
                class="block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-pink-400 focus:ring-pink-200 focus:ring-opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500"
                placeholder="6969" v-model="otp" />
        </div>
        <button type="button" v-on:click="verify"
            class="rounded-lg border border-pink-500 bg-pink-500 px-3 py-1.5 text-center text-sm font-medium text-white shadow-sm transition-all hover:border-pink-600 hover:bg-pink-600 focus:ring focus:ring-pink-200 disabled:cursor-not-allowed disabled:border-pink-300 disabled:bg-pink-300">Verify</button>
    </form>
</template>
<style scoped></style>