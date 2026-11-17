<script setup>
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    password: "",
});

function submit() {
    form.post("/users");
}
</script>

<template>
    <Head title="Create User" />
    <h1>Create User</h1>

    <form @submit.prevent="submit">
        <label>name</label>
        <input v-model="form.name" type="text" />
        <div v-if="form.errors.name" class="text-red-500 text-xs italic mt-1">
            {{ form.errors.name }}
        </div>

        <label>email</label>
        <input v-model="form.email" type="email" />
        <div v-if="form.errors.email" class="text-red-500 text-xs italic mt-1">
            {{ form.errors.email }}
        </div>

        <label>password</label>
        <input v-model="form.password" type="password" />
        <div
            v-if="form.errors.password"
            class="text-red-500 text-xs italic mt-1"
        >
            {{ form.errors.password }}
        </div>

        <button :disabled="form.processing">Create User</button>
    </form>
</template>
