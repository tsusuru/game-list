@if ($errors->any())
    <div class="border p-2 mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-3">
    <div>
        <label class="block">Title</label>
        <input class="border p-2 w-full" name="title" value="{{ old('title', $game?->title ?? '') }}">
    </div>

    <div>
        <label class="block">Synopsis</label>
        <textarea class="border p-2 w-full" name="synopsis">{{ old('synopsis', $game?->synopsis ?? '') }}</textarea>
    </div>

    <div>
        <label class="block">Release date</label>
        <input
            class="border p-2 w-full"
            type="date"
            name="release_date"
            value="{{ old('release_date', optional($game?->release_date)->format('Y-m-d')) }}"
        >
    </div>

    <div>
        <label class="block">Playtime hours</label>
        <input
            class="border p-2 w-full"
            type="number"
            name="playtime_hours"
            value="{{ old('playtime_hours', $game?->playtime_hours ?? '') }}"
        >
    </div>

    <div>
        <label class="block">Publisher</label>
        <select class="border p-2 w-full" name="publisher_id">
            <option value="">Select publisher</option>
            @foreach($publishers as $publisher)
                <option value="{{ $publisher->id }}"
                    @selected(old('publisher_id', $game?->publisher_id) == $publisher->id)>
                    {{ $publisher->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block">Genre (optional)</label>
        <select class="border p-2 w-full" name="genre_id">
            <option value="">-</option>
            @foreach($genres as $genre)
                <option value="{{ $genre->id }}"
                    @selected(old('genre_id', $game?->genre_id) == $genre->id)>
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block">Developer (optional)</label>
        <select class="border p-2 w-full" name="developer_id">
            <option value="">-</option>
            @foreach($developers as $developer)
                <option value="{{ $developer->id }}"
                    @selected(old('developer_id', $game?->developer_id) == $developer->id)>
                    {{ $developer->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
