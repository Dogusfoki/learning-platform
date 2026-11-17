<script setup>
import { Link, progress } from "@inertiajs/vue3";
defineProps({
    projects: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <div>
        <h1>Dashboard</h1>
        <ul>
            <li v-for="project in progress" :key="project.id">
                {{ project.title }} — {{ project.comments_count }} yorum
            </li>
        </ul>
        <ul>
            <li v-for="project in projects" :key="project.id">
                {{ project.title }} — {{ project.comments_count }} yorum
            </li>
        </ul>

        <p>Proje Sayisi: {{ projects.length }}</p>
    </div>

    <Link href="/" prefetch>Ana sayfaya git</Link>
</template>
