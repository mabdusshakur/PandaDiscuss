<script setup>
import ChatWindow from './ChatWindow.vue';
import UserList from './UserList.vue';

</script>
<template>
    <div>
        <div class="flex h-screen bg-gradient bg-gradient-to-t from-white to-pink-100">
            <UserList />

            <main class="w-1/6 flex-1 overflow-auto bg-pink-50 p-4 ">
                <ChatWindow />
            </main>
        </div>
    </div>
</template>
<style scoped></style>