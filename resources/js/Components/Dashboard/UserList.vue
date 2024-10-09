<script setup>
import { ref, reactive, onMounted, defineEmits } from 'vue';

// Define the emit function
const emit = defineEmits({
    openChatWindow: null,
});

// Function to fire the openChatWindow event
function openChatWindow(id) {
    emit('openChatWindow', id);
}

// user list
const users = reactive([]);

// Function to get the list of users
const getUserList = async () => {
    await axios.get('/users').then((response) => {
        users.push(...response.data[0]);
    }).catch((error) => {
        console.log(error);
    });
}

// Function to add a conversation
const addConversation = async (id) => {
    await axios.post('/conversation', {
        user_id: id,
    }).then((response) => {
        console.log(response.data[0]);
        openChatWindow(response.data[0].id);
    }).catch((error) => {
        console.log(error.response);
    });
}


// Call the getUserList function on component mount
onMounted(async () => {
    await getUserList();
})

</script>
<template>
    <aside class="flex-none bg-pink-200 p-4 w-1/6">
        <!-- Users List Card -->
        <div v-for="(user, index) in users" :key="index"
            class="flex gap-2 my-2 justify-between pl-4 items-center shadow-lg p-1 rounded-md cursor-default">
            <div class="flex justify-start gap-2 items-center">
                <div class="relative h-8 w-8">
                    <img class="h-full w-full rounded-full object-cover object-center" src="/public/img/logo.png"
                        alt="" />
                    <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>
                </div>
                <span>{{ user.name }}</span>
            </div>
            <button class="p-1 rounded-lg border-white border-2 hover:scale-105 hover:cursor-pointer"
                v-on:click="addConversation(user.id)">Talk</button>
        </div>
    </aside>
</template>
<style scoped></style>