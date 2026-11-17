<script setup>
import Nav from "@/Shared/Nav.vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage();
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <Nav />
        <div v-if="page.props.flash?.success" style="color: green">
            {{ page.props.flash?.success }}
        </div>
        <main class="p-6">
            <div>Welcome back, {{ $page.props.auth?.user?.name }}</div>
            <slot />
        </main>
    </div>
</template>
