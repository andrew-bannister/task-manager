<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3'
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TaskWidgetFake from "@/Components/TaskWidgetFake.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Inertia} from "@inertiajs/inertia";

let props = defineProps({
    user: {
        type: Object
    },
    statuses: {
        type: Array
    },
});

const newForm = useForm({
    name: '',
});

const submitNewStatus = () => {
    newForm.post(route('status.new'));
}

const editStatusOrder = (statusId, newOrder) => {
    Inertia.put(route('status.update', statusId), {
        order:newOrder,
    });
}

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
                        <span class="py-2 mx-2 px-8 bg-green-300 rounded-lg border-2 border-green-400 hover:border-black hover:cursor-pointer" id="newStatusButton" @click="newStatus">New Status</span>
                    </p>
                    <div id="newStatusDiv" style="display: none;">
                        <form @submit.prevent="submitNewStatus">
                            <input id="newStatusInput" name="statusName" required v-model="newForm.name" placeholder="Enter Status Name...">
                            <PrimaryButton
                                class="ms-4"
                                :class="{'opacity-25': newForm.processing}"
                                :disabled="newForm.processing"
                            >
                                Submit
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </template>
        <div class="grid gap-6 lg-gap-8 p-4 item" :class="column_no">
            <div v-for="status in statuses" class="flex flex-col gap-6 items-stretch items-end text-center rounded-lg bg-white px-6 pt-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
                <h2>{{ status.name }}</h2>
                <div>
                    <div v-for="n in Math.floor(Math.random() * (statuses.length + 1))" class="mt-4">
                        <TaskWidgetFake />
                    </div>
                </div>
                <form @submit.prevent="editStatusOrder" class="mt-auto">
                    <p>
                        <label :for="`status-order-${status.id}`">Position</label>
                    </p>
                    <p>
                        <input
                            :id="`status-order-${status.id}`"
                            type="number"
                            min="1"
                            :max="`${statuses.length}`" v-model="status.pivot.order"
                            @change="(event) => editStatusOrder(status.id, event.target.value)">
                    </p>
                </form>
                <div>
                    <Link class="py-2 mx-2 px-8 bg-red-300 rounded-lg border-2 border-red-400 hover:border-black" :href="'/statuses/status/' + status.id + '/delete'">Delete Status</Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";

export default {
    data() {
        return {
            statusOrder: ''
        }
    },
    methods: {
        newStatus: () => {
            document.getElementById('newStatusButton').style.display = 'none';
            document.getElementById('newStatusDiv').style.display = 'block';
        }
    }
}
</script>
