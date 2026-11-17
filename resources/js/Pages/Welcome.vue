<script>
export default {
    props: {
        name: String,
        frameworks: Array,
    },
};
</script>

<template>
    <h1>Hello {{ name }}</h1>
    <p>in this series, we will use the following frameworks:</p>
    <ul>
        <li v-for="framework in frameworks" :key="frameworks">
            {{ framework }}
        </li>
    </ul>
</template>
