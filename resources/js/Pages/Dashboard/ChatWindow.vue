<script setup>
</script>
<template>
    <div>
        <header class="sticky top-0 bg-blue-200 p-4">
            You are talking to Panda
        </header>

        <section class="flex-1 bg-blue-50 p-4 flex flex-col">
            <div class="flex-1 overflow-y-auto mb-4">
                <div class="flex flex-col gap-2 h-[600px]">

                    <!-- Connected user -->
                    <div class="flex items-start">
                        <div class="relative h-8 w-8 mr-2">
                            <img class="h-full w-full rounded-full object-cover" src="/public/img/logo.png" alt="" />
                        </div>
                        <div class="bg-white p-2 rounded-lg shadow-md">
                            <p class="text-sm">Hello! How can I help you today?</p>
                        </div>
                    </div>

                    <!-- Auth User -->
                    <div class="flex items-start justify-end">
                        <div class="bg-white p-2 rounded-lg shadow-md">
                            <p class="text-sm">Hello! How can I help you today?</p>
                        </div>
                        <div class="relative h-8 w-8 ml-2">
                            <img class="h-full w-full rounded-full object-cover" src="/public/img/logo.png" alt="" />
                        </div>
                    </div>

                </div>
            </div>

            <div class="sticky bottom-0 flex items-center bg-blue-50 p-4">
                <input type="text" class="flex-1 p-2 border rounded-lg" placeholder="Your Message to panda ?" />
                <button class="ml-2 p-2 bg-pink-500 text-white rounded-lg">Send</button>
            </div>
        </section>
    </div>
</template>
<style scoped></style>