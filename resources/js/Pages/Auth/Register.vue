<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";

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
    <div class="mx-auto max-w-md p-6">
        <h1 class="mb-6 text-2xl font-semibold">Register</h1>
        <form class="space-y-4" @submit.prevent="submit">
            <div class="space-y-2">
                <Label for="name">Name</Label>
                <Input
                    placeholder="Name"
                    id="name"
                    type="text"
                    v-model="form.name"
                />
                <div
                    v-if="form.errors.name"
                    class="text-red-500 text-xs italic mt-1"
                >
                    {{ form.errors.name }}
                </div>
            </div>

            <div class="space-y-2">
                <Label for="email">Email</Label>
                <Input placeholder="Email" type="email" v-model="form.email" />
                <p v-if="form.errors.email" class="text-sm text-red-500">
                    {{ form.errors.email }}
                </p>
            </div>
            <div class="space-y-2">
                <Label for="password">Password</Label>
                <Input
                    placeholder="password"
                    id="password"
                    type="password"
                    v-model="form.password"
                />
                <p v-if="form.errors.password" class="text-sm text-red-500">
                    {{ form.errors.password }}
                </p>
            </div>
            <Button type="submit" :disabled="form.processing">Register</Button>
        </form>
    </div>
</template>
