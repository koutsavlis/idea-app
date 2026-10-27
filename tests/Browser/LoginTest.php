<?php

use App\Models\User;

it('logs in a user', function () {

    $user = User::factory()->create(['password' => '12345678']);

    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', '12345678')
        ->click('@login-button')
        ->assertPathIs('/ideas');

    $this->assertAuthenticated();

});

it('logs out a user', function () {

    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/')->click('Log out');

    $this->assertGuest();

});
