<script setup>
import { onMounted, ref } from 'vue';

// Inputs
const user = ref({
    name: '',
    email: ''
});

// Get the user data from localStorage
const getUser = () => {
    const user = localStorage.getItem('user');
    if (user) {
        return JSON.parse(user);
    }
    return null;
}

// Set the user data to the inputs
const setUserData = () => {
    user.value.name = getUser().name;
    user.value.email = getUser().email;
}

// Save the user data, on Update
const save = async () => {
    axios.patch('/users', {
        name: user.value.name,
    }).then(response => {
        // Update the user data in localStorage
        localStorage.setItem('user', JSON.stringify(response.data[0]));

        // Set the user data to the inputs with the updated data from localStorage
        setUserData();
    }).catch(error => {
        console.log(error.response);
    });
}

// While component is mounted, set the user data to the inputs
onMounted(() => {
    setUserData();
});

</script>
<template>
    <div class="flex justify-center items-center h-screen bg-gradient bg-gradient-to-t from-white to-pink-100">
        <div class="p-2 shadow-lg rounded-lg">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text"
                    class="block w-full rounded-md border-pink-300 shadow-sm focus:border-pink-400 focus:ring focus:ring-primary-200 focus:ring-opacity-50 disabled:cursor-not-allowed disabled:bg-pink-50 disabled:text-pink-500 p-2"
                    placeholder="Name" v-model="user.name" />
                <input type="text"
                    class="block w-full rounded-md border-pink-300 shadow-sm focus:border-pink-400 focus:ring focus:ring-primary-200 focus:ring-opacity-50 cursor-not-allowed disabled:bg-pink-100 disabled:text-pink-500 p-2"
                    placeholder="Email" readonly v-model="user.email" />
            </div>
            <button type="button"
                class=" mt-2 rounded-lg border border-pink-500 bg-pink-500 px-3 py-1.5 text-center text-sm font-medium text-white shadow-sm transition-all hover:border-pink-600 hover:bg-pink-600 focus:ring focus:ring-pink-200 disabled:cursor-not-allowed disabled:border-pink-300 disabled:bg-pink-300"
                v-on:click="save">Save</button>
        </div>
    </div>
</template>
<style scoped></style>