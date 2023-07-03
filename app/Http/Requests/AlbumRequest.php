<?php

namespace App\Http\Requests;

use App\Enums\AlbumType;
use App\Models\Artist;
use App\Models\Genre;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        dd($this->all());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'type' => ['required', Rule::enum(AlbumType::class)],
            'released_at' => ['required', 'date_format:Y-m-d'],
            'artist_id' => ['required_without:artist_name', Rule::exists(Artist::class, 'id')],
            'artist_name' => ['required_without:artist_id', 'max:255'],
            'genres' => ['required', 'array'],
            'genres.*' => [Rule::exists(Genre::class, 'id')],
        ];
    }
}
