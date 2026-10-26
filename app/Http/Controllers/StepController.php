<?php

namespace App\Http\Controllers;

use App\Models\Step;
use App\Http\Requests\StoreStepRequest;
use App\Http\Requests\UpdateStepRequest;

class StepController extends Controller
{

    /**
     * Update the specified resource in storage.
     */
    public function update(Step $step)
    {
        // authorization

        $step->update(['completed' => ! $step->completed]);

        return back()->with('success', 'Step updated!');
    }

}