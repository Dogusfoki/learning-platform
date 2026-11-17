<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    course: Object,
    errors: Object,
});
const title = ref(props.course.title);
const description = ref(props.course.description);

function submit() {
    router.put(`/courses/${props.course.id}`, {
        title: title.value,
        description: description.value,
    });
}
</script>
<template>
    <h1>Edit Course</h1>

    <form @submit.prevent="submit">
        <input v-model="title" placeholder="Title" />
        <p v-if="props.errors.title" style="color: red">
            {{ props.errors.title }}
        </p>
        <textarea v-model="description" placeholder="Description"></textarea>

        <button type="submit">Update</button>
    </form>
    <Link href="/courses">Back to Courses</Link>
</template>
