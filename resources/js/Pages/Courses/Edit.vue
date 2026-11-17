<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Label } from "@/components/ui/label";
import { Button } from "@/components/ui/button";

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
        <Label for="title">Title</Label>
        <Input id="title" v-model="title" placeholder="Title" />
        <p v-if="props.errors.title" style="color: red">
            {{ props.errors.title }}
        </p>
        <Label for="description">Description</Label>
        <Textarea
            id="description"
            v-model="description"
            placeholder="Description"
        ></Textarea>

        <Button type="submit">Update</Button>
    </form>
    <Button as-child variant="outline">
        <Link href="/courses">Back to Courses</Link>
    </Button>
</template>
