<script setup>
import { Link, router, useForm } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardFooter,
    CardTitle,
} from "@/components/ui/card";

import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import { ref } from "vue";

const props = defineProps({
    topic: Object,
    course: Object,
});
const showCreateLessonDialog = ref(false);

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

const showCreateLessonsDialog = ref(false);
const lessonForm = ref({
    title: "",
    content: "",
    video: null,
});

const createLesson = () => {
    console.log("video in form:", lessonForm.value.video);
    const data = new FormData();

    data.append("title", lessonForm.value.title);
    data.append("content", lessonForm.value.content);

    if (lessonForm.value.video) {
        data.append("video", lessonForm.value.video);
    }

    console.log("createLesson called");

    router.post(`/topics/${props.topic.id}/lessons`, data, {
        onSuccess: () => {
            console.log("success");

            showCreateLessonDialog.value = false;

            lessonForm.value = {
                title: "",
                content: "",
                video: null,
            };
        },
        onError: (errors) => {
            console.log("errors:", errors);
        },
    });
};

const deleteLesson = (lesson) => {
    router.delete(`/lessons/${lesson.id}`, {
        onSuccess: () => {},
    });
};
</script>

<template>
    <div class="space-y-4">
        <Card class="mx-auto max-w-2xl">
            <CardHeader>
                <CardTitle>{{ topic.title }}</CardTitle>

                <CardDescription>
                    Course:
                    <Link
                        v-if="course"
                        :href="`/courses`"
                        class="font-medium underline-offset-4 hover:underline"
                    >
                        {{ course?.title }}
                    </Link>
                </CardDescription>
            </CardHeader>

            <CardContent>
                <div
                    v-if="topic.lessons && topic.lessons.length > 0"
                    class="space-y-2"
                >
                    <div
                        v-for="lesson in topic.lessons"
                        :key="lesson.id"
                        class="rounded-md border p-3"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-medium">{{ lesson.title }}</p>
                                <p class="text-sm text-muted-foreground">
                                    {{ lesson.content }}
                                </p>
                            </div>

                            <Button
                                variant="destructive"
                                size="sm"
                                @click="deleteLesson(lesson)"
                            >
                                X
                            </Button>
                        </div>

                        <video
                            v-if="lesson.video_path"
                            :src="`/storage/${lesson.video_path}`"
                            controls
                            class="mt-3 w-full rounded-md"
                        ></video>
                    </div>
                </div>

                <p v-else class="text-sm text-muted-foreground">
                    No lessons yet.
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
    <Dialog v-model:open="showCreateLessonDialog">
        <DialogTrigger as-child>
            <Button @click="showCreateLessonDialog = true"> Add Lesson </Button>
        </DialogTrigger>

        <DialogContent>
            <DialogHeader>
                <DialogTitle>Add lesson</DialogTitle>
                <DialogDescription>
                    Add a new lesson to this topic.
                </DialogDescription>
            </DialogHeader>

            <form @submit.prevent="createLesson" class="space-y-4">
                <div class="space-y-2">
                    <Label for="lesson-title">Title</Label>
                    <Input
                        id="lesson-title"
                        v-model="lessonForm.title"
                        type="text"
                        placeholder="Lesson title"
                        required
                    />
                </div>

                <div class="space-y-2">
                    <Label for="lesson-content">Content</Label>
                    <Textarea
                        id="lesson-content"
                        v-model="lessonForm.content"
                        placeholder="Lesson content"
                        required
                    />
                </div>

                <div class="space-y-2">
                    <Label for="video">Video</Label>
                    <Input
                        id="video"
                        type="file"
                        accept="video/mp4,video/webm,video/ogg,video/quicktime"
                        @change="
                            lessonForm.video = $event.target.files[0];
                            console.log(
                                'selected video:',
                                $event.target.files[0],
                            );
                        "
                    />
                </div>

                <DialogFooter>
                    <Button
                        type="button"
                        variant="outline"
                        @click="showCreateLessonDialog = false"
                    >
                        Cancel
                    </Button>

                    <Button type="submit"> Save lesson </Button>
                </DialogFooter>
            </form>
        </DialogContent>
    </Dialog>
</template>
