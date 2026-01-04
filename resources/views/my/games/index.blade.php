<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">My Games</h2>
    </x-slot>

    <div class="p-6 space-y-3">
        @foreach($games as $game)
            <div class="border p-3 flex items-center justify-between">
                <div>
                    <div class="font-semibold">{{ $game->title }}</div>
                    <div class="text-sm text-gray-600">
                        {{ $game->publisher?->name ?? '-' }} • Status: {{ $game->is_active ? 'Actief' : 'Inactief' }}
                    </div>
                </div>

                <div class="flex gap-2">
                    <a class="border px-3 py-2" href="{{ route('my.games.edit', $game) }}">Bewerk</a>

                    <form method="POST" action="{{ route('my.games.toggle', $game) }}">
                        @csrf
                        <button class="border px-3 py-2" type="submit">
                            {{ $game->is_active ? 'Zet inactief' : 'Zet actief' }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach


        {{ $games->links() }}
    </div>
</x-app-layout>
