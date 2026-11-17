<script setup>
import { Link, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";

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
function destroy(course) {
    if (confirm(`Delete ${course.title}?`)) {
        router.delete(`/courses/${course.id}`, {
            onSuccess: () => {
                allCourses.value = allCourses.value.filter(
                    (c) => c.id !== course.id,
                );
            },
        });
    }
}
</script>

<template>
    <div>
        <p>Courses: {{ courses.data.length }}</p>
        <p>Topics: {{ Object.keys(topics).length }}</p>
    </div>

    <ul>
        <li v-for="course in allCourses" :key="course.id">
            {{ course.title }}

            <Link :href="`/courses/${course.id}/edit`"> Edit </Link>

            <button @click="destroy(course)">Delete</button>

            <ul>
                <li v-for="topic in topics[course.id]" :key="topic.id">
                    <Link :href="`/topics/${topic.id}`">
                        {{ topic.title }}
                    </Link>
                </li>
            </ul>
        </li>
    </ul>

    <button
        v-if="props.courses.current_page < props.courses.last_page"
        @click="loadMore"
    >
        Load More
    </button>
    <Link href="/courses/create">Create Course</Link>
</template>
