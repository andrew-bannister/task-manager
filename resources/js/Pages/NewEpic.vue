<script setup>
import {Head} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextboxInput from "@/Components/TextboxInput.vue";
import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    statuses: {
        type: Object
    }
});
</script>
<template>
    <Head title="New Epic"/>
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                New Epic
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
                        :maxlength="labelMaxLength"
                    />
                    <p v-if="maxLabelLengthReached" class="text-red-500">
                        Warning! Max label length is {{ labelMaxLength }} characters.
                    </p>
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
                        :maxlength="titleMaxLength"
                    />
                    <p v-if="maxTitleLengthReached" class="text-red-500">
                        Warning! Max title length is {{ titleMaxLength }} characters.
                    </p>
                </div>

                <div class="mt-4">
                    <InputLabel for="description" value="Description" />
                    <TextboxInput
                        id="description"
                        type="textarea"
                        class="mt-1 block w-full"
                        v-model="form.description"
                        autocomplete="description"
                        :maxlength="descMaxLength"
                    />
                    <p v-if="maxDescLengthReached" class="text-red-500">
                        Warning! Max description length is {{ descMaxLength }} characters.
                    </p>
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
                <div>
                    <div class="text-left">
                        <div v-for="(task, index) in childTasks"
                             :key="index"
                        >
                            <div>
                                <p>{{ task.label }}</p>
                                <p>{{ task.title }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <InputLabel for="task-search">Search for child tasks</InputLabel>
                        <input
                            id="task-search"
                            v-model="searchThroughTasks"
                            @input="searchTasks"
                            autocomplete="off"
                        >
                        <div v-for="(task, index) in searchedTasks"
                            :key="index"
                            @click="selectTask(task)">
                            <div>
                                <p>{{ task.label }}</p>
                                <p>{{ task.title }}</p>
                            </div>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <PrimaryButton
                        class="ms-4 mt-4"
                        :class="{'opacity-25': form.processing}"
                        :disabled="form.processing"
                    >
                        Submit
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import {Inertia} from "@inertiajs/inertia";

const form = useForm({
    label: '',
    title: '',
    description: '',
    status: '',
    childTasks: '',
    type: 'Epic',
});

const searchThroughTasks = ref('');

export default {
    data () {
        return {
            labelMaxLength: 15,
            titleMaxLength: 100,
            descMaxLength: 2048,
            searchedTasks: [],
            childTasks: [],
        };
    },
    computed: {
        maxLabelLengthReached() {
            return form.label.length >= this.labelMaxLength;
        },
        maxTitleLengthReached() {
            return form.title.length >= this.titleMaxLength;
        },
        maxDescLengthReached() {
            return form.description.length >= this.descMaxLength;
        }
    },
    methods: {
        submit() {
            form.childTasks = this.childTasks;
            console.log(form);
            form.post(route('epic.store'), {
                // onFinish: () => {
                //     Inertia.visit(route('dashboard'))
                // }
            })
        },
        searchTasks() {
            axios.get(route('api.task.search'), {
                params: { query: searchThroughTasks.value },
            }).then(response => {
                const childTasksArray = this.childTasks;
                let excludedTasksArray = response.data.map(
                    function (task) {
                        let check = false;
                        for (let i = 0; i < childTasksArray.length; i++) {
                            if (task.id === childTasksArray[i].id) {
                                check = true;
                            }
                        }
                        if (!check) {
                            return task;
                        }
                    }
                );
                excludedTasksArray = excludedTasksArray.filter(
                    (task) => task != undefined
                );
                this.searchedTasks = excludedTasksArray;
            })
        },
        selectTask(task) {
            this.childTasks.push(task);
            this.searchedTasks = this.searchedTasks.filter((arrayTask) =>
                arrayTask != task
            );
        },
    }
};
</script>
