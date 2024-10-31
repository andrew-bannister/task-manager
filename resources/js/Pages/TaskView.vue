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
                    <div class="grid place-items-end">
                        <Link class="py-2 px-8 bg-green-300 rounded-lg border-2 border-green-400 hover:border-black" :href="this.taskRoute + task.id + '/edit'">Edit Task</Link>
                    </div>
                    <div class="grid place-items-end">
                        <Link class="py-2 px-8 bg-green-300 rounded-lg border-2 border-green-400 hover:border-black" :href="this.taskRoute + task.id + '/delete'">Delete Task</Link>
                    </div>
                </div>
            </div>
        </template>
        <div class="mt-4">
            <p>
                <label for="label">Task Label:</label>
            </p>
            <p>
                <span id="label">{{ task.label }}</span>
            </p>
        </div>
        <div class="mt-4">
            <p>
                <label for="title">Task Title:</label>
            </p>
            <p>
                <span id="title">{{ task.title }}</span>
            </p>
        </div>
        <div class="mt-4">
            <p>
                <label for="description">Task Description:</label>
            </p>
            <p>
                <span id="description">{{ task.description }}</span>
            </p>
        </div>
        <div class="mt-4">
            <p>
                <label for="type">Task Type:</label>
            </p>
            <p>
                <span id="type">{{ task.type.name }}</span>
            </p>
        </div>
        <div class="mt-4">
            <p>
                <label for="status">Task Status:</label>
            </p>
            <p>
                <span id="status">{{ task.status.name }}</span>
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
