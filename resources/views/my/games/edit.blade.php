<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Bewerk: {{ $game->title }}</h2>
    </x-slot>

    <div class="p-6 space-y-4">

        @if(session('status'))
            <div class="border p-2">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="border p-2">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('my.games.update', $game) }}" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- hergebruik jouw admin form partial --}}
            @include('admin.games.form', ['game' => $game])

            <button class="border px-4 py-2" type="submit">Bijwerken</button>
        </form>

            <form method="POST" action="{{ route('my.games.toggle', $game) }}">
                @csrf
                <button class="border px-4 py-2" type="submit">
                    {{ $game->is_active ? 'Zet inactief' : 'Zet actief' }}
                </button>
            </form>


    </div>
</x-app-layout>
