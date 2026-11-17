<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    active: Boolean,
});
</script>

<template>
    <Link class="block px-3 py-2" :class="active ? 'font-bold underline' : ''"
        ><slot
    /></Link>
</template>
