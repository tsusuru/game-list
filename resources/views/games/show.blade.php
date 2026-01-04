<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl">{{ $game->title }}</h2>

            <div>
                @auth
                    @if($isFavourited)
                        <form method="POST" action="{{ route('favourites.destroy', $game) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border px-3 py-2 inline-flex items-center gap-2" aria-label="Unfavourite">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.966a1 1 0 00.95.69h4.17c.969 0 1.371 1.24.588 1.81l-3.372 2.45a1 1 0 00-.364 1.118l1.287 3.966c.3.921-.755 1.688-1.539 1.118l-3.372-2.45a1 1 0 00-1.175 0l-3.372 2.45c-.783.57-1.838-.197-1.539-1.118l1.287-3.966a1 1 0 00-.364-1.118L2.045 9.393c-.783-.57-.38-1.81.588-1.81h4.17a1 1 0 00.95-.69l1.286-3.966z"/>
                                </svg>
                                <span>Favourited</span>
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('favourites.store', $game) }}">
                            @csrf
                            <button type="submit" class="border px-3 py-2 inline-flex items-center gap-2" aria-label="Favourite">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l2.1 6.472a1 1 0 00.95.69h6.804c.969 0 1.371 1.24.588 1.81l-5.506 4a1 1 0 00-.364 1.118l2.1 6.472c.3.921-.755 1.688-1.539 1.118l-5.506-4a1 1 0 00-1.176 0l-5.506 4c-.783.57-1.838-.197-1.539-1.118l2.1-6.472a1 1 0 00-.364-1.118l-5.506-4c-.783-.57-.38-1.81.588-1.81h6.804a1 1 0 00.95-.69l2.1-6.472z" />
                                </svg>
                                <span>Add favourite</span>
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6 space-y-4">
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

            <div class="border rounded-lg overflow-hidden w-full sm:w-80">
                <img
                    src="{{ asset('images/game-placeholder.svg') }}"
                    alt="Voorbeeld cover"
                    class="w-full h-44 object-cover"
                >
            </div>


            <div class="border p-4 space-y-2">
            <div><strong>Publisher:</strong> {{ $game->publisher?->name ?? '-' }}</div>
            <div><strong>Genre:</strong> {{ $game->genre?->name ?? '-' }}</div>
            <div><strong>Developer:</strong> {{ $game->developer?->name ?? '-' }}</div>
            <div><strong>Release:</strong> {{ $game->release_date?->format('Y-m-d') ?? '-' }}</div>
            <div><strong>Playtime (hrs):</strong> {{ $game->playtime_hours ?? '-' }}</div>
        </div>

        @if($game->synopsis)
            <div class="border p-4">
                {{ $game->synopsis }}
            </div>
        @endif

        <div class="flex items-center justify-between">
            <a class="underline" href="{{ route('games.index') }}">← Terug</a>

            @auth
                @if(auth()->user()->role === 'admin')
                    <a class="border px-3 py-2" href="{{ route('admin.games.edit', $game) }}">Bewerk</a>
                @elseif(auth()->id() === $game->user_id)
                    <a class="border px-3 py-2" href="{{ route('my.games.edit', $game) }}">Bewerk</a>
                @endif
            @endauth
        </div>
    </div>
</x-app-layout>
