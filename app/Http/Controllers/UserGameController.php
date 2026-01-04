<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Publisher;
use App\Models\Genre;
use App\Models\Developer;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;

class UserGameController extends Controller
{
    public function index()
    {
        $games = Game::where('user_id', auth()->id())
            ->with('publisher')
            ->latest()
            ->paginate(10);

        return view('my.games.index', compact('games'));
    }

    public function create()
    {
        return view('my.games.create', [
            'publishers' => Publisher::orderBy('name')->get(),
            'genres' => Genre::orderBy('name')->get(),
            'developers' => Developer::orderBy('name')->get(),
        ]);
    }

    public function store(StoreGameRequest $request)
    {
        $game = Game::create($request->validated() + [
                'user_id' => auth()->id(),
                'is_active' => true,
            ]);

        return redirect()->route('my.games.edit', $game)->with('status', 'Game aangemaakt.');
    }

    public function edit(Game $game)
    {
        $this->authorize('update', $game);

        return view('my.games.edit', [
            'game' => $game,
            'publishers' => Publisher::orderBy('name')->get(),
            'genres' => Genre::orderBy('name')->get(),
            'developers' => Developer::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateGameRequest $request, Game $game)
    {
        $this->authorize('update', $game);

        $game->update($request->validated());

        return back()->with('status', 'Game bijgewerkt.');
    }

    public function toggleActive(Game $game)
    {
        $this->authorize('update', $game);

        $game->update(['is_active' => ! $game->is_active]);

        return back()->with('status', 'Status aangepast.');
    }
}
