<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Games</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6 space-y-4">
        <form method="GET" action="{{ route('games.index') }}" class="flex gap-2">
            <input name="q" value="{{ request('q') }}" placeholder="Zoek op titel of synopsis" class="border p-2 w-full" />

            @auth
                @if($canAddGame)
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.games.create') }}" class="border px-4 py-2 inline-block">
                            + Nieuwe game
                        </a>
                    @else
                        <a href="{{ route('my.games.create') }}" class="border px-4 py-2 inline-block">
                            + Nieuwe game
                        </a>
                    @endif
                @else
                    @if(auth()->user()->role !== 'admin')
                        <div class="border p-2">
                            Favorieten: {{ $favouritesCount ?? 0 }}/5 — favourite nog {{ 5 - ($favouritesCount ?? 0) }} games om te kunnen toevoegen.
                        </div>
                    @endif
                @endif
            @endauth


        @auth
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="only_favourites" value="1" @checked(request('only_favourites') === '1')>
                    <span>Alleen mijn favourites</span>
                </label>
            @endauth



            <select name="publisher_id" class="border p-2">
                <option value="">Alle publishers</option>
                @foreach($publishers as $publisher)
                    <option value="{{ $publisher->id }}" @selected(request('publisher_id') == $publisher->id)>
                        {{ $publisher->name }}
                    </option>
                @endforeach
            </select>

            <button class="border px-4">Zoek</button>
        </form>

        <div class="grid gap-3">
            @foreach($games as $game)
                <a href="{{ route('games.show', $game) }}" class="border p-4 block">
                    <div class="font-semibold">{{ $game->title }}</div>
                    <div class="text-sm text-gray-600">{{ $game->publisher->name }}</div>
                </a>
            @endforeach
        </div>

        {{ $games->links() }}
    </div>
</x-app-layout>
