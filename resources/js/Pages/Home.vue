<script setup>
import { Head, Link, usePage } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { BookOpen, Layers, TrendingUp } from "lucide-vue-next";

const page = usePage();
const user = page.props.auth?.user;
</script>

<template>
    <Head title="Home" />

    <section
        class="mx-auto flex max-w-3xl flex-col items-center gap-6 py-16 text-center"
    >
        <section class="mx-auto max-w-5xl pb-16">
            <div class="grid gap-6 sm:grid-cols-3">
                <Card>
                    <CardHeader class="flex flex-col gap-3">
                        <BookOpen class="mx-auto size-6 text-primary" />

                        <CardTitle class="text-lg font-semibold">
                            Create courses
                        </CardTitle>

                        <CardDescription class="text-sm text-muted-foreground">
                            Add and manage your courses in one place.
                        </CardDescription>
                    </CardHeader>
                </Card>

                <Card>
                    <CardHeader class="flex flex-col gap-3">
                        <Layers class="mx-auto size-6 text-primary" />

                        <CardTitle class="text-lg font-semibold">
                            Organize topics
                        </CardTitle>

                        <CardDescription class="text-sm text-muted-foreground">
                            Group related topics under each course.
                        </CardDescription>
                    </CardHeader>
                </Card>

                <Card>
                    <CardHeader class="flex flex-col gap-3">
                        <TrendingUp class="mx-auto size-6 text-primary" />

                        <CardTitle class="text-lg font-semibold">
                            Track progress
                        </CardTitle>

                        <CardDescription class="text-sm text-muted-foreground">
                            Keep your learning organized and easy to follow.
                        </CardDescription>
                    </CardHeader>
                </Card>
            </div>
        </section>

        <h1 class="text-4xl font-bold tracking-tight">
            Learn, organize and grow
        </h1>

        <p class="max-w-xl text-lg text-muted-foreground">
            Create courses, organize topics and keep your learning in one place.
        </p>

        <div class="flex flex-col items-center gap-3 sm:flex-row">
            <template v-if="user">
                <Button as-child>
                    <Link href="/courses"> Browse courses </Link>
                </Button>
            </template>

            <template v-else>
                <Button as-child>
                    <Link href="/register"> Get started </Link>
                </Button>

                <Button as-child variant="ghost">
                    <Link href="/login"> Log in </Link>
                </Button>
            </template>
        </div>
    </section>
</template>
