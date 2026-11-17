<script setup>
import { Link } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { LogOut } from "@lucide/vue";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const user = computed(() => page.props.auth.user);
</script>

<template>
    <nav class="flex items-center gap-2 border-b p-4">
        <Button as-child variant="ghost">
            <Link href="/">Home</Link>
        </Button>

        <Button as-child variant="ghost">
            <Link href="/courses">Courses</Link>
        </Button>

        <Button as-child variant="ghost">
            <Link href="/courses/create">Create Course</Link>
        </Button>

        <div class="ml-auto flex items-center gap-2">
            <template v-if="user">
                <Button as-child variant="destructive">
                    <Link href="/logout" method="post">
                        <LogOut class="mr-2 h-4 w-4" />
                        Log Out
                    </Link>
                </Button>
            </template>

            <template v-else>
                <Button as-child variant="outline">
                    <Link href="/login">Login</Link>
                </Button>

                <Button as-child>
                    <Link href="/register">Register</Link>
                </Button>
            </template>
        </div>
    </nav>
</template>
