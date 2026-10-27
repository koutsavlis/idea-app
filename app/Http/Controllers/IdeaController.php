<?php

namespace App\Http\Controllers;

use App\Actions\CreateIdea;
use App\Actions\UpdateIdea;
use App\Http\Requests\StoreIdeaRequest;
use App\Http\Requests\UpdateIdeaRequest;
use App\IdeaStatus;
use App\Models\Idea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class IdeaController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user();

        $ideas = $user->ideas()
            ->when(
                in_array($request->status, IdeaStatus::values()),
                fn ($query) => $query->where('status', $request->status)
            )
            ->latest()
            ->get();

        return view('idea.index', [
            'ideas' => $ideas,
            'statusCounts' => Idea::statusCounts($user),
        ]);
    }

    public function store(StoreIdeaRequest $request, CreateIdea $action): RedirectResponse
    {
        $action->handle($request->safe()->all());

        return to_route('idea.index')->with('success', 'Idea created!');
    }

    public function show(Idea $idea): View
    {
        Gate::authorize('workWith', $idea);

        return view('idea.show', ['idea' => $idea]);
    }

    public function update(UpdateIdeaRequest $request, Idea $idea, UpdateIdea $action): RedirectResponse
    {
        Gate::authorize('workWith', $idea);

        $action->handle($request->safe()->all(), $idea);

        return back()->with('success', 'Idea updated!');
    }

    public function destroy(Idea $idea): RedirectResponse
    {
        Gate::authorize('workWith', $idea);

        $idea->delete();

        return to_route('idea.index');
    }
}
