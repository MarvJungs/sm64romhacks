<?php

namespace App\Http\Requests;

use App\Models\Newspost;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNewspostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->newspost && $this->user()->can('update', $this->newspost);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'text' => 'required|array',
            'text.blocks' => 'required|array|min:1',
            'text.time' => 'required|numeric',
            'text.version' => 'required|string'
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
                'text' => json_decode($this->text, true)
            ]
        );
    }
}
