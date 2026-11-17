<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";

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

    <div class="mx-auto max-w-md p-6">
        <h1 class="mb-6 text-2xl font-semibold">Login</h1>

        <form class="space-y-4" @submit.prevent="submit">
            <div class="space-y-2">
                <Label for="email">Email</Label>

                <Input
                    id="email"
                    v-model="form.email"
                    type="email"
                    placeholder="Email"
                />

                <p v-if="form.errors.email" class="text-sm text-red-500">
                    {{ form.errors.email }}
                </p>
            </div>

            <div class="space-y-2">
                <Label for="password">Password</Label>

                <Input
                    id="password"
                    v-model="form.password"
                    type="password"
                    placeholder="Password"
                />

                <p v-if="form.errors.password" class="text-sm text-red-500">
                    {{ form.errors.password }}
                </p>
            </div>

            <Button type="submit" :disabled="form.processing"> Login </Button>
        </form>
    </div>
</template>
