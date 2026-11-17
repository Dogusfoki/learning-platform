<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";

const title = ref("");
const description = ref("");

const props = defineProps({
    errors: Object,
});

function submit() {
    router.post("/courses", {
        title: title.value,
        description: description.value,
    });
}
</script>

<template>
    <h1>Create Courses</h1>

    <form @submit.prevent="submit">
        <input v-model="title" placeholder="Title" />
        <p v-if="props.errors.title" style="color: red">
            {{ props.errors.title }}
        </p>
        <textarea v-model="description" placeholder="Description"></textarea>
        <button type="submit">Create</button>
    </form>

    <Link href="/courses"> Back to Courses </Link>
</template>
