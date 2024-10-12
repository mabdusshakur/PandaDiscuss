<script setup>
import { ref, reactive, onMounted } from 'vue';

// Define the emit function
const emit = defineEmits({
    openChatWindow: null,
});

// user list
const users = ref([]);

// Function to get the list of users
const getUserList = async () => {
    await axios.get('/users').then((response) => {
        users.value = response.data[0].map(user => ({
            ...user,
            isOnline: false,
        }));
    }).catch((error) => {
        console.log(error);
    });
}

// Function to add a conversation
const addConversation = async (id) => {
    await axios.post('/conversation', {
        user_id: id,
    }).then((response) => {
        // console.log(response.data[0]);
        emit('openChatWindow', response.data[0].id);
    }).catch((error) => {
        console.log(error.response);
    });
}

// Function to update user status
// const updateUserStatus = (userList, isOnline) => {
//     userList.forEach(user => {
//         const index = users.value.findIndex(u => u.id === user.id);
//         if (index !== -1) {
//             users.value[index].isOnline = isOnline;
//         }
//     });
// };

// Listen for presence channel events
// const subscribeToPresenceChannel = () => {
//     window.Echo.join('user-status').here(users => {
//         console.log('Init', users);
//         updateUserStatus(users, true);
//     }).joining(user => {
//         console.log('Joining', user);
//         updateUserStatus([user], true);
//     }).leaving(user => {
//         console.log('Leaving', user);
//         updateUserStatus([user], false);
//     }).listen('UserStatus', (e) => {
//         console.log('UserStatus', e);
//     });
// };

// Call the getUserList function on component mount
onMounted(async () => {
    await getUserList();

    // Not working yet
    // subscribeToPresenceChannel();
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
                    <span :class="{ 'bg-green-400': user.isOnline, 'bg-gray-400': !user.isOnline }"
                        class="absolute top-0 right-0 h-2 w-2 rounded-full ring ring-white"></span>
                </div>
                <span>{{ user.name }}</span>
            </div>
            <button class="p-1 rounded-lg border-white border-2 hover:scale-105 hover:cursor-pointer"
                v-on:click="addConversation(user.id)">Talk</button>
        </div>
    </aside>
</template>
<style scoped></style>