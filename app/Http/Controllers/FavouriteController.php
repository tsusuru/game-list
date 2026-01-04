<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Game;

class FavouriteController extends Controller
{
    public function store(Game $game)
    {
        Favourite::firstOrCreate([
            'user_id' => auth()->id(),
            'game_id' => $game->id,
        ]);

        return back()->with('status', 'Toegevoegd aan favourites.');
    }

    public function destroy(Game $game)
    {
        Favourite::where('user_id', auth()->id())
            ->where('game_id', $game->id)
            ->delete();

        return back()->with('status', 'Verwijderd uit favourites.');
    }
}
