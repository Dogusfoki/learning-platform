<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    topic: Object,
});
</script>

<template>
    <h1>{{ topic.title }}</h1>
    <Link href="/courses">Back to Courses</Link>
</template>
