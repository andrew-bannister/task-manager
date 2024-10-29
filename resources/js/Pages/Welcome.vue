<script setup>
import { Head, Link } from '@inertiajs/vue3';
import LoginDashboard from "@/Components/LoginDashboard.vue";

const props = defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}

</script>

<template>
    <Head title="TASKMANAGER" />
    <div class="bg-current text-black/50 dark:bg-black dark:text-white/50">
        <img
            id="background"
            class="absolute top-0"
            src="https://images.pexels.com/photos/743986/pexels-photo-743986.jpeg"
        />
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header
                    class="items-center gap-2 py-10"
                >
                    <h1 class="text-5xl flex justify-center">TASKMANAGER</h1>
                </header>

                <main class="mt-6">
                    <p class="flex justify-center pb-5">
                        Welcome to the best goddamn task management application you've ever seen.
                    </p>
                    <LoginDashboard :canLogin="canLogin" :canRegister="canRegister"/>
                </main>
            </div>
        </div>
    </div>
</template>
