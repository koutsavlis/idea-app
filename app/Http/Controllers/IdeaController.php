<?php

namespace App\Http\Controllers;

use App\Actions\CreateIdea;
use App\Actions\UpdateIdea;
use App\Models\Idea;
use App\IdeaStatus;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // $ideas = Auth::user()->ideas()->get();

        $ideas = $user
            ->ideas()
            ->when(in_array($request->status, IdeaStatus::values()), fn($query) => $query->where('status', $request->status))
            ->latest()
            ->get();

        return view('idea.index', [
            'ideas' => $ideas,
            'statusCounts' => Idea::statusCounts($user),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request, CreateIdea $action)
    {
        // dd($request->all());
        // dd($request->validated());
        // dd($request->safe());
        // dd($request->safe()->only('title'));
        // dd($request->steps);
        // dd($request->safe()->except('steps'));

        // // Kanei insert ta pedia ston pinaka ideas
        // $idea = Auth::user()->ideas()->create($request->safe()->except('steps', 'image'));

        // // Kanei insert ta pedia ston pinaka steps
        // $idea->steps()->createMany(
        //     collect($request->steps)->map(fn ($step) => ['description' => $step])
        // );

        // // Kanoume upload thn photo san arxeio
        // $imagePath = $request->image->store('ideas', 'public');

        // // Enhmeronoume ton pinaka gia to path ths photo
        // $idea->update([
        //     'image_path' => $imagePath
        // ]);

        $action->handle($request->safe()->all());

        return to_route('idea.index')->with('success', 'Idea created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        return view('idea.show', [
            'idea' => $idea,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        Gate::authorize('workWith', $idea);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea, UpdateIdea $action)
    {
        // dd($request->validated());
        Gate::authorize('workWith', $idea);

        $action->handle($request->safe()->all(), $idea);

        return back()->with('success', 'Idea updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        Gate::authorize('workWith', $idea);
        
        $idea->delete();

        return to_route('idea.index');
    }
}
