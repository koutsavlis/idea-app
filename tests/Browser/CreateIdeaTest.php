<?php

use App\Models\User;

it('creates a new idea', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'My First Idea')
        ->click('@button-status-completed')
        ->fill('description', 'This is a description of my first idea.')
        ->fill('@new-link', 'https://laracasts.com')
        ->click('@submit-new-link-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($user->ideas()->first())->toMatchArray([
        'title' => 'My First Idea',
        'description' => 'This is a description of my first idea.',
        'status' => 'completed',
        'links' => ['https://laracasts.com'],
    ]);
});
