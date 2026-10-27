<?php

namespace Database\Seeders;

use App\IdeaStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'demo@example.com'],
            ['name' => 'Demo User', 'password' => 'password'],
        );

        // Idempotent: αν ο demo user έχει ήδη ιδέες, δεν ξαναγράφουμε
        if ($user->ideas()->exists()) {
            return;
        }

        foreach ($this->ideas() as $data) {
            $steps = $data['steps'];
            unset($data['steps']);

            $user->ideas()->create($data)->steps()->createMany($steps);
        }
    }

    private function ideas(): array
    {
        return [
            [
                'title' => 'Launch a personal developer blog',
                'description' => "Write about what I learn while building Laravel apps.\n\nStart with one post per week.",
                'status' => IdeaStatus::IN_PROGRESS,
                'links' => ['https://laravel.com/docs'],
                'steps' => [
                    ['description' => 'Pick a domain name', 'completed' => true],
                    ['description' => 'Set up the Laravel project', 'completed' => true],
                    ['description' => 'Write the first post', 'completed' => false],
                    ['description' => 'Share it on LinkedIn', 'completed' => false],
                ],
            ],
            [
                'title' => 'Build a recipe sharing app',
                'description' => 'Users can upload recipes with photos, tag ingredients and save favourites.',
                'status' => IdeaStatus::PENDING,
                'links' => [],
                'steps' => [
                    ['description' => 'Design the database schema', 'completed' => false],
                    ['description' => 'Sketch the main screens', 'completed' => false],
                ],
            ],
            [
                'title' => 'Learn Pest browser testing',
                'description' => 'Cover the main user flows of my apps with browser tests.',
                'status' => IdeaStatus::COMPLETED,
                'links' => ['https://pestphp.com/docs/browser-testing'],
                'steps' => [
                    ['description' => 'Install the Playwright plugin', 'completed' => true],
                    ['description' => 'Test registration and login', 'completed' => true],
                    ['description' => 'Test creating an idea', 'completed' => true],
                ],
            ],
            [
                'title' => 'Run a half marathon',
                'description' => 'Train three times a week and finish in under 2 hours.',
                'status' => IdeaStatus::PENDING,
                'links' => [],
                'steps' => [
                    ['description' => 'Find a training plan', 'completed' => true],
                    ['description' => 'Buy proper running shoes', 'completed' => false],
                ],
            ],
        ];
    }
}