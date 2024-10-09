<script setup>
import LoginForm from '../../Components/Auth/LoginForm.vue';


import { ref } from 'vue';
import VerifyForm from '../../Components/Auth/VerifyForm.vue';
const showLoginForm = ref(true);
const showVerifyForm = ref(false);

const toggleForm = () => {
    showLoginForm.value = !showLoginForm.value;
    showVerifyForm.value = !showVerifyForm.value;
};

</script>
<template>
    <div class="flex flex-col justify-center items-center h-screen bg-gradient bg-gradient-to-t from-white to-pink-100">
        <div class="p-2 shadow-lg rounded-lg">
            <div class="max-w-xl">
                <LoginForm v-if="showLoginForm" @toggleForm="toggleForm" />
                <VerifyForm v-else />
            </div>
        </div>
    </div>
</template>
<style scoped></style>