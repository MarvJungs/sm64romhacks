<?php

namespace App\Http\Requests;

use App\Models\Romhackevent;
use Illuminate\Foundation\Http\FormRequest;

class StoreRomhackeventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Romhackevent::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:1|max:255|string',
            'slug' => 'required|min:1|max:255|string',
            'description' => 'required|array',
            'description.blocks' => 'required|array|min:1',
            'description.time' => 'required|numeric',
            'description.version' => 'required|string',
            'start_utc' => 'required|date',
            'end_utc' => 'required|date',
            'external' => 'required|boolean',
            'external_url' => 'required_if_accepted:external|nullable|url'
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
                'description' => json_decode($this['description'], true),
            ]
        );
    }
}
