<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import Pagination from "@/Shared/Pagination.vue";
import { watch, ref } from "vue";
import { debounce } from "lodash";


const props = defineProps({
    users: Object,
    filters: Object,
});

const search = ref(props.filters.search);

watch(
    search,
    debounce((value) => {
        router.get(
            "/users",
            { search: value },
            {
                preserveState: true,
            },
        );
    }, 300),
);
</script>

<template>
    <Head title="Users" />

    <h1 class="text-xl font-bold">Users</h1>

    <input
        type="text"
        v-model="search"
        placeholder="Search"
        class="border rounded px-3 py-2"
    />

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Edit</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="user in users.data" :key="user.id">
                <td>{{ user.name }}</td>

                <td>
                    <Link :href="`/users/${user.id}/edit`">Edit</Link>
                </td>
            </tr>
        </tbody>
    </table>

    <Pagination :links="users.links" />

    <div class="flex items-center">
        <h1 class="text-xl font-bold">Users</h1>
        <Link href="/users/create" class="ml-3 text-sm text-blue-600">
            New User
        </Link>
    </div>
</template>
