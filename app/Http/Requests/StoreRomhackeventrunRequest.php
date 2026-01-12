<?php

namespace App\Http\Requests;

use App\Models\Romhackevent;
use App\Rules\YoutubeVideoUrl;
use Illuminate\Foundation\Http\FormRequest;

class StoreRomhackeventrunRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $event = Romhackevent::find($this->route('event'))->first();
        return $event && $this->user()->can('update', $event);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'romhack' => 'string|required',
            'category' => 'string|required',
            'type' => 'string|required',
            'author' => 'array|list|required|min:1',
            'author.*' => 'required|string',
            'videolink' => 'array|list|required|min:1',
            'videolink.*' => ['url', 'active_url', 'distinct', new YoutubeVideoUrl]
        ];
    }
}
