<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\Favourite;

class StoreGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        // (Optioneel) Admin altijd toestaan
        if (auth()->user()->role === 'admin') {
            return true;
        }

        // Losse Eloquent query: tel favourites van deze user
        $favCount = Favourite::where('user_id', auth()->id())->count();

        return $favCount >= 5;
    }

    protected function failedAuthorization(): void
    {
        throw new AuthorizationException(
            'Je mag pas een game toevoegen nadat je minimaal 5 favourites hebt.'
        );
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:2', 'max:120'],
            'synopsis' => ['nullable', 'string', 'max:2000'],
            'release_date' => ['nullable', 'date'],
            'playtime_hours' => ['nullable', 'integer', 'min:0', 'max:2000'],
            'publisher_id' => ['required', 'exists:publishers,id'],
            'genre_id' => ['nullable', 'exists:genres,id'],
            'developer_id' => ['nullable', 'exists:developers,id'],
        ];
    }
}
