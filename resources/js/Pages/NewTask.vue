<script setup>
import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Inertia} from "@inertiajs/inertia";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextboxInput from "@/Components/TextboxInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    label: '',
    title: '',
    description: '',
    type: '',
    status: '',
});

const props = defineProps({
    types: {
        type: Object
    },
    statuses: {
        type: Array
    }
});

const submit = () => {
    form.post(route('new-task'), {
        onFinish: () => {
            Inertia.visit(route('dashboard'))
        }
    })
}

</script>

<template>
    <Head title="New Task" />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                New Task
            </h2>
        </template>
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
                        {{ status.name }}
                    </option>
                </select>
            </div>

            <PrimaryButton
                class="ms-4"
                :class="{'opacity-25': form.processing}"
                :disabled="form.processing"
            >
                Submit
            </PrimaryButton>

        </form>
    </AuthenticatedLayout>
</template>
