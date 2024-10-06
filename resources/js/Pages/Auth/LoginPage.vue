<script setup>
</script>
<template>
    <div class="flex flex-col justify-center items-center h-screen bg-gradient bg-gradient-to-t from-white to-pink-100">
        <div class="p-2 shadow-lg rounded-lg">
            <div class="max-w-xl">
                <form action="" class="space-y-5">
                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email"
                            class="block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-pink-400 focus:ring-pink-200 focus:ring-opacity-50 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500"
                            placeholder="panda@email.com" />
                    </div>
                    <button type="button"
                        class="rounded-lg border border-pink-500 bg-pink-500 px-3 py-1.5 text-center text-sm font-medium text-white shadow-sm transition-all hover:border-pink-600 hover:bg-pink-600 focus:ring focus:ring-pink-200 disabled:cursor-not-allowed disabled:border-pink-300 disabled:bg-pink-300">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>
<style scoped></style>