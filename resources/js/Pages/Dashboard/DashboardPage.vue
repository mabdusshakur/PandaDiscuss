<script setup>
</script>
<template>
    <div>
        <div class="flex h-screen bg-gradient bg-gradient-to-t from-white to-pink-100">
            <aside class="flex-none bg-pink-200 p-4 w-1/6">


                <!-- Users List Card -->
                <div class="flex gap-2 my-2 justify-between pl-4 items-center shadow-lg p-1 rounded-md cursor-default">
                    <div class="flex justify-start gap-2 items-center">
                        <div class="relative h-8 w-8">
                            <img class="h-full w-full rounded-full object-cover object-center"
                                src="/public/img/logo.png" alt="" />
                            <span
                                class="absolute top-0 right-0 h-2 w-2 rounded-full bg-green-400 ring ring-white"></span>
                        </div>
                        <span>Panda</span>
                    </div>
                    <a class="p-1 rounded-lg border-white border-2 hover:scale-105 hover:cursor-pointer">Talk</a>
                </div>

            </aside>
            <main class="min-w-0 flex-1 overflow-auto bg-pink-50 p-4">Content</main>
        </div>
    </div>
</template>
<style scoped></style>