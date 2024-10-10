<script setup>
import { nextTick, onMounted, ref, watch } from 'vue'

// All props, comings from DashboardPage.vue
const props = defineProps({
    conversationId: Number,
    showChatWindow: Boolean
})

// Inputs
const message = ref('')
const messages = ref([]);
const auth_user = JSON.parse(localStorage.getItem('user'))['id'];
const chatContainer = ref(null);

// function to render chat list
const renderChatList = async () => {
    await axios.get(`/conversation/${props.conversationId}/messages`).then((response) => {
        messages.value = response.data[0];
        scrollToBottom();
        console.log(messages.value);
    }).catch((error) => {
        console.log(error.response.data.message);
    });
}

// function to send message 
const sendMessage = async () => {
    await axios.post(`/conversation/${props.conversationId}/message`, {
        message: message.value,
    }).then((response) => {
        message.value = '';
        renderChatList();
        // messages.value.push(response.data[0]);
    }).catch((error) => {
        console.log(error.response.data.message);
    });
}


// Watch the conversationId
watch(() => props.conversationId, async (newValue, oldValue) => {
    await renderChatList();
})

onMounted(async () => {
    console.log('Chat Window Mounted', auth_user);
})

</script>


<template>
    <div v-if="showChatWindow" class="flex flex-col h-full">
        <header class="sticky top-0 bg-blue-200 p-4 text-center font-bold">
            You are talking to Panda {{ conversationId }}
        </header>

        <section class="flex-1 bg-blue-50 p-4 flex flex-col">
            <div class="flex-1 overflow-y-auto mb-4 scrollable" ref="chatContainer">
                <div class="flex flex-col gap-2">
                    <div v-for="(message, index) in messages" :key="index" class="flex items-start"
                        :class="{ 'justify-end': message.sender_id == auth_user }">
                        <div class="relative h-8 w-8 mr-2" v-if="message.sender_id !== auth_user">
                            <img class="h-full w-full rounded-full object-cover" src="/public/img/logo.png" alt="" />
                        </div>
                        <div class="bg-white p-2 rounded-lg shadow-md max-w-xs break-words">
                            <p class="text-sm">{{ message.message }}</p>
                        </div>
                        <div class="relative h-8 w-8 ml-2" v-if="message.sender_id == auth_user">
                            <img class="h-full w-full rounded-full object-cover" src="/public/img/logo.png" alt="" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="sticky bottom-0 flex items-center bg-blue-50 p-4">
                <input type="text" class="flex-1 p-2 border rounded-lg" placeholder="Your Message to panda ?"
                    v-model="message" @keyup.enter="sendMessage" />
                <button class="ml-2 p-2 bg-pink-500 text-white rounded-lg" v-on:click="sendMessage">Send</button>
            </div>
        </section>
    </div>
</template>


<style scoped></style>