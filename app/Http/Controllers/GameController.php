<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Publisher;
use App\Models\Favourite;
use Illuminate\Database\Eloquent\Builder;

class GameController extends Controller
{
    public function index()
    {
        $query = Game::query()
            ->with('publisher')
            ->where('is_active', true);

        if ($q = request('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('synopsis', 'like', "%{$q}%");
            });
        }

        if ($publisherId = request('publisher_id')) {
            $query->where('publisher_id', $publisherId);
        }

        if (auth()->check() && request('only_favourites') === '1') {
            $query->whereHas('favourites', function ($favQuery) {
                $favQuery->where('user_id', auth()->id());
            });
        }

        $games = $query->orderBy('title')->paginate(12)->withQueryString();
        $publishers = Publisher::orderBy('name')->get();

        // ✅ UI gate: Add game button pas tonen bij >= 5 favourites (of admin)
        $canAddGame = false;
        $favouritesCount = null;

        if (auth()->check()) {
            if (auth()->user()->role === 'admin') {
                $canAddGame = true;
            } else {
                $favouritesCount = Favourite::where('user_id', auth()->id())->count(); // losse Eloquent query
                $canAddGame = $favouritesCount >= 5;
            }
        }

        return view('games.index', compact('games', 'publishers', 'canAddGame', 'favouritesCount'));
    }


    public function show(Game $game)
    {
        abort_unless($game->is_active, 404);

        $game->load(['publisher', 'genre', 'developer', 'owner']);

        $isFavourited = auth()->check()
            ? Favourite::where('user_id', auth()->id())
                ->where('game_id', $game->id)
                ->exists()
            : false;

        return view('games.show', compact('game', 'isFavourited'));
    }
}
