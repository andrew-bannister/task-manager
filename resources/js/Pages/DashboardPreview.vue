<script setup>
import {Head, Link} from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TaskWidgetFake from "@/Components/TaskWidgetFake.vue";

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
    <Head title="Dashboard Preview" />

    <AuthenticatedLayout>
        <template #header>
            <div class="grid grid-cols-2 items-center">
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Dashboard Preview
                </h2>
                <div class="grid place-items-end">
                    <p>
                        <Link class="py-2 mx-2 px-8 bg-green-300 rounded-lg border-2 border-green-400 hover:border-black" :href="route('status.new')">New Status</Link>
                        <span class="py-2 px-8 bg-orange-300 rounded-lg border-2 border-orange-400 hover:border-black" @click="editStatuses">Edit Statuses</span>
                    </p>
                </div>
            </div>
        </template>
        <div class="grid gap-6 lg-gap-8 p-4 item" :class="column_no">
            <div v-for="status in statuses" class="flex flex-col gap-6 items-stretch text-center items-center overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                <h2>{{ status.name }}</h2>
                <div>
                    <div v-for="n in Math.floor(Math.random() * (statuses.length + 1))" class="my-4">
                        <TaskWidgetFake />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
export default {
    methods: {
        editStatuses: () => {

        }
    }
}
</script>
