<script setup>
import { ref, onMounted } from "vue";

const props = defineProps({
    lesson: Object,
});

const showSize = ref(true);

onMounted(() => {
    setTimeout(() => (showSize.value = false), 5000);
});
</script>

<template>
    <div class="relative mt-3">
        <video
            :src="`/storage/${lesson.video_path}`"
            controls
            class="w-full rounded-md"
        ></video>
        <div
            v-if="lesson.video_size"
            class="absolute top-2 left-2 bg-black/60 text-white text-xs px-2 py-1 rounded transition-opacity duration-500"
            :class="showSize ? 'opacity-100' : 'opacity-0'"
        >
            {{ (lesson.video_size / 1024 / 1024).toFixed(1) }} MB
        </div>
    </div>
</template>
