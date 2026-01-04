<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Bewerk game: {{ $game->title }}</h2>
    </x-slot>

    <div class="p-6 space-y-4">
        @if(session('status'))
            <div class="border p-2">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.games.update', $game) }}" class="space-y-4">
            @csrf
            @method('PUT')

            @include('admin.games.form', ['game' => $game])

            <button class="border px-4 py-2" type="submit">Bijwerken</button>
        </form>

        <form method="POST" action="{{ route('admin.games.destroy', $game) }}">
            @csrf
            @method('DELETE')

            <button
                class="border px-4 py-2"
                type="submit"
                onclick="return confirm('Weet je zeker dat je deze game wilt verwijderen?')"
            >
                Verwijderen
            </button>
        </form>
            <form method="POST" action="{{ route('admin.games.toggle', $game) }}">
                @csrf
                <button class="border px-4 py-2" type="submit">
                    {{ $game->is_active ? 'Zet inactief' : 'Zet actief' }}
                </button>
            </form>

    </div>
</x-app-layout>
