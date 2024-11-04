<script setup>

import {Inertia} from "@inertiajs/inertia";
import { Head, useForm } from "@inertiajs/vue3"
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextboxInput from "@/Components/TextboxInput.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    types: {
        type: Object
    },
    statuses : {
        type: Array
    },
    task: {
        type: Array
    }
});

const form = useForm({
    label: props.task.data.label,
    title: props.task.data.title,
    description: props.task.data.description,
    type: props.task.data.type.name,
    status: props.task.data.status.name,
})

const submit = () => {
    form.put(`/tasks/${props.task.data.id}`, {
        data: {
            task: props.task.data,
        },
        onFinish: () => Inertia.visit('/tasks/' + props.task.data.id)
    });
}
</script>

<template>
    <Head title="Edit Task" />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Edit Task
            </h2>
        </template>
        <div class="flex flex-col gap-6 items-stretch items-end rounded-lg bg-white px-6 pt-6 my-6 mx-32 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 pb-6 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="label" value="Label" />
                    <TextInput
                        id="label"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.label"
                        required
                        autofocus
                        autocomplete="label"
                    />
                </div>

                <div class="mt-4">
                    <InputLabel for="title" value="Title" />
                    <TextInput
                        id="title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.title"
                        required
                        autocomplete="title"
                    />
                </div>

                <div class="mt-4">
                    <InputLabel for="description" value="Description" />
                    <TextboxInput
                        id="description"
                        type="textarea"
                        class="mt-1 block w-full"
                        v-model="form.description"
                        autocomplete="description"
                    />
                </div>

                <!-- Types -->
                <div class="mt-4">
                    <select v-model="form.type">
                        <option disabled value="">Select a task type</option>
                        <option v-for="type in types" :value="type">
                            {{ type }}
                        </option>
                    </select>
                </div>

                <!-- Statuses -->
                <div class="mt-4">
                    <select v-model="form.status">
                        <option disabled value="">Select a task status</option>
                        <option v-for="status in statuses" :value="status">
                            {{ status }}
                        </option>
                    </select>
                </div>

                <div class="text-center">
                    <PrimaryButton
                        class="ms-4 mt-4"
                        :class="{'opacity-25': form.processing}"
                        :disabled="form.processing"
                    >
                        Save
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
