<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Topic;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Course::create([
            'title' => 'Laravel 11',
            'description' => 'vue 3 ile reaktif kullanici arayuzleri olusturun',
        ]);

        Course::create([
            'title' => 'Inertia.js',
            'description' => 'Inertia.js ile Laravel ve Vue arasinda kopru kurun',
        ]);
        Course::create([
            'title' => 'Vue 3',
            'description' => 'vue 3 ile reaktif kullanici arayuzleri olusturun',
        ]);

        Topic::create([
        'course_id' => 1,
        'title' => 'Laravel 11 Kurulum',
        ]);

        Topic::create([
            'course_id' => 1,
            'title' => 'Routing',
        ]);

        Topic::create([
            'course_id' => 1,
            'title' => 'Eloquent',
        ]);

    }
}
