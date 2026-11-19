<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Label } from "@/components/ui/label";
import { Button } from "@/components/ui/button";

import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";

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
    <Card>
        <CardHeader>
            <CardTitle>Edit Course</CardTitle>
            <CardDescription class="mt-2">
                Update the course details</CardDescription
            >
        </CardHeader>
        <CardContent>
            <form @submit.prevent="submit" class="space-y-4">
                <Label for="title">Title</Label>
                <Input id="title" v-model="title" placeholder="Title" />
                <p v-if="props.errors.title" class="text-sm text-red-500">
                    {{ props.errors.title }}
                </p>
                <Label for="description">Description</Label>
                <Textarea
                    id="description"
                    v-model="description"
                    placeholder="Description"
                ></Textarea>
                <CardFooter>
                    <Button type="submit">Update</Button>
                    <Button as-child variant="outline">
                        <Link href="/courses">Back to Courses</Link>
                    </Button>
                </CardFooter>
            </form>
        </CardContent>
    </Card>
</template>
