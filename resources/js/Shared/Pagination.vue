<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    links: Array,
});
</script>

<template>
    <div v-if="links.length > 3">
        <template v-for="(link, index) in links" :key="index">
            <Link
                v-if="link.url"
                :href="link.url"
                class="px-3 py-2"
                :class="{ 'font-bold': link.active }"
                v-html="link.label"
            />

            <span v-else class="px-3 py-2 text-gray-500" v-html="link.label" />
        </template>
    </div>
</template>
