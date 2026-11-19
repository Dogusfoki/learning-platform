<script setup>
import { Link } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";

defineProps({
    topic: Object,
    course: Object,
});
</script>

<template>
    <div class="space-y-4">
        <Card class="mx-auto max-w-2xl">
            <CardHeader>
                <CardTitle>{{ topic.title }}</CardTitle>

                <CardDescription>
                    Course:
                    <Link
                        :href="`/courses`"
                        class="font-medium underline-offset-4 hover:underline"
                    >
                        {{ course.title }}
                    </Link>
                </CardDescription>
            </CardHeader>

            <CardContent>
                <p class="text-sm text-muted-foreground">
                    Topic details will be added here.
                </p>
            </CardContent>
        </Card>
        <div class="mx-auto max-w-2xl">
            <Link href="/courses">Back to Courses</Link>
        </div>
    </div>
</template>
