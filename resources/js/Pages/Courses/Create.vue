<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Label } from "@/components/ui/label";
import Button from "@/components/ui/button/Button.vue";

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
        <Input v-model="title" placeholder="Title" />
        <p v-if="props.errors.title" style="color: red">
            {{ props.errors.title }}
        </p>
        <Label for="description">Description</Label>
        <Textarea
            id="description"
            v-model="description"
            placeholder="Description"
        ></Textarea>
        <Button type="submit">Create</Button>
    </form>
    <Button as-child variant="outline">
        <Link href="/courses"> Back to Courses </Link>
    </Button>
</template>
