<script setup>
import { usePage } from "@inertiajs/vue3";
import NavLink from "./NavLink.vue";

const page = usePage();
</script>

<template>
    <nav>
        <NavLink href="/" :active="page.component === 'Home'"> Home </NavLink>

        <NavLink href="/users" :active="page.component === 'Users'">
            Users
        </NavLink>

        <NavLink href="/settings" :active="page.component === 'Settings'">
            Settings
        </NavLink>

        <NavLink href="/dashboard" :active="page.component === 'Dashboard'">
            Dashboard
        </NavLink>

        <NavLink href="/login">Login</NavLink>
        <NavLink href="/register">Register</NavLink>

        <NavLink href="/logout" method="post" as="button"> Log Out </NavLink>
    </nav>
</template>
