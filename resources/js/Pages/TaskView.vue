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
                    Task Viewer
                </h2>
                <div class="grid place-items-end">
                    <p>
                        <Link class="py-2 px-8 mx-2 bg-green-300 rounded-lg border-2 border-green-400 hover:border-black" :href="this.taskRoute + task.data.id + '/edit'">Edit Task</Link>
                        <Link class="py-2 px-8 bg-red-300 rounded-lg border-2 border-red-400 hover:border-black" :href="this.taskRoute + task.data.id + '/delete'">Delete Task</Link>
                    </p>
                </div>
            </div>
        </template>
        <div class="mt-4">
            <p>
                <label for="label">Task Label:</label>
            </p>
            <p>
                <span id="label">{{ task.data.label }}</span>
            </p>
        </div>
        <div class="mt-4">
            <p>
                <label for="title">Task Title:</label>
            </p>
            <p>
                <span id="title">{{ task.data.title }}</span>
            </p>
        </div>
        <div class="mt-4">
            <p>
                <label for="description">Task Description:</label>
            </p>
            <p>
                <span id="description">{{ task.data.description }}</span>
            </p>
        </div>
        <div class="mt-4">
            <p>
                <label for="type">Task Type:</label>
            </p>
            <p>
                <span id="type">{{ task.data.type.name }}</span>
            </p>
        </div>
        <div class="mt-4">
            <p>
                <label for="status">Task Status:</label>
            </p>
            <p>
                <span id="status">{{ task.data.status.name }}</span>
            </p>
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
