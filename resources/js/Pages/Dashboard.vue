<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TaskWidget from '@/Components/TaskWidget.vue';
import { Head } from '@inertiajs/vue3';
import {Link} from "@inertiajs/vue3";

let props = defineProps({
    user: {
        type: Object
    },
    statuses: {
        type: Array
    },
});

const column_no = 'grid-cols-' + props.statuses.length;

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-2 items-center">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Dashboard
                </h2>
                <div class="grid place-items-end">
                    <Link class="py-2 px-8 bg-green-300 rounded-lg border-2 border-green-400 hover:border-black" :href="route('new-task')">New Task</Link>
                </div>
            </div>
        </template>
        <div class="grid gap-6 lg-gap-8 p-4" :class="column_no">
            <div v-for="status in statuses" class="flex flex-col gap-6 items-stretch items-center overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                <h2>{{ status.name }}</h2>
                <div>
                    <div v-for="task in status.tasks" class="my-4">
                        <TaskWidget :task="task"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
