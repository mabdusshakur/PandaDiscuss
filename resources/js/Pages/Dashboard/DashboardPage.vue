<script setup>
import UserList from '../../Components/Dashboard/UserList.vue';
import ChatWindow from '../../Components/Dashboard/ChatWindow.vue';

import { ref } from 'vue';

// inputs
const showChatWindow = ref(false);
const conversationId = ref(0);


// Function to open chat window
const openChatWindow = (id) => {
    conversationId.value = id;
    showChatWindow.value = true;
};

</script>
<template>
    <div>
        <div class="flex h-screen bg-gradient bg-gradient-to-t from-white to-pink-100">

            <!-- UserList Component, openChatWindow is a emit -->
            <UserList @openChatWindow="openChatWindow" />

            <main class="w-1/6 flex-1 overflow-auto bg-pink-50 p-4 ">

                <!-- ChatWindow Component, showChatWindow and conversationId are props -->
                <ChatWindow :showChatWindow="showChatWindow" :conversationId="conversationId" />
            </main>
        </div>
    </div>
</template>
<style scoped></style>