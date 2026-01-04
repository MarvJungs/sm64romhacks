<?php

namespace App\Http\Requests;

use App\Rules\YoutubeVideoUrl;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRomhackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'romhack.name' => 'required|string',
            'romhack.description' => 'required|array',
            'romhack.description.blocks' => 'required|array|min:1',
            'romhack.description.time' => 'required|numeric',
            'romhack.description.version' => 'required|string',
            'romhack.videolink' => ['url', 'nullable', new YoutubeVideoUrl],
            'romhack.megapack' => 'boolean',
            'romhack.tag' => 'nullable|array',
            'romhack.image' => 'array|distinct|min:1',
            'romhack.image.*' => 'required|image|dimensions:ratio=4/3'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge(
            [
                'romhack.description' => json_decode($this->romhack['description'], true),
            ]
        );
    }
}
