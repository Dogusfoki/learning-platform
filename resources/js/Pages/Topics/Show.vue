<script setup>
import { Link, router } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";

import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";

import { ref } from "vue";
const props = defineProps({
    topic: Object,
    course: Object,
});

const topicToDelete = ref(false);

function openDeleteDialog() {
    topicToDelete.value = true;
}

function closeDeleteDialog() {
    topicToDelete.value = false;
}

function deleteTopic() {
    router.delete(`/topics/${props.topic.id}`, {
        onSuccess: () => closeDeleteDialog(),
    });
}
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
            <CardFooter class="flex justify-between px-6">
                <Link href="/courses">
                    <Button variant="outline">Back to courses</Button>
                </Link>

                <Button
                    variant="destructive"
                    size="sm"
                    @click="openDeleteDialog"
                >
                    Delete
                </Button>
            </CardFooter>
        </Card>
    </div>

    <Dialog :open="topicToDelete" @update:open="closeDeleteDialog">
        <DialogContent class="sm:max-w-md">
            <DialogHeader>
                <DialogTitle>Delete topic</DialogTitle>

                <DialogDescription>
                    Are you sure you want to delete
                    <span class="font-medium"> {{ topic.title }} </span>?
                </DialogDescription>
            </DialogHeader>

            <DialogFooter>
                <Button variant="outline" @click="closeDeleteDialog">
                    Cancel
                </Button>

                <Button variant="destructive" @click="deleteTopic">
                    Delete
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
