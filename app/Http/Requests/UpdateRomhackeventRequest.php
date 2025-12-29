<?php

namespace App\Http\Requests;

use App\Models\Romhackevent;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRomhackeventRequest extends FormRequest
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
            'name' => 'required|min:1|max:255|string',
            'slug' => 'required|min:1|max:255|string',
            'description' => 'required|json',
            'start_utc' => 'required|date',
            'end_utc' => 'required|date',
            'external' => 'required|boolean',
            'external_url' => 'required_if_accepted:external|nullable|url'
        ];
    }
}
