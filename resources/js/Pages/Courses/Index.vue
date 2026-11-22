<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { Button } from "@/components/ui/button";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import {
    Card,
    CardContent,
    CardHeader,
    CardTitle,
    CardFooter,
    CardDescription,
} from "@/components/ui/card";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";

const props = defineProps({
    courses: {
        type: Object,
        required: true,
    },
    topics: {
        type: Object,
        default: () => [],
    },
});

const allCourses = ref(props.courses.data);

watch(
    () => props.courses,
    (newCourses) => {
        const existingIds = new Set(
            allCourses.value.map((course) => course.id),
        );

        const newItems = newCourses.data.filter(
            (course) => !existingIds.has(course.id),
        );

        allCourses.value = [...allCourses.value, ...newItems];
    },
);

function createTopic(course) {
    const title = topicForms.value[course.id];

    if (!title) {
        return;
    }

    router.post(`/courses/${course.id}/topics`, {
        title,
    });

    topicForms.value[course.id] = "";
}

function loadMore() {
    router.reload({
        only: ["courses"],
        data: {
            page: props.courses.current_page + 1,
        },
    });
}

function confirmDelete() {
    router.delete(`/courses/${courseToDelete.value.id}`, {
        onSuccess: () => {
            allCourses.value = allCourses.value.filter(
                (c) => c.id !== courseToDelete.value.id,
            );

            courseToDelete.value = null;
        },
    });
}

const courseToDelete = ref(null);

const topicForms = ref({});

const topicToDelete = ref(null);
function openDeleteDialog(topic) {
    topicToDelete.value = topic;
}

function closeDeleteDialog() {
    topicToDelete.value = null;
}

function deleteTopic() {
    if (!topicToDelete.value) return;

    router.delete(`/topics/${topicToDelete.value.id}`, {
        onSuccess: () => closeDeleteDialog(),
    });
}
</script>
<template>
    <Card>
        <CardHeader>
            <CardTitle>Courses: {{ courses.data.length }}</CardTitle>
            <CardDescription>
                Topics: {{ Object.keys(topics).length }}
            </CardDescription>
        </CardHeader>

        <CardContent>
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Title</TableHead>
                        <TableHead>Actions</TableHead>
                        <TableHead class="w-65">Topics</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
                    <TableRow v-if="allCourses.length === 0">
                        <TableCell
                            colspan="3"
                            class="py-10 text-center text-muted-foreground"
                        >
                            No courses yet.
                        </TableCell>
                    </TableRow>
                    <TableRow v-for="course in allCourses" :key="course.id">
                        <TableCell>
                            {{ course.title }}
                        </TableCell>

                        <TableCell>
                            <Button as-child variant="outline">
                                <Link :href="`/courses/${course.id}/edit`"
                                    >Edit</Link
                                >
                            </Button>
                            <!-- Delete button  -->
                            <Dialog>
                                <DialogTrigger as-child>
                                    <Button
                                        variant="destructive"
                                        @click="courseToDelete = course"
                                    >
                                        Delete
                                    </Button>
                                </DialogTrigger>

                                <DialogContent>
                                    <DialogHeader>
                                        <DialogTitle>Delete Course</DialogTitle>

                                        <DialogDescription>
                                            Are you sure you want to delete this
                                            course?
                                        </DialogDescription>
                                    </DialogHeader>

                                    <DialogFooter>
                                        <DialogTrigger as-child>
                                            <Button variant="outline"
                                                >Cancel</Button
                                            >
                                        </DialogTrigger>

                                        <Button
                                            variant="destructive"
                                            @click="confirmDelete"
                                        >
                                            Delete
                                        </Button>
                                    </DialogFooter>
                                </DialogContent>
                            </Dialog>
                        </TableCell>

                        <TableCell>
                            <div class="space-y-2">
                                <div
                                    v-if="topics[course.id]?.length"
                                    class="flex flex-wrap gap-1.5"
                                >
                                    <div
                                        v-for="topic in topics[course.id]"
                                        :key="topic.id"
                                        class="inline-flex items-center gap-1 rounded-full border bg-muted px-2.5 py-0.5 text-xs font-medium text-muted-foreground"
                                    >
                                        <Link
                                            :href="`/topics/${topic.id}`"
                                            class="hover:text-accent-foreground"
                                        >
                                            {{ topic.title }}
                                        </Link>

                                        <Button
                                            variant="ghost"
                                            size="sm"
                                            type="button"
                                            class="text-muted-foreground transition hover:text-destructive"
                                            @click="openDeleteDialog(topic)"
                                        >
                                            X
                                        </Button>
                                    </div>
                                </div>

                                <form
                                    class="flex items-center gap-2"
                                    @submit.prevent="createTopic(course)"
                                >
                                    <Input
                                        :id="`topic-title-${course.id}`"
                                        v-model="topicForms[course.id]"
                                        placeholder="New topic"
                                        class="h-8 text-sm"
                                    />

                                    <Button
                                        type="submit"
                                        variant="outline"
                                        size="sm"
                                    >
                                        Add
                                    </Button>
                                </form>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </CardContent>
        <CardFooter class="justify-between">
            <Button
                variant="outline"
                v-if="props.courses.current_page < props.courses.last_page"
                @click="loadMore"
            >
                Load More
            </Button>

            <Button as-child>
                <Link href="/courses/create">Create Course</Link>
            </Button>
        </CardFooter>
    </Card>
    <Dialog :open="topicToDelete !== null" @update:open="closeDeleteDialog">
        <DialogContent class="sm:max-w-md">
            <DialogHeader>
                <DialogTitle>Delete topic</DialogTitle>

                <DialogDescription>
                    Are you sure you want to delete
                    <span class="font-medium"> {{ topicToDelete?.title }} </span
                    >?
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
