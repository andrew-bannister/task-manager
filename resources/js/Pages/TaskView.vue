<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

let props = defineProps({
    task: {
        type: Array
    }
});
</script>
<template>
    <Head title="Task Viewer" />
    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-2 items-center">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Task View
                </h2>
                <div class="grid place-items-end">
                    <p>
                        <Link class="py-2 px-8 mx-2 bg-green-300 rounded-lg border-2 border-green-400 hover:border-black" :href="this.taskRoute + task.data.id + '/edit'">Edit Task</Link>
                        <Link class="py-2 px-8 bg-red-300 rounded-lg border-2 border-red-400 hover:border-black" :href="this.taskRoute + task.data.id + '/delete'">Delete Task</Link>
                    </p>
                </div>
            </div>
        </template>
        <div class="flex justify-center">
            <div class="flex flex-col place-content-center gap-6 text-center max-w-screen-sm w-fit rounded-lg bg-white pt-6 my-6 mx-32 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                <p class="text-left text-gray-400">{{ task.data.label }}</p>
                <p class="overflow-hidden font-bold text-center">{{ task.data.title }}</p>
                <p class="overflow-hidden text-center">{{ task.data.description }}</p>
                <div class="flex justify-between items-center overflow-hidden w-full mt-6">
                    <span class="text-left text-green-300">{{ task.data.type.name }}</span>
                    <span class="text-right text-red-300">{{ task.data.status.name }}</span>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
export default {
    data() {
        return {
            taskRoute: '/tasks/'
        }
    }
}
</script>
