<script setup>
import { Link } from '@inertiajs/vue3';

</script>
<template>
    <div class="flex flex-col justify-center items-center h-screen">
        <div class="p-2 shadow-lg rounded-lg">

            <h1 class="font-mono text-xl p-2 rounded-lg text-pink-400 shadow">Hi ! I am panda, whats your name ?</h1>
            <img src="/public/img/logo.png" alt="Logo">


            <div class="flex justify-end gap-2 items-center">
                <input type="text" name="" id="" value="I am Cute Panda :DD"
                    class="p-2 bg-gray-100 rounded-lg text-xl font-mono">
                <Link href="/login"
                    class="px-2 m-0 border rounded-md text-lg bg-pink-300 text-white shadow-md font-mono hover:shadow-lg hover:scale-105">
                Send
                </Link>
            </div>
        </div>
    </div>
</template>
<style scoped></style>