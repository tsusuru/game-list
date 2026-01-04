<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Publisher;


class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('publisher', 'owner')->latest()->paginate(15);
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        return view('admin.games.create', [
            'publishers' => Publisher::orderBy('name')->get(),
            'genres' => Genre::orderBy('name')->get(),
            'developers' => Developer::orderBy('name')->get(),
        ]);
    }

    public function store(StoreGameRequest $request)
    {
        $game = Game::create($request->validated() + ['user_id' => auth()->id()]);
        return redirect()->route('admin.games.edit', $game)->with('status', 'Game aangemaakt.');
    }

    public function edit(Game $game)
    {
        $this->authorize('update', $game);

        return view('admin.games.edit', [
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

    public function destroy(Game $game)
    {
        $this->authorize('delete', $game);

        $game->delete();

        return redirect()->route('admin.games.index')->with('status', 'Game verwijderd.');
    }

    // verplicht criterium: status togglen via POST naar aparte action
    public function toggleActive(Game $game)
    {
        $game->update(['is_active' => ! $game->is_active]);

        return back()->with('status', 'Status aangepast.');
    }
}
