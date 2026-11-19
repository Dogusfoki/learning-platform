<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Label } from "@/components/ui/label";
import Button from "@/components/ui/button/Button.vue";

import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";

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
    <Card>
        <CardHeader class="px-6 pt-6">
            <CardTitle>Create Courses</CardTitle>
            <CardDescription class="pt-2">
                Fill in the form to create a new course.
            </CardDescription>
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
                <CardFooter class="pt-2">
                    <Button type="submit">Create</Button>
                    <Button as-child variant="outline">
                        <Link href="/courses"> Back to Courses </Link>
                    </Button>
                </CardFooter>
            </form>
        </CardContent>
    </Card>
</template>
