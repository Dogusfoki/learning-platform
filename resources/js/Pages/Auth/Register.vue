<script setup>
import { Head, useForm } from "@inertiajs/vue3";

defineOptions({
    layout: null,
});

const form = useForm({
    name: "",
    email: "",
    password: "",
});

function submit() {
    form.post("/register");
}
</script>

<template>
    <Head title="Register" />

    <h1>Register</h1>

    <form @submit.prevent="submit">
        <label>Name</label>
        <input type="text" v-model="form.name" />
        <div v-if="form.errors.name" class="text-red-500 text-xs italic mt-1">
            {{ form.errors.name }}
        </div>

        <label>Email</label>
        <input type="email" v-model="form.email" />
        <div v-if="form.errors.name" class="text-red-500 text-xs italic mt-1">
            {{ form.errors.name }}
        </div>

        <label>Password</label>
        <input type="password" v-model="form.password" />
        <div v-if="form.errors.name" class="text-red-500 text-xs italic mt-1">
            {{ form.errors.name }}
        </div>

        <button :disabled="form.processing">Register</button>
    </form>
</template>
