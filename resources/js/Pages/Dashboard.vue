<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TaskWidget from '@/Components/TaskWidget.vue';
import { Head, Link } from '@inertiajs/vue3';
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

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
                    <Dropdown align="right" width="48">
                        <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button
                                    type="button"
                                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                >
                                    <svg
                                        class="-me-0.5 ms-2 h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </span>
                        </template>
                        <template #content>
                            <DropdownLink
                                :href="route('task.new')"
                            >
                                New Task
                            </DropdownLink>
                            <DropdownLink
                                :href="route('epic.new')"
                            >
                                New Epic
                            </DropdownLink>
                            <DropdownLink
                                :href="route('statuses')"
                            >
                                Dashboard Preview
                            </DropdownLink>
                        </template>
                    </Dropdown>
                </div>
            </div>
        </template>
        <div class="grid gap-6 lg-gap-8 p-4 item" :class="column_no">
            <div v-for="status in statuses" class="flex flex-col gap-6 items-stretch text-center items-center overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
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
