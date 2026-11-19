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
        allCourses.value = allCourses.value.concat(newCourses.data);
    },
);

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
                        <TableHead>Topics</TableHead>
                    </TableRow>
                </TableHeader>

                <TableBody>
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
                            <ul>
                                <li
                                    v-for="topic in topics[course.id]"
                                    :key="topic.id"
                                >
                                    <Link :href="`/topics/${topic.id}`">
                                        {{ topic.title }}
                                    </Link>
                                </li>
                            </ul>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </CardContent>
        <CardFooter>
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
</template>
