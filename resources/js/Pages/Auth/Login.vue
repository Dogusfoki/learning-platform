<script setup>
import { Head, useForm } from "@inertiajs/vue3";

defineOptions({
    layout: null,
});

const form = useForm({
    email: "",
    password: "",
});

function submit() {
    form.post("/login");
}
</script>

<template>
    <Head title="Login" />

    <h1>Login</h1>

    <form @submit.prevent="submit">
        <label>Email</label>
        <input v-model="form.email" type="email" />
        <div v-if="form.errors.email" class="text-red-500 text-xs italic mt-1">
            {{ form.errors.email }}
        </div>

        <label>Password</label>
        <input v-model="form.password" type="password" />

        <button :disabled="form.processing">Login</button>
    </form>
</template>
