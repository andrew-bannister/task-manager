<template>
    <div class="bg-gray-100 p-4 rounded-lg border-solid border-2 hover:border-slate-400">
        <p class="text-left text-gray-400">{{ task.label }}</p>
        <p class="overflow-hidden text-center">{{ task.title }}</p>
    </div>
</template>

<script setup>
const props = defineProps({
    task: {
        type: Object
    }
})
</script>
