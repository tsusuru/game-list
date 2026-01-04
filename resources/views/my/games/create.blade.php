<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Nieuwe game</h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('my.games.store') }}" class="space-y-4">
            @csrf

            @include('admin.games.form', ['game' => null])

            <button class="border px-4 py-2" type="submit">Opslaan</button>
        </form>
    </div>
</x-app-layout>
