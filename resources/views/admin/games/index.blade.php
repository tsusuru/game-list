<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Admin - Games</h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6 space-y-4">
        @if(session('status'))
            <div class="border p-2">{{ session('status') }}</div>
        @endif

        <a class="border px-3 py-2 inline-block" href="{{ route('admin.games.create') }}">Nieuwe game</a>

        <div class="space-y-2">
            @foreach($games as $game)
                <div class="border p-3 flex items-center justify-between">
                    <div>
                        <div class="font-semibold">{{ $game->title }}</div>
                        <div class="text-sm text-gray-600">
                            {{ $game->publisher->name }} • Owner: {{ $game->owner->email }}
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a class="border px-3 py-2" href="{{ route('admin.games.edit', $game) }}">Bewerk</a>

                        <form method="POST" action="{{ route('admin.games.toggle', $game) }}">
                            @csrf
                            <button class="border px-3 py-2" type="submit">
                                {{ $game->is_active ? 'Actief' : 'Inactief' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{ $games->links() }}
    </div>
</x-app-layout>
