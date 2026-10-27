<?php

use App\Models\Step;
use App\Models\User;

test('the owner can toggle a step', function () {
    $step = Step::factory()->create();

    $this->actingAs($step->idea->user)
        ->patch(route('step.update', $step))
        ->assertRedirect();

    expect($step->fresh()->completed)->toBeTrue();
});

test('another user cannot toggle a step', function () {
    $step = Step::factory()->create();

    $this->actingAs(User::factory()->create())
        ->patch(route('step.update', $step))
        ->assertForbidden();

    expect($step->fresh()->completed)->toBeFalse();
});