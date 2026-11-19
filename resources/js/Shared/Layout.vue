<script setup>
import Nav from "@/Shared/Nav.vue";
import "vue-sonner/style.css";
import { Toaster } from "@/components/ui/sonner";
import { watch } from "vue";
import { usePage } from "@inertiajs/vue3";
import { toast } from "vue-sonner";

const page = usePage();

watch(
    () => page.props.flash?.success,
    (message) => {
        if (message) {
            toast.success(message, {
                duration: 3000,
            });
        }
    },
    { immediate: true },
);
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <Nav />

        <main class="p-6">
            <slot />
        </main>

        <Toaster
            position="top-right"
            :toast-options="{
                style: {
                    background: 'rgba(255, 255, 255, 0.65)',
                    backdropFilter: 'blur(8px)',
                    border: '1px solid rgba(0, 0, 0, 0.08)',
                    boxShadow: '0 8px 24px rgba(0, 0, 0, 0.10)',
                    color: '#111827',
                },
            }"
        />
    </div>
</template>
