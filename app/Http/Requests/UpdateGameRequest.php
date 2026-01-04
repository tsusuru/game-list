<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check(); // admin routes zijn al afgeschermd via middleware
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
